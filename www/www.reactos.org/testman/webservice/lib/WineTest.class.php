<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Class for submitting Wine Test results
  COPYRIGHT:  Copyright 2008-2011 Colin Finck <colin@reactos.org>
*/

	class WineTest implements Test
	{
		public function getTestId($source_id, $revision, $platform, $comment)
		{
			global $dbh;

			if(!isset($revision) || !isset($platform))
				return "Necessary sub-information not specified!";

			// Add a new Test ID with the given information
			$stmt = $dbh->prepare("INSERT INTO winetest_runs (source_id, revision, platform, comment) VALUES (:sourceid, :revision, :platform, :comment)");
			$stmt->bindParam(":sourceid", $source_id);
			$stmt->bindParam(":revision", $revision);
			$stmt->bindParam(":platform", $platform);
			$stmt->bindParam(":comment", $comment);
			$stmt->execute() or die("GetTestID(): SQL failed #1");

			return $dbh->lastInsertId();
		}

		public function getSuiteId($module, $test)
		{
			global $dbh;

			if(!isset($module) || !isset($test))
				return "Necessary sub-information not specified!";

			// Determine whether we already have a suite ID for this combination
			$stmt = $dbh->prepare("SELECT id FROM winetest_suites WHERE module = :module AND test = :test");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute() or die("GetSuiteID(): SQL failed #1");
			$id = $stmt->fetchColumn();

			if($id)
				return $id;

			// Add this combination to the table and return the ID for it
			$stmt = $dbh->prepare("INSERT INTO winetest_suites (module, test) VALUES (:module, :test)");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute() or die("GetSuiteID(): SQL failed #2");

			return $dbh->lastInsertId();
		}

		public function submit($source_id, $test_id, $suite_id, $log)
		{
			global $dbh;

			if(!isset($test_id) || !isset($suite_id) || !isset($log))
				return "Necessary sub-information not specified!";

			// Make sure that we may add information to the test with this Test ID
			$stmt = $dbh->prepare("SELECT COUNT(*) FROM winetest_runs WHERE id = :testid AND finished = 0 AND source_id = :sourceid");
			$stmt->bindParam(":testid", $test_id);
			$stmt->bindParam(":sourceid", $source_id);
			$stmt->execute() or die("Submit(): SQL failed #1");

			if(!$stmt->fetchColumn())
				return "No such test or no permissions!";

			// Make sure that this test run does not yet have a result for this test suite
			$stmt = $dbh->prepare("SELECT COUNT(*) FROM winetest_results WHERE test_id = :testid AND suite_id = :suiteid");
			$stmt->bindParam(":testid", $test_id);
			$stmt->bindParam(":suiteid", $suite_id);
			$stmt->execute() or die("Submit(): SQL failed #2");

			if($stmt->fetchColumn())
				return "We already have a result for this test suite in this test run!";

			// Get the test name
			$stmt = $dbh->prepare("SELECT test FROM winetest_suites WHERE id = :id");
			$stmt->bindParam(":id", $suite_id);
			$stmt->execute() or die("Submit(): SQL failed #3");
			$test = $stmt->fetchColumn();

			// Get all summary lines belonging to this test in the whole log (a test may have multiple summary lines)
			$result = preg_match_all("#^{$test}: ([0-9]+) tests executed \(([0-9])+ marked as todo, ([0-9]+) failure[s]?\), ([0-9]+) skipped.#m", $log, $matches, PREG_PATTERN_ORDER);

			if($result === FALSE)
			{
				return "preg_match_all failed!";
			}
			else if($result == 0)
			{
				// We found no summary line, now check whether we find any signs that the test was canceled
				$lastline = strrchr($log, "[");

				if($lastline && (strpos($lastline, "[SYSREG]") !== FALSE || strpos($lastline, "[TESTMAN]") !== FALSE))
					$status = "canceled";
				else
					$status = "crash";

				$count = 0;
				$failures = 0;
				$skipped = 0;
				$todo = 0;
			}
			else
			{
				// Sum up the values of each summary line
				$status = "ok";
				$count = array_sum($matches[1]);
				$todo = array_sum($matches[2]);
				$failures = array_sum($matches[3]);
				$skipped = array_sum($matches[4]);
			}

			// Get the execution time
			$result = preg_match_all("#^Test {$test} completed in ([0-9]+\.[0-9]+) seconds.#m", $log, $matches, PREG_PATTERN_ORDER);

			if($result === FALSE)
			{
				return "preg_match_all failed!";
			}
			else if($result == 0)
			{
				$time = 0;
			}
			else
			{
				$time = array_sum($matches[1]);
			}

			// Add the information into the DB
			$stmt = $dbh->prepare("INSERT INTO winetest_results (test_id, suite_id, status, count, failures, skipped, todo, time) VALUES (:testid, :suiteid, :status, :count, :failures, :skipped, :todo, :time)");
			$stmt->bindValue(":testid", (int)$test_id);
			$stmt->bindValue(":suiteid", (int)$suite_id);
			$stmt->bindParam(":status", $status);
			$stmt->bindParam(":count", $count);
			$stmt->bindParam(":failures", $failures);
			$stmt->bindParam(":skipped", $skipped);
			$stmt->bindParam(":todo", $todo);
			$stmt->bindParam(":time", $time);
			$stmt->execute() or die("Submit(): SQL failed #4");

			$stmt = $dbh->prepare("INSERT INTO winetest_logs (id, log) VALUES (:id, COMPRESS(:log))");
			$stmt->bindValue(":id", (int)$dbh->lastInsertId());
			$stmt->bindParam(":log", $log);
			$stmt->execute() or die("Submit(): SQL failed #5");

			return "OK";
		}

		public function finish($source_id, $test_id, $performance)
		{
			global $dbh;

			if(!isset($test_id))
				return "Necessary sub-information not specified!";

			// Sum up all results and mark this test as finished, so no more results can be submitted for it
			$stmt = $dbh->prepare(
				"UPDATE winetest_runs
				 SET
					finished = 1,
					count    = (SELECT SUM(count) FROM  winetest_results WHERE test_id = :testid),
					failures = (SELECT SUM(failures) FROM winetest_results WHERE test_id = :testid),
					boot_cycles = :boot_cycles,
					context_switches = :context_switches,
					interrupts = :interrupts,
					reboots = :reboots,
					system_calls = :system_calls,
					time = :time
				 WHERE id = :testid AND source_id = :sourceid"
			);
			$stmt->bindParam(":sourceid", $source_id);
			$stmt->bindParam(":testid", $test_id);
			$stmt->bindParam(":boot_cycles", $performance["boot_cycles"]);
			$stmt->bindParam(":context_switches", $performance["context_switches"]);
			$stmt->bindParam(":interrupts", $performance["interrupts"]);
			$stmt->bindParam(":reboots", $performance["reboots"]);
			$stmt->bindParam(":system_calls", $performance["system_calls"]);
			$stmt->bindParam(":time", $performance["time"]);
			$stmt->execute() or die("Finish(): SQL failed #1");

			if(!$stmt->rowCount())
				return "Did not update anything!";

			return "OK";
		}
	}
?>
