<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Self-check that pull request builds stay off master's own history
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	if (PHP_SAPI !== "cli")
		die("This script must be run from the command line.\n");

	// The failure mode this guards against: a pull request that breaks a test draws a
	// spike in the suite history that reads as a master regression and is not one.
	// Switching the PR builds on must add rows without changing which master rows are
	// marked as changed, and a PR build must never be marked as a change itself.
	//
	// Usage: php selftest-pr-history.php [base-url]

	$config_dir = __DIR__ . "/../../www/www.reactos.org_config/";
	require_once($config_dir . "testman-connect.php");

	$base_url = isset($argv[1]) ? rtrim($argv[1], "/") : "http://rosweb.localhost/testman";
	$failures = 0;

	function check($name, $condition, $detail = "")
	{
		global $failures;

		if (!$condition)
			$failures++;

		printf("  %-4s %s%s\n", $condition ? "ok" : "FAIL", $name, $detail === "" ? "" : "  ($detail)");
	}

	function get($url)
	{
		$context = stream_context_create(array("http" => array("timeout" => 60, "ignore_errors" => TRUE)));
		$body = @file_get_contents($url, FALSE, $context);

		if ($body === FALSE)
			throw new RuntimeException("Could not reach $url");

		return $body;
	}

	/**
	 * The body rows of the suite history table, as array(class, revision).
	 */
	function suite_rows($url)
	{
		$html = get($url);
		$rows = array();

		if (preg_match_all('#<tr class="([^"]*)">(.*?)</tr>#s', $html, $matches, PREG_SET_ORDER))
		{
			foreach ($matches as $match)
			{
				if (strpos($match[1], "head") !== FALSE)
					continue;

				// The first link in the row is the run's own commit.
				$revision = preg_match('#compare\.php\?ids=([0-9]+)#', $match[2], $m) ? $m[1] : "?";
				$rows[] = array("class" => $match[1], "run" => $revision);
			}
		}

		return $rows;
	}

	try
	{
		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME . ";charset=utf8mb4", TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Pick a source, platform and suite that has PR runs and a result that moves
		// around within the page that gets rendered. A window in which nothing changed
		// would pass every check below without proving anything, so candidates are tried
		// until one actually produces change marks.
		$candidates = $dbh->query(
			"SELECT r.source_id, r.platform, e.suite_id, COUNT(DISTINCT e.failures) AS variants, " .
			"       SUM(r.pr_number IS NOT NULL) AS pr_runs " .
			"FROM winetest_results e " .
			"JOIN winetest_runs r ON r.id = e.test_id AND r.finished = 1 " .
			"GROUP BY r.source_id, r.platform, e.suite_id " .
			"HAVING variants > 1 AND pr_runs > 0 " .
			"ORDER BY variants DESC, pr_runs DESC LIMIT 25"
		)->fetchAll(PDO::FETCH_ASSOC);

		if (!count($candidates))
			throw new RuntimeException("No suite with both PR runs and varying results - run backfill-run-anchors.php first");

		$pick = NULL;

		foreach ($candidates as $candidate)
		{
			$url = sprintf("%s/suite.php?suite=%d&source=%d&platform=%s",
				$base_url, $candidate["suite_id"], $candidate["source_id"], urlencode($candidate["platform"]));

			$master = suite_rows($url);
			$master_changed = array();

			foreach ($master as $row)
			{
				if (strpos($row["class"], "changed") !== FALSE)
					$master_changed[] = $row["run"];
			}

			if (count($master_changed))
			{
				$pick = $candidate;
				break;
			}
		}

		if ($pick === NULL)
			throw new RuntimeException("None of the candidate suites changes within one page, so this check would prove nothing");

		printf("Suite %d on source %d / %s (%d PR runs, %d master changes)\n",
			$pick["suite_id"], $pick["source_id"], $pick["platform"], $pick["pr_runs"], count($master_changed));

		$both = suite_rows($url . "&pr=1");

		$both_changed = array();
		$pr_rows = 0;
		$pr_marked_changed = 0;

		foreach ($both as $row)
		{
			$is_pr = (strpos($row["class"], "prrun") !== FALSE);
			$is_changed = (strpos($row["class"], "changed") !== FALSE);

			if ($is_pr)
			{
				$pr_rows++;

				if ($is_changed)
					$pr_marked_changed++;
			}
			else if ($is_changed)
			{
				$both_changed[] = $row["run"];
			}
		}

		check("master-only view has rows", count($master) > 0, count($master) . " rows");
		check("master-only view has no PR rows", count(array_filter($master, function($r) { return strpos($r["class"], "prrun") !== FALSE; })) === 0);
		check("PR view adds PR rows", $pr_rows > 0, "$pr_rows PR rows");
		check("a PR build is never marked as a change", $pr_marked_changed === 0, "$pr_marked_changed marked");

		// The point of the whole exercise. Both pages cover the same newest N runs, so
		// they do not end at the same commit; compare only the master runs they share.
		$shared = array_intersect(array_column($master, "run"), array_column($both, "run"));
		$a = array_values(array_intersect($master_changed, $shared));
		$b = array_values(array_intersect($both_changed, $shared));

		check("master's change marks are worth comparing", count($a) > 0, count($a) . " marked");
		check("PR builds do not move master's change marks", $a === $b,
			count($a) . " vs " . count($b) . " over " . count($shared) . " shared runs");

		// A PR run's compare page must pick a master baseline by itself.
		$pr_run = $dbh->query(
			"SELECT id FROM winetest_runs WHERE pr_number IS NOT NULL AND base_order IS NOT NULL " .
			"AND source_id = " . (int)$pick["source_id"] . " ORDER BY id DESC LIMIT 1"
		)->fetchColumn();

		if ($pr_run !== FALSE)
		{
			$html = get($base_url . "/compare.php?ids=" . (int)$pr_run);

			check("a lone PR run gets a baseline column", substr_count($html, "<th>Revision") === 2);
			check("the baseline is announced", strpos($html, "autobaseline") !== FALSE);
			check("the row links to its pull request", strpos($html, "github.com/reactos/reactos/pull/") !== FALSE);

			// The baseline has to be a master run at or below this run's position.
			$baseline = $dbh->query(
				"SELECT m.pr_number IS NULL AND m.base_order <= r.base_order AS ok " .
				"FROM winetest_runs r, winetest_runs m WHERE r.id = " . (int)$pr_run . " AND m.id = (" .
				"  SELECT m2.id FROM winetest_runs r2 JOIN winetest_runs m2 " .
				"    ON m2.source_id = r2.source_id AND m2.platform = r2.platform AND m2.finished = 1 " .
				"    AND m2.pr_number IS NULL AND m2.base_order IS NOT NULL AND m2.base_order <= r2.base_order AND m2.id <> r2.id " .
				"  WHERE r2.id = " . (int)$pr_run . " ORDER BY m2.base_order DESC, m2.id DESC LIMIT 1)"
			)->fetchColumn();

			check("the baseline is master at or below this position", (int)$baseline === 1);
		}
	}
	catch (Exception $e)
	{
		echo "ERROR: " . $e->getMessage() . "\n";
		$failures++;
	}

	echo $failures ? "\n$failures check(s) FAILED.\n" : "\nAll checks passed.\n";
	exit($failures ? 1 : 0);
