<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Fills a local development database with recent data from the live website
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	if (PHP_SAPI !== "cli")
		die("This script must be run from the command line.\n");

	date_default_timezone_set("UTC");

	define("LIVE_URL", "https://reactos.org/testman");
	define("GITHUB_API", "https://api.github.com/repos/reactos/reactos/commits");
	define("USER_AGENT", "reactos-web-devsetup");

	// Test runs reference commits that are slightly older than the run itself.
	define("COMMIT_MARGIN_DAYS", 2);

	// ajax-search.php never returns more than RESULTS_PER_PAGE (10) entries per page.
	define("SEARCH_PAGE_SIZE", 10);
	define("MAX_SEARCH_PAGES", 500);
	define("MAX_COMMIT_PAGES", 50);

	$config_dir = __DIR__ . "/../../www/www.reactos.org_config/";
	require_once($config_dir . "testman-connect.php");
	require_once($config_dir . "gitinfo-connect.php");


	//// HELPERS ////

	function usage()
	{
		die(
			"Usage: php import-live.php [days] [--no-gitinfo]\n" .
			"\n" .
			"  days           How many days of test results to import (default: 7).\n" .
			"  --no-gitinfo   Skip the gitinfo import. Revision search will not work.\n" .
			"\n" .
			"The gitinfo user needs INSERT privileges, which the production config does not\n" .
			"grant. Override it with the GITINFO_DB_USER / GITINFO_DB_PASS env variables.\n"
		);
	}

	function http_get($url)
	{
		$context = stream_context_create(array(
			"http" => array(
				"method" => "GET",
				"header" => "User-Agent: " . USER_AGENT . "\r\nAccept: application/json\r\n",
				"timeout" => 60,
			)
		));

		$data = @file_get_contents($url, false, $context);
		if ($data === FALSE)
			throw new RuntimeException("Could not fetch $url");

		return $data;
	}

	function connect($host, $name, $user, $pass)
	{
		$dbh = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbh;
	}

	function progress($message)
	{
		echo $message . "\n";
	}


	//// GITINFO ////

	/**
	 * Fetches commits from the GitHub API and refills the "master_revisions" table.
	 *
	 * The table is truncated first: GitInfo derives the commit order from the auto
	 * increment "id", so appending older commits to an existing table would silently
	 * break getRevisionRange() and friends.
	 */
	function import_gitinfo($cutoff)
	{
		$user = getenv("GITINFO_DB_USER") ?: GITINFO_DB_USER;
		$pass = getenv("GITINFO_DB_PASS") ?: GITINFO_DB_PASS;
		$dbh = connect(GITINFO_DB_HOST, GITINFO_DB_NAME, $user, $pass);

		$since = gmdate("Y-m-d\TH:i:s\Z", $cutoff - COMMIT_MARGIN_DAYS * 86400);
		$commits = array();

		for ($page = 1; $page <= MAX_COMMIT_PAGES; $page++)
		{
			$url = GITHUB_API . "?since=" . urlencode($since) . "&per_page=100&page=$page";
			$batch = json_decode(http_get($url), true);

			if (!is_array($batch))
				throw new RuntimeException("Unexpected response from the GitHub API");

			if (!count($batch))
				break;

			$commits = array_merge($commits, $batch);
			progress("  fetched " . count($commits) . " commits");

			if (count($batch) < 100)
				break;
		}

		if (!count($commits))
			throw new RuntimeException("The GitHub API returned no commits since $since");

		// The API returns the newest commit first, but "id" has to ascend chronologically.
		$commits = array_reverse($commits);

		$dbh->exec("TRUNCATE TABLE master_revisions");
		$stmt = $dbh->prepare(
			"INSERT INTO master_revisions (rev_hash, author_name, author_email, commit_timestamp, message) " .
			"VALUES (:rev_hash, :author_name, :author_email, FROM_UNIXTIME(:commit_timestamp), COMPRESS(:message))"
		);

		$dbh->beginTransaction();

		foreach ($commits as $commit)
		{
			$stmt->execute(array(
				":rev_hash" => $commit["sha"],
				":author_name" => (string)$commit["commit"]["author"]["name"],
				":author_email" => (string)$commit["commit"]["author"]["email"],
				":commit_timestamp" => strtotime($commit["commit"]["committer"]["date"]),
				":message" => (string)$commit["commit"]["message"],
			));
		}

		$dbh->commit();
		progress("  imported " . count($commits) . " revisions");
	}


	//// TESTMAN ////

	/**
	 * Collects the IDs of all finished test runs that are newer than $cutoff.
	 *
	 * ajax-search.php has no date filter, so we page through the results (newest first)
	 * until we run past the cutoff. Its dates are formatted in the web server's timezone,
	 * which makes the boundary fuzzy by a couple of hours. That is good enough here.
	 */
	function get_run_ids($cutoff)
	{
		$runs = array();

		for ($page = 1; $page <= MAX_SEARCH_PAGES; $page++)
		{
			$url = LIVE_URL . "/ajax-search.php?desc=1&resultlist=1&limit=" . SEARCH_PAGE_SIZE . "&page=$page";
			$xml = simplexml_load_string(http_get($url), "SimpleXMLElement", LIBXML_NONET);

			if ($xml === FALSE)
				throw new RuntimeException("Could not parse the response of ajax-search.php");

			if (isset($xml->error))
				throw new RuntimeException("ajax-search.php: " . (string)$xml->error);

			if (!count($xml->result))
				break;

			foreach ($xml->result as $result)
			{
				if (strtotime((string)$result->date) < $cutoff)
					return $runs;

				// The comment is the only field we need that export.php does not provide.
				$runs[(int)$result->id] = (string)$result->comment;
			}

			progress("  found " . count($runs) . " runs");
		}

		return $runs;
	}

	function get_source_id($dbh, $name)
	{
		static $cache = array();

		if (isset($cache[$name]))
			return $cache[$name];

		$stmt = $dbh->prepare("SELECT id FROM sources WHERE name = :name");
		$stmt->execute(array(":name" => $name));
		$id = $stmt->fetchColumn();

		if ($id === FALSE)
		{
			// Password is only relevant for submitting results through the webservice.
			$stmt = $dbh->prepare("INSERT INTO sources (name, password) VALUES (:name, MD5('devpassword'))");
			$stmt->execute(array(":name" => $name));
			$id = $dbh->lastInsertId();
		}

		$cache[$name] = (int)$id;
		return (int)$id;
	}

	function get_suite_id($dbh, $module, $test)
	{
		static $cache = array();
		$key = "$module:$test";

		if (isset($cache[$key]))
			return $cache[$key];

		$stmt = $dbh->prepare("SELECT id FROM winetest_suites WHERE module = :module AND test = :test");
		$stmt->execute(array(":module" => $module, ":test" => $test));
		$id = $stmt->fetchColumn();

		if ($id === FALSE)
		{
			$stmt = $dbh->prepare("INSERT INTO winetest_suites (module, test) VALUES (:module, :test)");
			$stmt->execute(array(":module" => $module, ":test" => $test));
			$id = $dbh->lastInsertId();
		}

		$cache[$key] = (int)$id;
		return (int)$id;
	}

	/**
	 * Imports a single test run from export.php, keeping the IDs of the live website so
	 * that local detail.php and export.php URLs match the ones on reactos.org.
	 */
	function import_run($dbh, $id, $comment)
	{
		$url = LIVE_URL . "/export.php?f=xml&ids=" . $id;
		$xml = simplexml_load_string(http_get($url), "SimpleXMLElement", LIBXML_NONET);

		if ($xml === FALSE || !isset($xml->run))
			throw new RuntimeException("Could not parse the response of export.php for run $id");

		$run = $xml->run;
		$source_id = get_source_id($dbh, (string)$run["source"]);

		$stmt = $dbh->prepare(
			"INSERT IGNORE INTO winetest_runs " .
			"(id, timestamp, finished, source_id, revision, platform, comment, boot_cycles, context_switches, interrupts, reboots, system_calls, time) " .
			"VALUES (:id, FROM_UNIXTIME(:timestamp), 1, :source_id, :revision, :platform, :comment, :boot_cycles, :context_switches, :interrupts, :reboots, :system_calls, :time)"
		);
		$stmt->bindValue(":id", (int)$run["id"], PDO::PARAM_INT);
		$stmt->bindValue(":timestamp", (int)$run["timestamp"], PDO::PARAM_INT);
		$stmt->bindValue(":source_id", $source_id, PDO::PARAM_INT);
		$stmt->bindValue(":revision", (string)$run["revision"]);
		$stmt->bindValue(":platform", (string)$run["platform"]);
		$stmt->bindValue(":comment", $comment);
		// boot_cycles regularly exceeds PHP_INT_MAX, so it has to stay a string.
		$stmt->bindValue(":boot_cycles", (string)$run["bootcycles"]);
		$stmt->bindValue(":context_switches", (int)$run["contextswitches"], PDO::PARAM_INT);
		$stmt->bindValue(":interrupts", (int)$run["interrupts"], PDO::PARAM_INT);
		$stmt->bindValue(":reboots", (int)$run["reboots"], PDO::PARAM_INT);
		$stmt->bindValue(":system_calls", (int)$run["systemcalls"], PDO::PARAM_INT);
		// export.php reports the run time in minutes, the column stores seconds.
		$stmt->bindValue(":time", (float)$run["time"] * 60);
		$stmt->execute();

		$stmt = $dbh->prepare(
			"INSERT IGNORE INTO winetest_results (id, test_id, suite_id, status, count, failures, skipped, todo, time) " .
			"VALUES (:id, :test_id, :suite_id, :status, :count, :failures, :skipped, :todo, :time)"
		);

		// detail.php joins winetest_logs, so every result needs a row there. The real logs
		// are not exported by the live website, hence the placeholder.
		$log_stmt = $dbh->prepare("INSERT IGNORE INTO winetest_logs (id, log) VALUES (:id, COMPRESS(:log))");
		$log_text = "This result was imported from " . LIVE_URL . " by import-live.php.\n" .
		            "The live website does not export logs, so this one is not available.\n";

		$dbh->beginTransaction();
		$count = 0;

		foreach ($run->test as $test)
		{
			$stmt->execute(array(
				":id" => (int)$test["id"],
				":test_id" => (int)$run["id"],
				":suite_id" => get_suite_id($dbh, (string)$test["module"], (string)$test["test"]),
				":status" => (string)$test["status"],
				":count" => (int)$test["count"],
				":failures" => (int)$test["failures"],
				":skipped" => (int)$test["skipped"],
				":todo" => (int)$test["todo"],
				":time" => (float)$test["time"],
			));

			$log_stmt->execute(array(":id" => (int)$test["id"], ":log" => $log_text));
			$count++;
		}

		$dbh->commit();

		// Same aggregation that WineTest_Writer::finish() performs.
		$stmt = $dbh->prepare(
			"UPDATE winetest_runs SET " .
			"count = (SELECT SUM(count) FROM winetest_results WHERE test_id = :id), " .
			"failures = (SELECT SUM(failures) FROM winetest_results WHERE test_id = :id) " .
			"WHERE id = :id"
		);
		$stmt->execute(array(":id" => (int)$run["id"]));

		return $count;
	}

	function import_testman($cutoff)
	{
		$dbh = connect(TESTMAN_DB_HOST, TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);

		$runs = get_run_ids($cutoff);
		if (!count($runs))
		{
			progress("  no test runs in that time range");
			return;
		}

		// Import oldest first, so that an interrupted run leaves a contiguous range.
		$runs = array_reverse($runs, true);
		$i = 0;

		foreach ($runs as $id => $comment)
		{
			$i++;
			$count = import_run($dbh, $id, $comment);
			progress("  [$i/" . count($runs) . "] run $id: $count results");
		}
	}


	//// MAIN ////

	$days = 7;
	$gitinfo = TRUE;

	foreach (array_slice($argv, 1) as $arg)
	{
		if ($arg === "--no-gitinfo")
			$gitinfo = FALSE;
		else if (ctype_digit($arg) && (int)$arg > 0)
			$days = (int)$arg;
		else
			usage();
	}

	$cutoff = time() - $days * 86400;

	try
	{
		if ($gitinfo)
		{
			progress("Importing commits of the last $days days...");
			import_gitinfo($cutoff);
		}

		progress("Importing test runs of the last $days days...");
		import_testman($cutoff);

		progress("Done.");
	}
	catch (Exception $e)
	{
		die("ERROR: " . $e->getMessage() . "\n");
	}
