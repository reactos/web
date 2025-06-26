<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Class for submitting WineTest results
 * COPYRIGHT:   Copyright 2008-2025 Colin Finck (colin@reactos.org)
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
			$stmt->bindValue(":sourceid", (int)$source_id, PDO::PARAM_INT);
			$stmt->bindParam(":password", $password);
			$stmt->execute();
			if (!$stmt->fetchColumn())
				throw new ErrorMessageException("Invalid Login credentials!");

			// Store the source_id for later.
			$this->_source_id = (int)$source_id;
		}

		public function getTestId($revision, $platform, $comment)
		{
			// Add a new Test ID with the given information.
			$stmt = $this->_dbh->prepare("INSERT INTO winetest_runs (source_id, revision, platform, comment) VALUES (:sourceid, :revision, :platform, :comment)");
			$stmt->bindValue(":sourceid", (int)$this->_source_id, PDO::PARAM_INT);
			$stmt->bindParam(":revision", $revision);
			$stmt->bindParam(":platform", $platform);
			$stmt->bindParam(":comment", $comment);
			$stmt->execute();

			return (int)$this->_dbh->lastInsertId();
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
				return (int)$id;

			// Add this combination to the table and return the ID for it.
			$stmt = $this->_dbh->prepare("INSERT INTO winetest_suites (module, test) VALUES (:module, :test)");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute();

			return (int)$this->_dbh->lastInsertId();
		}

		public function getModuleAndTestForSuiteId($suite_id, &$module, &$test)
		{
			$stmt = $this->_dbh->prepare("SELECT module, test FROM winetest_suites WHERE id = :id");
			$stmt->bindValue(":id", (int)$suite_id, PDO::PARAM_INT);
			$stmt->execute();

			if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$module = $row["module"];
				$test = $row["test"];
				return true;
			}
			else
			{
				return false;
			}
		}

		public function submit($test_id, $suite_id, $log)
		{
			// Make sure that we may add information to the test with this Test ID
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM winetest_runs WHERE id = :testid AND finished = 0 AND source_id = :sourceid");
			$stmt->bindValue(":testid", (int)$test_id, PDO::PARAM_INT);
			$stmt->bindValue(":sourceid", (int)$this->_source_id, PDO::PARAM_INT);
			$stmt->execute();
			if (!$stmt->fetchColumn())
			{
				throw new RuntimeException("Test ID {$test_id} for Source ID {$this->_source_id} could not be found or accessed in the database!");
			}

			// Make sure that this test run does not yet have a result for this test suite
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM winetest_results WHERE test_id = :testid AND suite_id = :suiteid");
			$stmt->bindValue(":testid", (int)$test_id, PDO::PARAM_INT);
			$stmt->bindValue(":suiteid", (int)$suite_id, PDO::PARAM_INT);
			$stmt->execute();

			if ($stmt->fetchColumn() > 0)
			{
				$module = "";
				$test = "";

				if ($this->getModuleAndTestForSuiteId($suite_id, $module, $test))
				{
					throw new RuntimeException("Duplicate result for test suite {$module}:{$test} in this test run!");
				}
				else
				{
					throw new RuntimeException("Duplicate result for this test suite in this test run, and couldn't fetch the test suite!");
				}
			}

			// Get the test name
			$stmt = $this->_dbh->prepare("SELECT test FROM winetest_suites WHERE id = :id");
			$stmt->bindValue(":id", (int)$suite_id, PDO::PARAM_INT);
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
			$stmt->bindValue(":testid", (int)$test_id, PDO::PARAM_INT);
			$stmt->bindValue(":suiteid", (int)$suite_id, PDO::PARAM_INT);
			$stmt->bindParam(":status", $status);
			$stmt->bindValue(":count", (int)$count, PDO::PARAM_INT);
			$stmt->bindValue(":failures", (int)$failures, PDO::PARAM_INT);
			$stmt->bindValue(":skipped", (int)$skipped, PDO::PARAM_INT);
			$stmt->bindValue(":todo", (int)$todo, PDO::PARAM_INT);
			$stmt->bindParam(":time", $time);
			$stmt->execute();

			$stmt = $this->_dbh->prepare("INSERT INTO winetest_logs (id, log) VALUES (:id, COMPRESS(:log))");
			$stmt->bindValue(":id", (int)$this->_dbh->lastInsertId(), PDO::PARAM_INT);
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
			$stmt->bindValue(":sourceid", (int)$this->_source_id, PDO::PARAM_INT);
			$stmt->bindValue(":testid", (int)$test_id, PDO::PARAM_INT);
			$stmt->bindValue(":boot_cycles", (int)$performance["boot_cycles"], PDO::PARAM_INT);
			$stmt->bindValue(":context_switches", (int)$performance["context_switches"], PDO::PARAM_INT);
			$stmt->bindValue(":interrupts", (int)$performance["interrupts"], PDO::PARAM_INT);
			$stmt->bindValue(":reboots", (int)$performance["reboots"], PDO::PARAM_INT);
			$stmt->bindValue(":system_calls", (int)$performance["system_calls"], PDO::PARAM_INT);
			$stmt->bindParam(":time", $performance["time"]);
			$stmt->execute();
			if (!$stmt->rowCount())
				throw new RuntimeException("Did not update anything!");
		}
	}
