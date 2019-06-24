<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Aggregator for the Debug Log of ReactOS BuildBot Buildslaves
 * COPYRIGHT:   Copyright 2009-2017 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2015 Kamil Hornicek (kamil.hornicek@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("autoload.inc.php");
	require_once(ROOT_PATH . "rosweb/exceptions.php");

	$perf = array(
		"boot_cycles" => 0,
		"context_switches" => 0,
		"interrupts" => 0,
		"reboots" => 0,
		"system_calls" => 0,
		"time" => 0
	);

	try
	{
		// Check the parameters.
		if (!array_key_exists("sourceid", $_GET) || !array_key_exists("password", $_GET) || !array_key_exists("builder", $_GET) || !array_key_exists("platform", $_GET) || !array_key_exists("build", $_GET) || !array_key_exists("comment", $_GET))
			throw new ErrorMessageException("Necessary information not specified!");

		if (!is_numeric($_GET["sourceid"]))
			throw new RuntimeException("Invalid sourceid");

		if (!is_numeric($_GET["platform"]))
			throw new RuntimeException("Invalid platform");

		if (!is_numeric($_GET["build"]))
			throw new RuntimeException("Invalid build");

		$sourceid = (int)$_GET["sourceid"];
		$password = $_GET["password"];
		$builder = $_GET["builder"];
		$platform = (int)$_GET["platform"];
		$build = (int)$_GET["build"];
		$comment = $_GET["comment"];

		$writer = new WineTest_Writer($sourceid, $password);

		// Connect to the database.
		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Make sure nobody runs this script multiple times for the same build.
		$stmt = $dbh->prepare("SELECT COUNT(*) FROM winetest_runs WHERE comment = :comment AND source_id = :sourceid");
		$stmt->bindParam(":comment", $comment);
		$stmt->bindParam(":sourceid", $sourceid);
		$stmt->execute();
		if ($stmt->fetchColumn())
			throw new ErrorMessageException("The script has already processed this build before!");

		// Read the Buildslave test log.
		$fp = @fopen(BUILDER_URL . rawurlencode($builder) . "/builds/$build/steps/test/logs/stdio/text", "r");
		if (!$fp)
			throw new RuntimeException("Could not open the test log!");

		// Get the revision.
		while (!feof($fp))
		{
			$line = fgets($fp);

			if (preg_match("#ReactOS .+ \(Build .+\) \(Commit ([0-9a-f]{40})\)#", $line, $matches))
			{
				$revision = $matches[1];
				break;
			}
		}

		if (feof($fp))
			throw new ErrorMessageException("Found no Git revision in this log!");

		// Find the first 3rd stage boot and count all *re*boots happening in between.
		while (!feof($fp))
		{
			$line = fgets($fp);

			if (preg_match("#^\[SYSREG\] Running stage ([2-3])#", $line, $matches))
			{
				$perf["reboots"]++;
				if ($matches[1] == "3")
					break;
			}
		}

		if (feof($fp))
			throw new ErrorMessageException("Found no stage information in this log!");

		// Find the boot performance info.
		while (!feof($fp))
		{
			$line = fgets($fp);

			if (substr($line, 0, 10) == "Boot took ")
			{
				// We found the boot info
				$cycles = explode(" ", $line, 4);

				if (is_numeric($cycles[2]))
					$perf["boot_cycles"] = $cycles[2];

				break;
			}
		}

		if (feof($fp))
			throw new ErrorMessageException("Found no boot cycle information in this log!");

		// Find the rest of the boot performance info.
		while (!feof($fp))
		{
			$line = fgets($fp);

			if (substr($line, 0, 12) == "Interrupts: ")
			{
				// We found the rest of the perf info.
				$performance = explode(" ", trim($line), 12);

				if (is_numeric($performance[1]))
					$perf["interrupts"] = $performance[1];

				if (is_numeric($performance[4]))
					$perf["system_calls"] = $performance[4];

				if (is_numeric($performance[7]))
					$perf["context_switches"] = $performance[7];

				break;
			}
		}

		if (feof($fp))
			throw new ErrorMessageException("Found no additional boot performance information in this log!");

		// Get the log for each test.
		$line = fgets($fp);
		$test_id = 0;

		while (!feof($fp))
		{
			// Find a test.
			while (!feof($fp))
			{
				if (preg_match("#^\[ROSAUTOTEST\] Running Wine Test, Module: ([\S]+), Test: ([\S]+)#", $line, $matches))
				{
					// Get a Suite ID for this combination.
					$suite_id = $writer->getSuiteId($matches[1], $matches[2]);
					break;
				}

				// Count reboots.
				if (substr($line, 0, 22) == "[SYSREG] Running stage")
					$perf["reboots"]++;

				// In contrast to the other loops, perform fgets at the end here.
				// This reuses the previous line at the beginning of the loop, e.g. when the log-reading loop reached the next test.
				$line = fgets($fp);
			}

			// If we have hit EOF, we have processed the entire log and need to exit the loop.
			if (feof($fp))
				break;

			// Get the log for this test.
			$log = "";
			$completion_line = "[ROSAUTOTEST] Test " . $matches[2] . " completed in ";
			$completion_line_length = strlen($completion_line);

			while (!feof($fp))
			{
				$line = fgets($fp);

				// Check whether we reached the next test already.
				if (substr($line, 0, 27) == "[ROSAUTOTEST] Running Wine Test, Module: ")
					break;

				// Also check whether we reached the end of testing.
				if (substr($line, 0, 36) == "[ROSAUTOTEST] SYSREG_CHECKPOINT:THIRDBOOT_COMPLETE")
					break;

				// All other lines belong to the log of this test.
				$log .= $line;

				// We can easily exceed PHP's memory limit here in case we're reading a bloated log.
				// Stop in this case.
				if (memory_get_usage() > MAX_MEMORY)
				{
					$log .= "[TESTMAN] Maximum memory for log exceeded, aborting!";
					break;
				}

				// Check for the completion line of the test and stop reading the log then.
				if (substr($line, 0, $completion_line_length) == $completion_line)
					break;

				// Sysreg might also have noticed a system crash or we even reached the end of the log. Break then.
				if (substr($line, 0, 9) == "[SYSREG] ")
					break;
			}

			// Did we already get a Test ID for this run?
			if (!$test_id)
				$test_id = $writer->getTestId($revision, "reactos.$platform", $comment);

			// Finally submit the log.
			$writer->submit($test_id, $suite_id, $log);
		}

		fclose($fp);

		// If we didn't get a Test ID, we couldn't find any test information in this log.
		if (!$test_id)
			throw new ErrorMessageException("Found no test information in this log!");

		// The last thing to do is to get the total time the testing took.
		// Unfortunately, this is only written to the HTML log...
		$fp = tmpfile();
		if (!$fp)
			throw new RuntimeException("Could not create a temp file");

		// Store the log in a temp file because HTTP streams are not seekable.
		$ch = curl_init(BUILDER_URL . rawurlencode($builder) . "/builds/$build/steps/test/logs/stdio");
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		if (!$result)
			throw new RuntimeException("Could not read the full log");

		// get the last kB of the log
		if (fseek($fp, -1024, SEEK_END) != -1)
		{
			$line = fread($fp, 1024);

			if (preg_match_all("#^elapsedTime=([0-9]+\.[0-9]+)#m", $line, $matches, PREG_PATTERN_ORDER))
				$perf['time'] = array_sum($matches[1]);
		}

		fclose($fp);

		// Finish this test run.
		$writer->finish($test_id, $perf);
		die("OK");
	}
	catch (ErrorMessageException $e)
	{
		die($e->getMessage());
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}
