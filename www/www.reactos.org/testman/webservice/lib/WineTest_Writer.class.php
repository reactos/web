<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Class for submitting WineTest results
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2013 Kamil Hornicek (kamil.hornicek@reactos.org)
 */

	class WineTest_Writer
	{
		// Member Variables
		private $_dbh;
		private $_source_id;

		// Public Functions
		public function __construct($source_id, $password)
		{
			// Connect to the database.
			$this->_dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
			$this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Check the login credentials
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM sources WHERE id = :sourceid AND password = MD5(:password)");
			$stmt->bindParam(":sourceid", $source_id);
			$stmt->bindParam(":password", $password);
			$stmt->execute();
			if (!$stmt->fetchColumn())
				throw new ErrorMessageException("Invalid Login credentials!");

			// Store the source_id for later.
			$this->_source_id = $source_id;
		}

		public function getTestId($revision, $platform, $comment)
		{
			// Add a new Test ID with the given information.
			$stmt = $this->_dbh->prepare("INSERT INTO winetest_runs (source_id, revision, platform, comment) VALUES (:sourceid, :revision, :platform, :comment)");
			$stmt->bindParam(":sourceid", $this->_source_id);
			$stmt->bindParam(":revision", $revision);
			$stmt->bindParam(":platform", $platform);
			$stmt->bindParam(":comment", $comment);
			$stmt->execute();

			return $this->_dbh->lastInsertId();
		}

		public function getSuiteId($module, $test)
		{
			// Determine whether we already have a suite ID for this combination.
			$stmt = $this->_dbh->prepare("SELECT id FROM winetest_suites WHERE module = :module AND test = :test");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute();
			$id = $stmt->fetchColumn();
			if ($id)
				return $id;

			// Add this combination to the table and return the ID for it.
			$stmt = $this->_dbh->prepare("INSERT INTO winetest_suites (module, test) VALUES (:module, :test)");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute();

			return $this->_dbh->lastInsertId();
		}

		public function submit($test_id, $suite_id, $log)
		{
			// Make sure that we may add information to the test with this Test ID
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM winetest_runs WHERE id = :testid AND finished = 0 AND source_id = :sourceid");
			$stmt->bindParam(":testid", $test_id);
			$stmt->bindParam(":sourceid", $this->_source_id);
			$stmt->execute();
			if (!$stmt->fetchColumn())
				throw new RuntimeException("No such test or no permissions!");

			// Make sure that this test run does not yet have a result for this test suite
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM winetest_results WHERE test_id = :testid AND suite_id = :suiteid");
			$stmt->bindParam(":testid", $test_id);
			$stmt->bindParam(":suiteid", $suite_id);
			$stmt->execute();
			if ($stmt->fetchColumn())
				throw new RuntimeException("We already have a result for this test suite in this test run!");

			// Get the test name
			$stmt = $this->_dbh->prepare("SELECT test FROM winetest_suites WHERE id = :id");
			$stmt->bindParam(":id", $suite_id);
			$stmt->execute();
			$test = $stmt->fetchColumn();

			// Get all summary lines belonging to this test in the whole log (a test may have multiple summary lines)
			$result = preg_match_all("#^{$test}: ([0-9]+) tests executed \(([0-9])+ marked as todo, ([0-9]+) failure[s]?\), ([0-9]+) skipped.#m", $log, $matches, PREG_PATTERN_ORDER);
			if ($result === FALSE)
			{
				throw new RuntimeException("preg_match_all failed!");
			}
			else if ($result == 0)
			{
				// We found no summary line, now check whether we find any signs that the test was canceled.
				$lastline = strrchr($log, "[");

				if ($lastline && (strpos($lastline, "[SYSREG]") !== FALSE || strpos($lastline, "[TESTMAN]") !== FALSE))
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
				// Sum up the values of each summary line.
				$status = "ok";
				$count = array_sum($matches[1]);
				$todo = array_sum($matches[2]);
				$failures = array_sum($matches[3]);
				$skipped = array_sum($matches[4]);
			}

			// Get the execution time.
			$result = preg_match_all("#^Test {$test} completed in ([0-9]+\.[0-9]+) seconds.#m", $log, $matches, PREG_PATTERN_ORDER);
			if ($result === FALSE)
			{
				throw new RuntimeException("preg_match_all failed!");
			}
			else if ($result == 0)
			{
				$time = 0;
			}
			else
			{
				$time = array_sum($matches[1]);
			}

			// Add the information into the DB.
			$stmt = $this->_dbh->prepare("INSERT INTO winetest_results (test_id, suite_id, status, count, failures, skipped, todo, time) VALUES (:testid, :suiteid, :status, :count, :failures, :skipped, :todo, :time)");
			$stmt->bindValue(":testid", (int)$test_id);
			$stmt->bindValue(":suiteid", (int)$suite_id);
			$stmt->bindParam(":status", $status);
			$stmt->bindParam(":count", $count);
			$stmt->bindParam(":failures", $failures);
			$stmt->bindParam(":skipped", $skipped);
			$stmt->bindParam(":todo", $todo);
			$stmt->bindParam(":time", $time);
			$stmt->execute();

			$stmt = $this->_dbh->prepare("INSERT INTO winetest_logs (id, log) VALUES (:id, COMPRESS(:log))");
			$stmt->bindValue(":id", (int)$dbh->lastInsertId());
			$stmt->bindParam(":log", $log);
			$stmt->execute();
		}

		public function finish($test_id, $performance)
		{
			// Sum up all results and mark this test as finished, so no more results can be submitted for it
			$stmt = $this->_dbh->prepare(
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
			$stmt->bindParam(":sourceid", $this->_source_id);
			$stmt->bindParam(":testid", $test_id);
			$stmt->bindParam(":boot_cycles", $performance["boot_cycles"]);
			$stmt->bindParam(":context_switches", $performance["context_switches"]);
			$stmt->bindParam(":interrupts", $performance["interrupts"]);
			$stmt->bindParam(":reboots", $performance["reboots"]);
			$stmt->bindParam(":system_calls", $performance["system_calls"]);
			$stmt->bindParam(":time", $performance["time"]);
			$stmt->execute();
			if (!$stmt->rowCount())
				throw new RuntimeException("Did not update anything!");
		}
	}
