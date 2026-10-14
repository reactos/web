<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Self-check for the run anchoring done by WineTest_Writer::getTestId()
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	if (PHP_SAPI !== "cli")
		die("This script must be run from the command line.\n");

	// Submits a handful of runs through the real web service and checks the anchor
	// columns they end up with. Every run it creates is deleted again at the end.
	//
	// Usage: php selftest-anchors.php [base-url] [sourceid] [password]

	$config_dir = __DIR__ . "/../../www/www.reactos.org_config/";
	require_once($config_dir . "testman-connect.php");
	require_once($config_dir . "gitinfo-connect.php");

	$base_url = isset($argv[1]) ? rtrim($argv[1], "/") : "http://rosweb.localhost/testman";
	$sourceid = isset($argv[2]) ? (int)$argv[2] : 1;
	$password = isset($argv[3]) ? $argv[3] : "devpassword";

	$failures = 0;
	$created = array();

	function connect($host, $name, $user, $pass)
	{
		$dbh = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbh;
	}

	function post($url, $fields)
	{
		$context = stream_context_create(array(
			"http" => array(
				"method" => "POST",
				"header" => "Content-Type: application/x-www-form-urlencoded\r\n",
				"content" => http_build_query($fields),
				"timeout" => 30,
				// The web service reports failures in the body with a 200, so a non-200
				// would be a server error we still want to see.
				"ignore_errors" => TRUE,
			)
		));

		$body = @file_get_contents($url, FALSE, $context);
		if ($body === FALSE)
			throw new RuntimeException("Could not reach $url");

		return trim($body);
	}

	function gettestid($fields)
	{
		global $base_url, $sourceid, $password, $created;

		$response = post($base_url . "/webservice/index.php", array_merge(array(
			"sourceid" => $sourceid,
			"password" => $password,
			"action" => "gettestid",
			"platform" => "reactos.0",
			"comment" => "selftest-anchors",
		), $fields));

		if (ctype_digit($response))
			$created[] = (int)$response;

		return $response;
	}

	function check($name, $expected, $actual)
	{
		global $failures;

		// The columns come back from PDO as strings; compare loosely but keep NULL apart
		// from 0, which is the whole point of base_exact.
		$ok = ($expected === NULL) ? ($actual === NULL) : ($actual !== NULL && (string)$expected === (string)$actual);

		if (!$ok)
		{
			$failures++;
			printf("  FAIL %-28s expected %-12s got %s\n", $name, var_export($expected, TRUE), var_export($actual, TRUE));
		}
		else
		{
			printf("  ok   %-28s %s\n", $name, var_export($actual, TRUE));
		}
	}

	try
	{
		$dbh = connect(TESTMAN_DB_HOST, TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$gitinfo = connect(GITINFO_DB_HOST, GITINFO_DB_NAME, GITINFO_DB_USER, GITINFO_DB_PASS);

		// A commit gitinfo knows, and the one it considers newest right now.
		$master = $gitinfo->query("SELECT id, rev_hash FROM master_revisions ORDER BY id DESC LIMIT 1 OFFSET 3")->fetch(PDO::FETCH_ASSOC);
		$newest = $gitinfo->query("SELECT id FROM master_revisions WHERE commit_timestamp <= NOW() ORDER BY id DESC LIMIT 1")->fetchColumn();

		if (!$master)
			throw new RuntimeException("gitinfo is empty - run devsetup/import-live.php first");

		$row_stmt = $dbh->prepare("SELECT revision, base_revision, base_order, base_exact, ref, pr_number FROM winetest_runs WHERE id = :id");

		$fetch = function($id) use ($row_stmt)
		{
			$row_stmt->execute(array(":id" => $id));
			return $row_stmt->fetch(PDO::FETCH_ASSOC);
		};

		// A hash that is deliberately not on master, standing in for a PR merge commit.
		$pr_hash = str_repeat("ab12cd34", 5);

		echo "Case 2: a master commit is its own base\n";
		$row = $fetch(gettestid(array("revision" => $master["rev_hash"])));
		check("base_revision", $master["rev_hash"], $row["base_revision"]);
		check("base_order", $master["id"], $row["base_order"]);
		check("base_exact", 1, $row["base_exact"]);
		check("ref", "refs/heads/master", $row["ref"]);
		check("pr_number", NULL, $row["pr_number"]);

		echo "Case 1: the submitter supplies ref and base\n";
		$row = $fetch(gettestid(array("revision" => $pr_hash, "ref" => "refs/pull/9453/merge", "baserevision" => $master["rev_hash"])));
		check("revision", $pr_hash, $row["revision"]);
		check("base_revision", $master["rev_hash"], $row["base_revision"]);
		check("base_order", $master["id"], $row["base_order"]);
		check("base_exact", 1, $row["base_exact"]);
		check("ref", "refs/pull/9453/merge", $row["ref"]);
		check("pr_number", 9453, $row["pr_number"]);

		echo "Case 1: /head is kept apart from /merge\n";
		$row = $fetch(gettestid(array("revision" => $pr_hash, "ref" => "refs/pull/9453/head", "baserevision" => $master["rev_hash"])));
		check("ref", "refs/pull/9453/head", $row["ref"]);
		check("pr_number", 9453, $row["pr_number"]);

		echo "Case 3: unknown commit, nothing supplied, anchored by the clock\n";
		$row = $fetch(gettestid(array("revision" => $pr_hash)));
		check("base_revision", NULL, $row["base_revision"]);
		check("base_order", $newest, $row["base_order"]);
		check("base_exact", 0, $row["base_exact"]);
		check("ref", NULL, $row["ref"]);

		echo "Case 3: a ref without a base still yields the PR number\n";
		$row = $fetch(gettestid(array("revision" => $pr_hash, "ref" => "refs/pull/9454/merge")));
		check("base_revision", NULL, $row["base_revision"]);
		check("base_exact", 0, $row["base_exact"]);
		check("pr_number", 9454, $row["pr_number"]);

		echo "An old SVN revision number is not mistaken for a hash prefix\n";
		$svn_clash = $gitinfo->query("SELECT SUBSTRING(rev_hash, 1, 5) FROM master_revisions WHERE rev_hash REGEXP '^[0-9]{5}' LIMIT 1")->fetchColumn();
		$row = $fetch(gettestid(array("revision" => $svn_clash !== FALSE ? $svn_clash : "12345")));
		check("base_revision", NULL, $row["base_revision"]);
		check("base_exact", 0, $row["base_exact"]);
		check("ref", NULL, $row["ref"]);

		echo "Malformed input is rejected\n";
		check("bad ref", "ref is not a valid Git ref name!", gettestid(array("revision" => $pr_hash, "ref" => "refs/pull/1/merge oops")));
		check("bad baserevision", "baserevision is not a commit hash!", gettestid(array("revision" => $pr_hash, "baserevision" => "nothex")));
	}
	catch (Exception $e)
	{
		echo "ERROR: " . $e->getMessage() . "\n";
		$failures++;
	}

	if (count($created))
	{
		$in = implode(",", array_map("intval", $created));
		$dbh->exec("DELETE FROM winetest_runs WHERE id IN ($in)");
		echo "\nCleaned up " . count($created) . " test runs.\n";
	}

	echo $failures ? "\n$failures check(s) FAILED.\n" : "\nAll checks passed.\n";
	exit($failures ? 1 : 0);
