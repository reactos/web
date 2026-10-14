<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     JSON endpoint for browsing test runs by date, source, platform and revision
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("../utils.inc.php");
	require_once(ROOT_PATH . "rosweb/gitinfo.php");

	/**
	 * Reads a GET parameter and checks it against $pattern.
	 *
	 * @return
	 * The trimmed value, or NULL if the parameter was absent or empty.
	 */
	function get_param($name, $pattern)
	{
		if (!array_key_exists($name, $_GET))
			return NULL;

		$value = trim($_GET[$name]);
		if ($value === "")
			return NULL;

		if (!preg_match($pattern, $value))
			throw new InvalidArgumentException("Invalid value for '$name'");

		return $value;
	}

	function get_int_param($name, $min)
	{
		$value = get_param($name, "#^[0-9]+$#");
		if ($value === NULL)
			return NULL;

		if ((int)$value < $min)
			throw new InvalidArgumentException("'$name' must be at least $min");

		return (int)$value;
	}

	/**
	 * Accepts "YYYY-MM-DD" and "YYYY-MM-DD HH:MM[:SS]" (with a space or a "T") and
	 * returns it in the form MySQL compares against a TIMESTAMP column.
	 *
	 * @param bool $exclusive_end
	 * Set for the end of a range. "to=2026-08-15" reads as "up to and including the
	 * 15th", so a value without a time of day then covers the whole day. The comparison
	 * in the query stays exclusive either way.
	 */
	function get_date_param($name, $exclusive_end = FALSE)
	{
		$value = get_param($name, "#^[0-9]{4}-[0-9]{2}-[0-9]{2}([ T][0-9]{2}:[0-9]{2}(:[0-9]{2})?)?$#");
		if ($value === NULL)
			return NULL;

		$date = date_create(str_replace("T", " ", $value));
		if ($date === FALSE)
			throw new InvalidArgumentException("'$name' is not a valid date");

		if ($exclusive_end && strlen($value) == 10)
			$date->modify("+1 day");

		return $date->format("Y-m-d H:i:s");
	}

	/**
	 * Turns a commit hash, or a prefix of one, into its position on master's timeline.
	 *
	 * @return
	 * The ordinal from gitinfo. Throws if the hash is not a master commit, which is the
	 * honest answer for a PR merge commit: it has no position of its own, only a base.
	 * Search for such a run with "rev" instead, or bound the range by the master commits
	 * around it.
	 */
	function get_revision_order_param($name)
	{
		static $gi = NULL;

		$value = get_param($name, "#^[0-9a-fA-F]{4,40}$#");
		if ($value === NULL)
			return NULL;

		if ($gi === NULL)
			$gi = new GitInfo();

		$hash = $gi->getLongHash(strtolower($value));
		if ($hash === FALSE)
			throw new InvalidArgumentException("'$name' is not a known master commit");

		return $gi->getRevisionOrder($hash);
	}

	header("Content-Type: application/json; charset=utf-8");

	try
	{
		// Every filter is optional and independent, so adding one is a block here and
		// nothing else.
		$where = array("r.finished = 1");
		$params = array();

		$from = get_date_param("from");
		if ($from !== NULL)
		{
			$where[] = "r.timestamp >= :from";
			$params[":from"] = $from;
		}

		$to = get_date_param("to", TRUE);
		if ($to !== NULL)
		{
			$where[] = "r.timestamp < :to";
			$params[":to"] = $to;
		}

		// A prefix of the commit hash, matched against what the run built and against what
		// it was built on top of. A master run has the same value in both, so the second
		// half of this only ever adds pull request builds based on the commit - which is
		// the other thing someone typing a hash wants to know about it.
		//
		// Unlike the revision range of ajax-search.php this never consults gitinfo, so it
		// also finds runs whose commit gitinfo never saw.
		$rev = get_param("rev", "#^[0-9a-fA-F]{4,40}$#");
		if ($rev !== NULL)
		{
			$where[] = "(r.revision LIKE :rev OR r.base_revision LIKE :rev)";
			$params[":rev"] = strtolower($rev) . "%";
		}

		// A revision range, as two positions on master's timeline rather than as the list
		// of every hash in between. That list used to be spliced into the query and was
		// capped at 3000 commits; two integers have no cap, and they also catch the PR
		// runs that were built on top of a commit in the range, which a hash list could
		// not do even in principle.
		$rev_from = get_revision_order_param("rev_from");
		$rev_to = get_revision_order_param("rev_to");

		// Endpoints given the wrong way round are a slip, not a request for no results.
		if ($rev_from !== NULL && $rev_to !== NULL && $rev_from > $rev_to)
		{
			$swap = $rev_from;
			$rev_from = $rev_to;
			$rev_to = $swap;
		}

		if ($rev_from !== NULL)
		{
			$where[] = "r.base_order >= :rev_from";
			$params[":rev_from"] = $rev_from;
		}

		if ($rev_to !== NULL)
		{
			$where[] = "r.base_order <= :rev_to";
			$params[":rev_to"] = $rev_to;
		}

		// "master" for master builds only, a number for one pull request, "all" or
		// nothing for everything. The browser asks for "master" by default, because PR
		// runs are noise while bisecting a regression - but it says so in the URL rather
		// than hiding rows behind a default the query string does not mention.
		$pr = get_param("pr", "#^(master|all|[0-9]+)$#");

		if ($pr === "master")
		{
			$where[] = "r.pr_number IS NULL";
		}
		else if ($pr !== NULL && $pr !== "all")
		{
			$where[] = "r.pr_number = :pr";
			$params[":pr"] = (int)$pr;
		}

		// sources.id, not a LIKE on the display name.
		$source = get_int_param("source", 1);
		if ($source !== NULL)
		{
			$where[] = "r.source_id = :source";
			$params[":source"] = $source;
		}

		$platform = get_param("platform", "#^[A-Za-z0-9._-]{1,24}$#");
		if ($platform !== NULL)
		{
			$where[] = "r.platform LIKE :platform";
			$params[":platform"] = $platform . "%";
		}

		$min_failures = get_int_param("min_failures", 0);
		if ($min_failures !== NULL)
		{
			$where[] = "r.failures >= :min_failures";
			$params[":min_failures"] = $min_failures;
		}

		// Keyset paging. "older" continues below the last id of the previous page,
		// "newer" continues above its first id. No offsets, and no COUNT(*): the one
		// extra row fetched below is what tells us whether a further page exists.
		$newer = (get_param("dir", "#^(older|newer)$#") === "newer");
		$cursor = get_int_param("cursor", 1);
		if ($cursor !== NULL)
		{
			$where[] = $newer ? "r.id > :cursor" : "r.id < :cursor";
			$params[":cursor"] = $cursor;
		}

		$limit = get_int_param("limit", 1);
		if ($limit === NULL)
			$limit = API_PAGE_SIZE;

		$limit = min($limit, API_MAX_PAGE_SIZE);

		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// a date filter leaves a filesort inside the ix_runs_ts range, which is
		// cheap for windows up to about a year. If wider windows ever get slow, resolve
		// from/to into an id range first - timestamp is monotonic with id, because both
		// are assigned when the run is inserted - and page on the primary key alone.
		$stmt = $dbh->prepare(
			"SELECT r.id, UNIX_TIMESTAMP(r.timestamp) AS timestamp, r.source_id, src.name AS source, " .
			"r.revision, r.base_revision, r.base_order, r.base_exact, r.ref, r.pr_number, " .
			"r.platform, r.comment, r.count, r.failures " .
			"FROM winetest_runs r " .
			"JOIN sources src ON r.source_id = src.id " .
			"WHERE " . implode(" AND ", $where) . " " .
			"ORDER BY r.id " . ($newer ? "ASC" : "DESC") . " " .
			"LIMIT " . ($limit + 1)
		);
		$stmt->execute($params);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// The extra row is only a probe, it never gets rendered.
		$has_more = (count($rows) > $limit);
		if ($has_more)
			array_pop($rows);

		// Always hand out the page newest first, whichever direction it was read in.
		if ($newer)
			$rows = array_reverse($rows);

		$runs = array();

		foreach ($rows as $row)
		{
			$runs[] = array(
				"id" => (int)$row["id"],
				"timestamp" => (int)$row["timestamp"],
				// Preformatted here so that the client agrees with every page that renders
				// a date server-side, whatever timezone the browser happens to be in.
				"date" => GetDateString($row["timestamp"]),
				"source_id" => (int)$row["source_id"],
				"source" => $row["source"],
				"revision" => $row["revision"],
				"revision_short" => substr($row["revision"], 0, 7),
				// Where the run sits on master, which for a PR build is not where its own
				// commit sits - it has none. base_exact = 0 means the position was
				// guessed from the clock and the client has to say so.
				"base_revision" => $row["base_revision"],
				"base_revision_short" => $row["base_revision"] === NULL ? NULL : substr($row["base_revision"], 0, 7),
				"base_order" => $row["base_order"] === NULL ? NULL : (int)$row["base_order"],
				"base_exact" => (bool)$row["base_exact"],
				"ref" => $row["ref"],
				"pr_number" => $row["pr_number"] === NULL ? NULL : (int)$row["pr_number"],
				"platform" => $row["platform"],
				"platform_name" => GetPlatformString($row["platform"]),
				"comment" => $row["comment"],
				"count" => (int)$row["count"],
				"failures" => (int)$row["failures"],
			);
		}

		echo json_encode(array(
			"runs" => $runs,
			// Whether a further page exists in the direction that was asked for.
			"has_more" => $has_more,
			// Cursors for the two directions: "newer" from first_id, "older" from last_id.
			"first_id" => count($runs) ? $runs[0]["id"] : NULL,
			"last_id" => count($runs) ? $runs[count($runs) - 1]["id"] : NULL,
		));
	}
	catch (InvalidArgumentException $e)
	{
		http_response_code(400);
		echo json_encode(array("error" => $e->getMessage()));
	}
	catch (Exception $e)
	{
		error_log("testman api/runs.php: " . $e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
		http_response_code(500);
		echo json_encode(array("error" => "Internal error"));
	}
