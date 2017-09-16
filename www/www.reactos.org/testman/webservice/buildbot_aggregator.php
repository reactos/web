<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Aggregator for the Debug Log of ReactOS BuildBot Buildslaves
 * COPYRIGHT:   Copyright 2009-2017 Colin Finck (colin@reactos.org)
 */

	require_once("config.inc.php");
	require_once(TESTMAN_PATH . "connect.db.php");
	require_once("utils.inc.php");
	require_once("autoload.inc.php");

	$perf = array(
		"boot_cycles" => 0,
		"context_switches" => 0,
		"interrupts" => 0,
		"reboots" => 0,
		"system_calls" => 0,
		"time" => 0
	);

	if(!isset($_GET["sourceid"]) || !isset($_GET["password"]) || !isset($_GET["builder"]) || !is_numeric($_GET["platform"]) || !is_numeric($_GET["build"]) || !isset($_GET["comment"]))
		die("Necessary information not specified!");

	try
	{
		$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_TESTMAN, DB_USER, DB_PASS);
	}
	catch(PDOException $e)
	{
		// Give no exact error message here, so no server internals are exposed
		die("Could not establish the DB connection");
	}

	VerifyLogin($_GET["sourceid"], $_GET["password"]);

	// Make sure nobody runs this script multiple times for the same build
	$stmt = $dbh->prepare("SELECT COUNT(*) FROM winetest_runs WHERE comment = :comment AND source_id = :sourceid");
	$stmt->bindParam(":comment", $_GET["comment"]);
	$stmt->bindParam(":sourceid", $_GET["sourceid"]);
	$stmt->execute() or die("SQL failed #1");

	if($stmt->fetchColumn())
		die("The script has already processed this build before!");

	// Read the Buildslave test log
	$fp = @fopen(BUILDER_URL . rawurlencode($_GET["builder"]) . "/builds/" . $_GET["build"] . "/steps/test/logs/stdio/text", "r");

	if(!$fp)
		die("Could not open the test log!");

	// Get the revision
	do
	{
		$line = fgets($fp);
	}
	while (!preg_match("#.+ ReactOS .+ \(Build [0-9]+-r([0-9]+)\)#", $line, $matches) && !feof($fp));

	$revision = $matches[1];

	if (!$revision)
		die("Got no revision");

	// Create a WineTest object for accessing the database
	$t = new WineTest();

	// Find the first 3rd stage boot
	while (substr($line, 0, 24) != "[SYSREG] Running stage 3" && !feof($fp))
	{
		if (substr($line, 0, 22) == "[SYSREG] Running stage")
			$perf["reboots"]++;

		$line = fgets($fp);
	}

	// Find the boot performance info
	while (substr($line, 0, 10) != "Boot took " && !feof($fp))
	{
		$line = fgets($fp);
	}

	if (!feof($fp))
	{
		// We found the boot info
	   	$cycles = explode(" ", $line, 4);

		if (is_numeric($cycles[2]))
			$perf["boot_cycles"] = $cycles[2];

		// We're in the 3rd stage, increase the reboot count
		$perf["reboots"]++;
	}

	// Find the rest of the boot performance info
	while (substr($line, 0, 12) != "Interrupts: " && !feof($fp))
	{
		$line = fgets($fp);
	}

	if(!feof($fp))
	{
		// We found the rest of the perf info
		$performance = explode(" ", trim($line), 12);

		if (is_numeric($performance[1]))
			$perf["interrupts"] = $performance[1];

		if (is_numeric($performance[4]))
			$perf["system_calls"] = $performance[4];

		if (is_numeric($performance[7]))
			$perf["context_switches"] = $performance[7];
	}

	// Get the log for each test
	$line = "";
	$test_id = 0;

	while(!feof($fp))
	{
		// Find the line with the test information
		while(substr($line, 0, 27) != "Running Wine Test, Module: " && !feof($fp))
		{
			$line = fgets($fp);

			// Check for a reboot
			if (substr($line, 0, 22) == "[SYSREG] Running stage")
				$perf["reboots"]++;
		}

		// We might reach end of file here, we're done in this case
		if(feof($fp))
			break;

		// Parse the test line
		if(!preg_match("#Running Wine Test, Module: (.+), Test: ([\S]+)#", $line, $matches))
			die("Wine Test line is invalid!");

		// Get a Suite ID for this combination
		$suite_id = $t->getSuiteId($matches[1], $matches[2]);

		// If an error occured, $suite_id will contain the error message
		if(!is_numeric($suite_id))
			die($suite_id);

		// Now get the real log
		$log = "";

		for(;;)
		{
			$line = fgets($fp);

			// If this test misses the summary line for some reason, check whether we reached the next test already.
			// If so, already break the loop here, so that this line won't be on the log for this test.
			if(substr($line, 0, 27) == "Running Wine Test, Module: ")
				break;

			$log .= $line;

			// We can easily exceed PHP's memory limit here in case we're reading a bloated log
			// Stop in this case
			if(memory_get_usage() > MAX_MEMORY)
			{
				$log .= "[TESTMAN] Maximum memory for log exceeded, aborting!";
				break;
			}

			// Sysreg might also have noticed a system crash or we even reached the end of the log. Break then.
			if(substr($line, 0, 9) == "[SYSREG] " || feof($fp))
				break;
		}

		// Did we already get a Test ID for this run?
		if(!$test_id)
		{
			$test_id = $t->getTestId($_GET["sourceid"], $revision, "reactos." . $_GET["platform"], $_GET["comment"]);

			// If an error occured, $test_id will contain the error message
			if(!is_numeric($test_id))
				die($test_id);
		}

		// Finally submit the log
		$return = $t->submit($_GET["sourceid"], $test_id, $suite_id, $log);

		// If an error occured, $return will contain the error message
		if($return != "OK")
			die($matches[1] . ":" . $matches[2] . " :: submit($test_id, $suite_id, ...) - $return");
	}

	fclose($fp);

	// The last thing to do is to get the total time the testing took
	$fp = tmpfile();

	if(!$fp)
		die("fatal error: could not create a temp file");

	// Store the log in a temp file because HTTP streams are not seekable
	$ch = curl_init(BUILDER_URL . rawurlencode($_GET["builder"]) . "/builds/" . $_GET["build"] . "/steps/test/logs/stdio");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$result = curl_exec($ch);
	curl_close($ch);

	if (!$result)
		die("could not read the full log");

	// get the last kB of the log
	if (fseek($fp, -1024, SEEK_END) != -1)
	{
		$line = fread($fp, 1024);

		if (preg_match_all("#^elapsedTime=([0-9]+\.[0-9]+)#m", $line, $matches, PREG_PATTERN_ORDER))
			$perf['time'] = array_sum($matches[1]);
	}

	fclose($fp);

	// If we have a Test ID, finish this test run and terminate with the return message from that function
	// Otherwise we couldn't find any test information in this log
	if ($test_id)
		die($t->finish($_GET["sourceid"], $test_id, $perf));
	else
		die("Found no test information in this log!");
