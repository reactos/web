<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Fills base_revision, base_order, base_exact, ref and pr_number for runs
 *              that were submitted before the writer knew how to resolve them
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	if (PHP_SAPI !== "cli")
		die("This script must be run from the command line.\n");

	date_default_timezone_set("UTC");
	set_time_limit(0);

	// The BuildBot index is a six figure number of builds held in memory at once. This is
	// a one-off maintenance script, so it gets to be greedy rather than clever about it.
	ini_set("memory_limit", "-1");

	define("BUILDBOT_API", "https://build.reactos.org/api/v2");
	define("GITHUB_API", "https://api.github.com/repos/reactos/reactos");
	define("USER_AGENT", "reactos-web-testman-backfill");

	// How many build numbers to ask the BuildBot about in one request. It answers a
	// 1000-wide window in a couple of seconds; the point of the window is that the whole
	// archive costs a few hundred requests instead of one per run.
	define("BUILD_WINDOW", 1000);

	// Runs updated per transaction, and per checkpoint of the resume file.
	define("RUN_BATCH", 500);

	// Builders that run the "prepare_source" step, whose log is where the base of a PR
	// build comes from. Taken from master.cfg in the buildbot_config repository; a
	// builder that is not in this list simply never gets asked for a log.
	$PREPARE_SOURCE_BUILDERS = array(
		"Build GCCLin_x86",
		"Build MSVC_x64",
		"Build GCCWin_x86",
		"Build MSVC_x86",
		"Build GCCLin_x86 Release",
		"Test WHS",
	);

	$config_dir = __DIR__ . "/../../www/www.reactos.org_config/";
	require_once($config_dir . "testman-connect.php");
	require_once($config_dir . "gitinfo-connect.php");


	//// OPTIONS ////

	function usage()
	{
		die(
			"Usage: php backfill-run-anchors.php [options]\n" .
			"\n" .
			"  --cache=DIR    Where to keep the BuildBot index and the resume point.\n" .
			"                 Default: " . default_cache_dir() . "\n" .
			"  --limit=N      Stop after N runs. Default: no limit.\n" .
			"  --restart      Ignore the resume point and start at the oldest run again.\n" .
			"  --dry-run      Resolve everything and report, but write nothing.\n" .
			"  --refresh      Re-sweep the BuildBot build index even if it is cached.\n" .
			"\n" .
			"Safe to interrupt and re-run: progress is checkpointed per batch and every\n" .
			"BuildBot and GitHub answer is cached, so a second run costs almost nothing.\n" .
			"\n" .
			"Set GITHUB_TOKEN. Master builds, refs and pull request numbers come entirely\n" .
			"from gitinfo and the BuildBot, but the base of a pull request build does not:\n" .
			"the BuildBot logs it and its janitor prunes those logs after a few hundred\n" .
			"builds, so anything older is resolved through GitHub. Without a token that is\n" .
			"60 requests an hour rather than 5000, and the script stops and asks to be\n" .
			"re-run instead of filling the rest of the archive with clock guesses.\n"
		);
	}

	function default_cache_dir()
	{
		return rtrim(sys_get_temp_dir(), "/\\") . DIRECTORY_SEPARATOR . "testman-backfill";
	}

	$options = array("cache" => default_cache_dir(), "limit" => 0, "restart" => FALSE, "dry-run" => FALSE, "refresh" => FALSE);

	foreach (array_slice($argv, 1) as $arg)
	{
		if (preg_match("#^--(cache|limit)=(.+)$#", $arg, $m))
			$options[$m[1]] = ($m[1] === "limit") ? (int)$m[2] : $m[2];
		else if (in_array($arg, array("--restart", "--dry-run", "--refresh")))
			$options[substr($arg, 2)] = TRUE;
		else
			usage();
	}

	if (!is_dir($options["cache"]) && !@mkdir($options["cache"], 0777, TRUE))
		die("Could not create the cache directory " . $options["cache"] . "\n");


	//// HELPERS ////

	function progress($message)
	{
		echo $message . "\n";
		flush();
	}

	/**
	 * A GET that gives the far end the benefit of the doubt twice before failing.
	 *
	 * @param int $status
	 * Out. The HTTP status of the last attempt, which callers need to tell a commit that
	 * is gone apart from a rate limit that will lift.
	 *
	 * @return
	 * The body, or NULL if the server answered 4xx. A missing build, a missing log and an
	 * exhausted rate limit are all normal outcomes here, not errors.
	 */
	function http_get($url, $headers = "", &$status = NULL)
	{
		for ($attempt = 1; $attempt <= 3; $attempt++)
		{
			$context = stream_context_create(array(
				"http" => array(
					"method" => "GET",
					"header" => "User-Agent: " . USER_AGENT . "\r\n" . $headers,
					"timeout" => 120,
					"ignore_errors" => TRUE,
				)
			));

			$body = @file_get_contents($url, FALSE, $context);
			$status = 0;

			foreach (isset($http_response_header) ? $http_response_header : array() as $header)
			{
				if (preg_match("#^HTTP/[0-9.]+ ([0-9]{3})#", $header, $m))
					$status = (int)$m[1];
			}

			// Retrying a 4xx just asks the same question again and gets the same answer.
			if ($status >= 400 && $status < 500)
				return NULL;

			if ($body !== FALSE && $status >= 200 && $status < 300)
				return $body;

			if ($attempt < 3)
				sleep($attempt * 2);
		}

		throw new RuntimeException("Could not fetch $url (HTTP $status)");
	}

	function http_get_json($url, $headers = "")
	{
		$body = http_get($url, $headers);
		if ($body === NULL)
			return NULL;

		$data = json_decode($body, TRUE);
		if (!is_array($data))
			throw new RuntimeException("Unexpected response from $url");

		return $data;
	}

	function cache_path($name)
	{
		global $options;
		return $options["cache"] . DIRECTORY_SEPARATOR . $name;
	}

	function cache_read($name)
	{
		$path = cache_path($name);
		if (!is_file($path))
			return NULL;

		$data = json_decode(file_get_contents($path), TRUE);
		return is_array($data) ? $data : NULL;
	}

	function cache_write($name, $data)
	{
		// Write and rename, so an interrupted run cannot leave a half-written index that
		// the next one would happily believe.
		$path = cache_path($name);
		$tmp = $path . ".tmp";

		file_put_contents($tmp, json_encode($data));
		rename($tmp, $path);
	}

	function connect($host, $name, $user, $pass)
	{
		$dbh = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbh;
	}


	//// BUILDBOT ////

	/**
	 * The BuildBot's builders, as name => id.
	 */
	function get_builders()
	{
		static $builders = NULL;

		if ($builders === NULL)
		{
			$builders = cache_read("builders.json");

			if ($builders === NULL)
			{
				$builders = array();

				foreach (http_get_json(BUILDBOT_API . "/builders")["builders"] as $builder)
					$builders[$builder["name"]] = (int)$builder["builderid"];

				cache_write("builders.json", $builders);
			}
		}

		return $builders;
	}

	/**
	 * Every build of one builder, as number => array(branch, got_revision).
	 *
	 * Swept in windows rather than one request per build: the whole archive of a builder
	 * is a hundred or so requests this way, and it is cached on disk afterwards, so a
	 * re-run of this script does not touch the BuildBot at all.
	 */
	function get_builder_builds($builder_id)
	{
		global $options;
		static $indexes = array();

		if (isset($indexes[$builder_id]))
			return $indexes[$builder_id];

		$name = "builder-$builder_id-builds.json";
		$index = $options["refresh"] ? NULL : cache_read($name);

		if ($index === NULL)
			$index = array("swept_to" => 0, "builds" => array());

		// Where the builder is now. Anything above what we swept last time is new.
		$latest = http_get_json(BUILDBOT_API . "/builders/$builder_id/builds?limit=1&order=-number&field=number");
		$max = ($latest === NULL || !count($latest["builds"])) ? 0 : (int)$latest["builds"][0]["number"];

		for ($from = (int)$index["swept_to"] + 1; $from <= $max; $from += BUILD_WINDOW)
		{
			$to = min($from + BUILD_WINDOW - 1, $max);
			$url = BUILDBOT_API . "/builders/$builder_id/builds?number__ge=$from&number__le=$to" .
			       "&property=branch&property=got_revision&field=number&field=properties";

			$page = http_get_json($url);

			foreach ((($page === NULL || !isset($page["builds"])) ? array() : $page["builds"]) as $build)
			{
				$props = isset($build["properties"]) ? $build["properties"] : array();
				$branch = isset($props["branch"]) ? $props["branch"][0] : NULL;
				$revision = isset($props["got_revision"]) ? $props["got_revision"][0] : NULL;

				// Builds from before the BuildBot recorded these are of no use to us and
				// only make the index bigger.
				if ($branch === NULL && $revision === NULL)
					continue;

				$index["builds"][(string)$build["number"]] = array($branch, $revision);
			}

			$index["swept_to"] = $to;
			progress(sprintf("  builder %d: swept up to build %d/%d (%d indexed)", $builder_id, $to, $max, count($index["builds"])));
			cache_write($name, $index);
		}

		$indexes[$builder_id] = $index["builds"];
		return $indexes[$builder_id];
	}

	/**
	 * Which build of a prepare_source builder produced a given commit, as
	 * array(builder_id, number). Built once across every such builder and cached.
	 */
	function find_prepare_source_build($revision)
	{
		global $PREPARE_SOURCE_BUILDERS;
		static $by_revision = NULL;

		if ($by_revision === NULL)
		{
			$builders = get_builders();
			$by_revision = array();

			foreach ($PREPARE_SOURCE_BUILDERS as $name)
			{
				if (!isset($builders[$name]))
				{
					progress("  note: the BuildBot has no builder named '$name', skipping it");
					continue;
				}

				$id = $builders[$name];

				foreach (get_builder_builds($id) as $number => $build)
				{
					// First one wins: they all built the same commit, and re-fetching a
					// second log for it would tell us the same thing.
					if ($build[1] !== NULL && !isset($by_revision[$build[1]]))
						$by_revision[$build[1]] = array($id, (int)$number);
				}
			}
		}

		return isset($by_revision[$revision]) ? $by_revision[$revision] : NULL;
	}

	/**
	 * The abbreviated first parent of a commit, read out of the "git show" output that
	 * prepare_source prints.
	 *
	 * For refs/pull/N/merge that first parent is the base by construction: GitHub builds
	 * the merge ref as "PR head merged into master", so parent 1 is the master commit it
	 * was merged into. A single-parent commit has no "Merge:" line and returns NULL.
	 */
	function parse_merge_parent($log, $revision)
	{
		// Guard against reading the wrong build's log entirely.
		if (!preg_match("#^commit ([0-9a-f]{40})$#m", $log, $m) || $m[1] !== $revision)
			return NULL;

		if (!preg_match("#^Merge: ([0-9a-f]{7,40}) [0-9a-f]{7,40}\s*$#m", $log, $m))
			return NULL;

		return $m[1];
	}


	//// GITINFO ////

	function gitinfo_order($dbh, $rev_hash)
	{
		$stmt = $dbh->prepare("SELECT id FROM master_revisions WHERE rev_hash = :rev_hash");
		$stmt->execute(array(":rev_hash" => $rev_hash));
		$id = $stmt->fetchColumn();

		return ($id === FALSE) ? NULL : (int)$id;
	}

	/**
	 * Resolves the abbreviated hash out of a "Merge:" line, as array(rev_hash, id).
	 * An ambiguous prefix resolves to nothing rather than to a guess.
	 */
	function gitinfo_resolve_prefix($dbh, $prefix)
	{
		$stmt = $dbh->prepare("SELECT id, rev_hash FROM master_revisions WHERE rev_hash LIKE :prefix LIMIT 2");
		$stmt->execute(array(":prefix" => $prefix . "%"));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return (count($rows) === 1) ? array($rows[0]["rev_hash"], (int)$rows[0]["id"]) : NULL;
	}

	function gitinfo_at_time($dbh, $timestamp)
	{
		$stmt = $dbh->prepare("SELECT id FROM master_revisions WHERE commit_timestamp <= FROM_UNIXTIME(:timestamp) ORDER BY id DESC LIMIT 1");
		$stmt->execute(array(":timestamp" => (int)$timestamp));
		$id = $stmt->fetchColumn();

		return ($id === FALSE) ? NULL : (int)$id;
	}

	/**
	 * Which of these revisions are master commits, as rev_hash => id.
	 */
	function gitinfo_orders($dbh, $revisions)
	{
		if (!count($revisions))
			return array();

		$placeholders = implode(",", array_fill(0, count($revisions), "?"));
		$stmt = $dbh->prepare("SELECT id, rev_hash FROM master_revisions WHERE rev_hash IN ($placeholders)");
		$stmt->execute(array_values($revisions));

		$orders = array();

		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
			$orders[$row["rev_hash"]] = (int)$row["id"];

		return $orders;
	}


	//// BASE RESOLUTION ////

	/**
	 * The master commit a PR build sits on top of, as array(rev_hash, id), or NULL.
	 *
	 * Cached per revision including the failures, because a revision that cannot be
	 * resolved once will not resolve on the next run either, and re-running this script
	 * should not mean re-fetching the same logs.
	 */
	function resolve_pr_base($gitinfo, $revision, $ref, &$stats)
	{
		static $cache = NULL;

		if ($cache === NULL)
		{
			$cache = cache_read("bases.json");
			if ($cache === NULL)
				$cache = array();
		}

		if (!array_key_exists($revision, $cache))
		{
			$cache[$revision] = resolve_pr_base_uncached($gitinfo, $revision, $ref, $stats);

			// Cheap enough to persist every time: this file is the expensive thing to
			// rebuild, and the script is meant to survive being killed.
			cache_write("bases.json", $cache);
		}

		$base = $cache[$revision];
		if ($base === NULL)
			return NULL;

		// The hash is cached, its ordinal is not: gitinfo may have ingested the commit
		// since the last run, which turns a previously unplaceable base into a placeable
		// one without another network round trip.
		$order = gitinfo_order($gitinfo, $base);

		return ($order === NULL) ? array($base, NULL) : array($base, $order);
	}

	function resolve_pr_base_uncached($gitinfo, $revision, $ref, &$stats)
	{
		// First choice: the BuildBot logged the base itself at build time, in the "git
		// show" output of prepare_source. Free, and no rate limit.
		//
		// It only reaches back a few hundred builds though. The janitor prunes log
		// contents and leaves the metadata behind, so an old build still lists its stdio
		// log and still answers 200 for it - with an empty body. Hence the emptiness
		// check: this path covers recent builds, and GitHub covers the archive.
		$build = find_prepare_source_build($revision);

		if ($build !== NULL)
		{
			$log = http_get(BUILDBOT_API . "/builders/{$build[0]}/builds/{$build[1]}/steps/prepare_source/logs/stdio/raw");

			if ($log === NULL || trim($log) === "")
			{
				$stats["log_pruned"]++;
			}
			else
			{
				$prefix = parse_merge_parent($log, $revision);

				if ($prefix !== NULL)
				{
					$resolved = gitinfo_resolve_prefix($gitinfo, $prefix);

					if ($resolved !== NULL)
					{
						$stats["base_from_buildbot"]++;
						return $resolved[0];
					}

					// A real commit that gitinfo cannot place, or an ambiguous prefix.
					// GitHub answers with the full hash, so it is worth asking.
					$stats["base_prefix_unresolved"]++;
				}
			}
		}

		return resolve_base_from_github($revision, $ref, $stats);
	}

	/**
	 * Raised when GitHub says to come back later. Not an error to swallow: writing a
	 * clock guess for a run whose base is perfectly recoverable would bake the guess in,
	 * because the next run of this script only looks at rows that are still unanchored.
	 */
	class RateLimitException extends RuntimeException
	{
	}

	function github_get_json($url, &$stats)
	{
		$token = getenv("GITHUB_TOKEN");
		$headers = ($token ? "Authorization: Bearer $token\r\n" : "") . "Accept: application/vnd.github+json\r\n";
		$status = 0;

		$body = http_get($url, $headers, $status);

		if ($status === 403 || $status === 429)
			throw new RateLimitException("GitHub rate limit reached" . ($token ? "" : " - set GITHUB_TOKEN to raise it from 60 to 5000 requests an hour"));

		if ($body === NULL)
		{
			$stats["github_missing"]++;
			return NULL;
		}

		$data = json_decode($body, TRUE);
		return is_array($data) ? $data : NULL;
	}

	/**
	 * The base of a PR build, from GitHub, for the builds whose BuildBot log is gone.
	 *
	 * The two ref kinds need different questions asked. refs/pull/N/merge is GitHub's own
	 * "PR head merged into master", so its first parent is the base by construction.
	 * refs/pull/N/head is an ordinary commit on the PR branch, whose first parent is the
	 * previous commit of that branch - the base is the merge base with master instead.
	 */
	function resolve_base_from_github($revision, $ref, &$stats)
	{
		$head = (substr((string)$ref, -5) === "/head");
		$data = github_get_json(GITHUB_API . ($head ? "/compare/master..." : "/commits/") . $revision, $stats);

		if ($data === NULL)
		{
			$stats["base_unresolved"]++;
			return NULL;
		}

		if ($head)
			$sha = isset($data["merge_base_commit"]["sha"]) ? $data["merge_base_commit"]["sha"] : NULL;
		else
			$sha = isset($data["parents"][0]["sha"]) ? $data["parents"][0]["sha"] : NULL;

		if ($sha === NULL)
		{
			$stats["base_unresolved"]++;
			return NULL;
		}

		$stats["base_from_github"]++;
		return strtolower($sha);
	}


	//// MAIN ////

	/**
	 * "Build GCCLin_x86 on Test KVM (patched)" is tested by the builder "Test KVM".
	 *
	 * The part before " on " is whichever builder compiled it, which is not the one that
	 * submitted the result. Sources without " on " are named after their builder already.
	 */
	function source_to_builder($source_name)
	{
		$name = preg_replace("#\s*\(patched\)$#", "", $source_name);
		$pos = strrpos($name, " on ");

		return ($pos === FALSE) ? $name : substr($name, $pos + 4);
	}

	/**
	 * The BuildBot build number out of "Build 41434, Reason: whatever".
	 *
	 * Only the number is structured. The "Reason" half is free text a human typed and is
	 * deliberately never parsed - it says "PR 9449" on some runs, "Bcrypt PR" on others
	 * and nothing at all on half of them.
	 */
	function comment_to_build_number($comment)
	{
		return preg_match("#^Build ([0-9]+)#", (string)$comment, $m) ? (int)$m[1] : NULL;
	}

	/**
	 * Both "master" and "refs/heads/master" mean master. The BuildBot wrote the bare form
	 * until around build 26,800 and the qualified one since.
	 */
	function normalise_ref($branch)
	{
		if ($branch === NULL || $branch === "")
			return NULL;

		return ($branch === "master") ? "refs/heads/master" : $branch;
	}

	function ref_to_pr_number($ref)
	{
		return ($ref !== NULL && preg_match("#^refs/pull/([0-9]+)/#", $ref, $m)) ? (int)$m[1] : NULL;
	}

	/**
	 * Works out the five anchor columns for one run.
	 */
	function anchor_run($run, &$stats)
	{
		global $gitinfo, $builders;

		$anchor = array("base_revision" => NULL, "base_order" => NULL, "base_exact" => 0, "ref" => NULL, "pr_number" => NULL);
		$revision = strtolower((string)$run["revision"]);
		$is_hash = (bool)preg_match("#^[0-9a-f]{40}$#", $revision);

		// The run's own commit is on master, so it is its own base. Two thirds of the
		// archive lands here, without asking anyone anything.
		//
		// gitinfo deliberately wins over the BuildBot's branch property here: it is the
		// same answer for every run that has both, it is right for the older builds that
		// have no branch property at all, and it keeps most of the archive off the
		// network entirely.
		if ($is_hash && isset($run["master_order"]))
		{
			$stats["master"]++;
			return array("base_revision" => $revision, "base_order" => $run["master_order"], "base_exact" => 1,
			             "ref" => "refs/heads/master", "pr_number" => NULL);
		}

		// Old SVN runs predate git entirely. There is no ordinal for them and inventing
		// one from the clock would place them before the first commit gitinfo has.
		if (!$is_hash)
		{
			$stats["svn"]++;
			return $anchor;
		}

		// Everything else has to be identified through the build it came from.
		$builder_name = source_to_builder($run["source_name"]);
		$number = comment_to_build_number($run["comment"]);

		if ($number !== NULL && isset($builders[$builder_name]))
		{
			$builds = get_builder_builds($builders[$builder_name]);

			if (isset($builds[(string)$number]))
			{
				list($branch, $got_revision) = $builds[(string)$number];

				// Report rather than resolve: if these disagree, one of the two databases
				// is wrong about this run and silently preferring either would hide it.
				if ($got_revision !== NULL && strtolower($got_revision) !== $revision)
				{
					$stats["revision_mismatch"]++;
					$stats["mismatches"][] = sprintf("run %d: testman has %s, %s build %d has %s",
						$run["id"], substr($revision, 0, 12), $builder_name, $number, substr((string)$got_revision, 0, 12));
				}

				$anchor["ref"] = normalise_ref($branch);
				$anchor["pr_number"] = ref_to_pr_number($anchor["ref"]);
			}
			else
			{
				$stats["build_not_found"]++;
			}
		}
		else
		{
			$stats["build_unidentified"]++;
		}

		if ($anchor["ref"] === "refs/heads/master")
		{
			// The BuildBot says master but gitinfo has never seen this commit, so it was
			// force-pushed away or gitinfo is incomplete here. The base is still exactly
			// the revision; only its position on the timeline is missing.
			$stats["master_unknown_to_gitinfo"]++;
			$anchor["base_revision"] = $revision;
			$anchor["base_exact"] = 1;
			return $anchor;
		}

		if ($anchor["pr_number"] !== NULL)
		{
			$base = resolve_pr_base($gitinfo, $revision, $anchor["ref"], $stats);

			if ($base !== NULL)
			{
				$anchor["base_revision"] = $base[0];
				$anchor["base_order"] = $base[1];
				$anchor["base_exact"] = 1;
				$stats["pr_anchored"]++;

				// Known base, but gitinfo cannot place it. Left for a later run to finish
				// rather than downgraded to a guess.
				if ($base[1] === NULL)
					$stats["base_unplaceable"]++;

				return $anchor;
			}
		}

		// Last resort. The run lands roughly where it belongs and says so with
		// base_exact = 0, rather than falling off the timeline altogether.
		$anchor["base_order"] = gitinfo_at_time($gitinfo, $run["timestamp"]);
		$stats[$anchor["base_order"] === NULL ? "unanchored" : "clock"]++;

		return $anchor;
	}

	$stats = array(
		"seen" => 0, "master" => 0, "svn" => 0, "clock" => 0, "unanchored" => 0, "pr_anchored" => 0,
		"base_from_buildbot" => 0, "base_from_github" => 0, "base_unresolved" => 0,
		"base_prefix_unresolved" => 0, "base_unplaceable" => 0, "log_pruned" => 0, "github_missing" => 0,
		"build_not_found" => 0, "build_unidentified" => 0, "master_unknown_to_gitinfo" => 0,
		"revision_mismatch" => 0, "mismatches" => array(),
	);

	try
	{
		$dbh = connect(TESTMAN_DB_HOST, TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$gitinfo = connect(GITINFO_DB_HOST, GITINFO_DB_NAME, GITINFO_DB_USER, GITINFO_DB_PASS);
		$builders = get_builders();

		$state = $options["restart"] ? NULL : cache_read("state.json");
		$last_id = ($state === NULL) ? 0 : (int)$state["last_run_id"];

		if ($last_id)
			progress("Resuming after run $last_id (--restart to start over).");

		// Only rows that are still missing something. A run that has been anchored is
		// left alone, so re-running this is cheap even without the resume point.
		$select = $dbh->prepare(
			"SELECT r.id, UNIX_TIMESTAMP(r.timestamp) AS timestamp, r.revision, r.comment, src.name AS source_name " .
			"FROM winetest_runs r JOIN sources src ON r.source_id = src.id " .
			"WHERE r.id > :last_id AND (r.base_order IS NULL OR r.ref IS NULL) " .
			"ORDER BY r.id LIMIT " . RUN_BATCH
		);

		$update = $dbh->prepare(
			"UPDATE winetest_runs SET base_revision = :base_revision, base_order = :base_order, " .
			"base_exact = :base_exact, ref = :ref, pr_number = :pr_number WHERE id = :id"
		);

		$rate_limited = NULL;

		while (!$options["limit"] || $stats["seen"] < $options["limit"])
		{
			$select->execute(array(":last_id" => $last_id));
			$runs = $select->fetchAll(PDO::FETCH_ASSOC);

			if (!count($runs))
				break;

			// One question to gitinfo for the whole batch instead of one per run.
			$hashes = array();

			foreach ($runs as $run)
			{
				if (preg_match("#^[0-9a-f]{40}$#", strtolower($run["revision"])))
					$hashes[strtolower($run["revision"])] = strtolower($run["revision"]);
			}

			$orders = gitinfo_orders($gitinfo, $hashes);
			$batch_last_id = $last_id;

			if (!$options["dry-run"])
				$dbh->beginTransaction();

			foreach ($runs as $run)
			{
				if ($options["limit"] && $stats["seen"] >= $options["limit"])
					break;

				$revision = strtolower($run["revision"]);

				if (isset($orders[$revision]))
					$run["master_order"] = $orders[$revision];

				try
				{
					$anchor = anchor_run($run, $stats);
				}
				catch (RateLimitException $e)
				{
					// Stop here rather than anchoring the rest by the clock. Everything
					// already done is committed below and the resume point stands, so
					// re-running this later picks up exactly where it left off.
					$rate_limited = $e->getMessage();
					break;
				}

				$stats["seen"]++;
				$batch_last_id = (int)$run["id"];

				if ($options["dry-run"])
					continue;

				$update->bindValue(":id", (int)$run["id"], PDO::PARAM_INT);
				$update->bindValue(":base_revision", $anchor["base_revision"], PDO::PARAM_STR);
				$update->bindValue(":base_order", $anchor["base_order"], $anchor["base_order"] === NULL ? PDO::PARAM_NULL : PDO::PARAM_INT);
				$update->bindValue(":base_exact", (int)$anchor["base_exact"], PDO::PARAM_INT);
				$update->bindValue(":ref", $anchor["ref"], PDO::PARAM_STR);
				$update->bindValue(":pr_number", $anchor["pr_number"], $anchor["pr_number"] === NULL ? PDO::PARAM_NULL : PDO::PARAM_INT);
				$update->execute();
			}

			if (!$options["dry-run"])
				$dbh->commit();

			$last_id = $batch_last_id;

			if (!$options["dry-run"])
				cache_write("state.json", array("last_run_id" => $last_id));

			progress(sprintf("  %d runs done (through run %d)", $stats["seen"], $last_id));

			if ($rate_limited !== NULL)
			{
				progress("");
				progress("Stopped: " . $rate_limited);
				progress("Re-run this script once the limit resets; it continues from run $last_id.");
				break;
			}
		}
	}
	catch (Exception $e)
	{
		if (isset($dbh) && $dbh->inTransaction())
			$dbh->rollBack();

		echo "ERROR: " . $e->getMessage() . "\n";
	}

	progress("");
	progress("Runs processed:             " . $stats["seen"]);
	progress("  master builds:            " . $stats["master"]);
	progress("  PR builds, exact base:    " . $stats["pr_anchored"]);
	progress("  anchored by the clock:    " . $stats["clock"]);
	progress("  old SVN, left alone:      " . $stats["svn"]);
	progress("  master, gitinfo lacks it: " . $stats["master_unknown_to_gitinfo"]);
	progress("  not anchored at all:      " . $stats["unanchored"]);
	progress("");
	progress("Bases resolved (once per distinct commit, then cached):");
	progress("  from the BuildBot log:    " . $stats["base_from_buildbot"]);
	progress("  from GitHub:              " . $stats["base_from_github"]);
	progress("  BuildBot log was pruned:  " . $stats["log_pruned"]);
	progress("  not recoverable at all:   " . $stats["base_unresolved"]);
	progress("");
	progress("Worth a look:");
	progress("  build not in the index:      " . $stats["build_not_found"]);
	progress("  source or comment unusable:  " . $stats["build_unidentified"]);
	progress("  base found but unplaceable:  " . ($stats["base_prefix_unresolved"] + $stats["base_unplaceable"]));
	progress("  commit gone from GitHub:     " . $stats["github_missing"]);
	progress("  revision mismatches:         " . $stats["revision_mismatch"]);

	foreach (array_slice($stats["mismatches"], 0, 20) as $line)
		progress("    " . $line);

	if (count($stats["mismatches"]) > 20)
		progress("    ... and " . (count($stats["mismatches"]) - 20) . " more");

	if ($options["dry-run"])
		progress("\nDry run: nothing was written.");
