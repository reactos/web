<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Class for submitting WineTest results
 * COPYRIGHT:   Copyright 2008-2025 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2013 Kamil Hornicek (kamil.hornicek@reactos.org)
 */

	if (!defined('MY_LOGFILE')) {
		define("MY_LOGFILE", "/tmp/WineTest_Writer.log");
	}

	require_once(ROOT_PATH . "rosweb/gitinfo.php");

	class WineTest_Writer
	{
		// What a builder is allowed to report as the ref it checked out. The value is
		// stored verbatim and ends up in a link to GitHub, so it is checked here rather
		// than at one of the two entry points that reach this class.
		const REF_PATTERN = "#^[A-Za-z0-9._/+-]{1,64}$#";
		const HASH_PATTERN = "#^[0-9a-fA-F]{40}$#";

		// Member Variables
		private $_dbh;
		private $_source_id;

		// Public Functions
		public function __construct($source_id, $password)
		{
			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": __construct($source_id, $password)\n", FILE_APPEND);

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

		/**
		 * Works out where this run sits on master's timeline, which is not the same
		 * question as what it built.
		 *
		 * Three cases, tried in order, each a fallback for the one above it:
		 *
		 *  1. The submitter told us. Only the CI job can know this - it has the checkout,
		 *     so the base is a git command away and the ref is what it was told to build.
		 *  2. The built commit is itself on master, so it is its own base. This is what
		 *     keeps every submitter that predates case 1 working unchanged.
		 *  3. Neither. Anchor by the clock and say so, so the run lands roughly in the
		 *     right place instead of nowhere.
		 *
		 * @return
		 * The five anchor columns. All of them stay unset if gitinfo cannot be reached:
		 * an unanchored run is worth far more than a rejected one, and the backfill can
		 * pick it up afterwards.
		 */
		private function _resolveAnchor($revision, $baserevision, $ref)
		{
			$anchor = array("base_revision" => NULL, "base_order" => NULL, "base_exact" => 0, "ref" => $ref, "pr_number" => NULL);

			try
			{
				$gi = new GitInfo();
			}
			catch (Exception $e)
			{
				file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": !!! gitinfo unavailable, leaving run unanchored: " . $e->getMessage() . "\n", FILE_APPEND);
				return $anchor;
			}

			// Old SVN runs carry a revision number rather than a hash. They have no
			// position in master_revisions and never will.
			$on_master = preg_match(self::HASH_PATTERN, $revision) ? $gi->getRevisionOrder(strtolower($revision)) : FALSE;

			if ($ref === NULL && $on_master !== FALSE)
				$ref = "refs/heads/master";

			$anchor["ref"] = $ref;

			if ($ref !== NULL && preg_match("#^refs/pull/([0-9]+)/#", $ref, $matches))
				$anchor["pr_number"] = (int)$matches[1];

			if ($baserevision !== NULL)
			{
				$anchor["base_revision"] = $baserevision;
				$anchor["base_exact"] = 1;

				// A base gitinfo has not ingested yet leaves base_order NULL. The base is
				// still exact; only its position is missing, and a later backfill fills it.
				$order = $gi->getRevisionOrder($baserevision);
				if ($order !== FALSE)
					$anchor["base_order"] = $order;
			}
			else if ($on_master !== FALSE)
			{
				$anchor["base_revision"] = strtolower($revision);
				$anchor["base_order"] = $on_master;
				$anchor["base_exact"] = 1;
			}
			else
			{
				$at = $gi->getRevisionAtTime(time());
				if ($at !== FALSE)
					$anchor["base_order"] = (int)$at["id"];
			}

			return $anchor;
		}

		/**
		 * @param string $baserevision
		 * Optional. The master commit this run was built on top of, as a full hash.
		 *
		 * @param string $ref
		 * Optional. What the builder checked out, e.g. "refs/heads/master" or
		 * "refs/pull/9453/merge". Stored verbatim: /merge and /head are different things.
		 */
		public function getTestId($revision, $platform, $comment, $baserevision = NULL, $ref = NULL)
		{
			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": getTestId($revision, $platform, $comment, $baserevision, $ref)\n", FILE_APPEND);

			if ($baserevision !== NULL)
			{
				if (!preg_match(self::HASH_PATTERN, $baserevision))
					throw new ErrorMessageException("baserevision is not a commit hash!");

				$baserevision = strtolower($baserevision);
			}

			if ($ref !== NULL && !preg_match(self::REF_PATTERN, $ref))
				throw new ErrorMessageException("ref is not a valid Git ref name!");

			$anchor = $this->_resolveAnchor($revision, $baserevision, $ref);

			// Add a new Test ID with the given information.
			$stmt = $this->_dbh->prepare(
				"INSERT INTO winetest_runs (source_id, revision, platform, comment, base_revision, base_order, base_exact, ref, pr_number) " .
				"VALUES (:sourceid, :revision, :platform, :comment, :base_revision, :base_order, :base_exact, :ref, :pr_number)"
			);
			$stmt->bindValue(":sourceid", (int)$this->_source_id, PDO::PARAM_INT);
			$stmt->bindParam(":revision", $revision);
			$stmt->bindParam(":platform", $platform);
			$stmt->bindParam(":comment", $comment);
			$stmt->bindValue(":base_revision", $anchor["base_revision"], PDO::PARAM_STR);
			$stmt->bindValue(":base_order", $anchor["base_order"], $anchor["base_order"] === NULL ? PDO::PARAM_NULL : PDO::PARAM_INT);
			$stmt->bindValue(":base_exact", (int)$anchor["base_exact"], PDO::PARAM_INT);
			$stmt->bindValue(":ref", $anchor["ref"], PDO::PARAM_STR);
			$stmt->bindValue(":pr_number", $anchor["pr_number"], $anchor["pr_number"] === NULL ? PDO::PARAM_NULL : PDO::PARAM_INT);
			$stmt->execute();
			$id = (int)$this->_dbh->lastInsertId();

			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": --> new Test ID $id, ref {$anchor["ref"]}, base_order {$anchor["base_order"]}, exact {$anchor["base_exact"]}\n", FILE_APPEND);
			return $id;
		}

		public function getSuiteId($module, $test)
		{
			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": getSuiteId($module, $test)\n", FILE_APPEND);

			// Determine whether we already have a suite ID for this combination.
			$stmt = $this->_dbh->prepare("SELECT id FROM winetest_suites WHERE module = :module AND test = :test");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute();
			$id = (int)$stmt->fetchColumn();
			if ($id)
			{
				file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": --> existing Suite ID $id\n", FILE_APPEND);
				return $id;
			}

			// Add this combination to the table and return the ID for it.
			$stmt = $this->_dbh->prepare("INSERT INTO winetest_suites (module, test) VALUES (:module, :test)");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute();
			$id = (int)$this->_dbh->lastInsertId();

			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": --> new Suite ID $id\n", FILE_APPEND);
			return $id;
		}

		public function getModuleAndTestForSuiteId($suite_id, &$module, &$test)
		{
			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": getModuleAndTestForSuiteId($suite_id)\n", FILE_APPEND);

			$stmt = $this->_dbh->prepare("SELECT module, test FROM winetest_suites WHERE id = :id");
			$stmt->bindValue(":id", (int)$suite_id, PDO::PARAM_INT);
			$stmt->execute();

			if ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$module = $row["module"];
				$test = $row["test"];

				file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": --> Module and Test: ($module, $test)\n", FILE_APPEND);
				return true;
			}
			else
			{
				file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": --> No Module and Test for Suite ID\n", FILE_APPEND);
				return false;
			}
		}

		public function submit($test_id, $suite_id, $log)
		{
			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": submit($test_id, $suite_id, log...)\n", FILE_APPEND);

			// Make sure that we may add information to the test with this Test ID
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM winetest_runs WHERE id = :testid AND finished = 0 AND source_id = :sourceid");
			$stmt->bindValue(":testid", (int)$test_id, PDO::PARAM_INT);
			$stmt->bindValue(":sourceid", (int)$this->_source_id, PDO::PARAM_INT);
			$stmt->execute();
			if (!$stmt->fetchColumn())
			{
				file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": !!! Test ID {$test_id} for Source ID {$this->_source_id} could not be found or accessed in the database!\n", FILE_APPEND);
				throw new RuntimeException("Test ID {$test_id} for Source ID {$this->_source_id} could not be found or accessed in the database!");
			}

			// Make sure that this test run does not yet have a result for this test suite
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM winetest_results WHERE test_id = :testid AND suite_id = :suiteid");
			$stmt->bindValue(":testid", (int)$test_id, PDO::PARAM_INT);
			$stmt->bindValue(":suiteid", (int)$suite_id, PDO::PARAM_INT);
			$stmt->execute();
			$count = $stmt->fetchColumn();
			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": --> count = $count\n", FILE_APPEND);

			if ($count > 0)
			{
				$module = "";
				$test = "";

				if ($this->getModuleAndTestForSuiteId($suite_id, $module, $test))
				{
					file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": !!! Duplicate result for test suite {$module}:{$test} in this test run!\n", FILE_APPEND);
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
			file_put_contents(MY_LOGFILE, date("Y-m-d H:i:s") . ": finish($test_id, performance...)\n", FILE_APPEND);

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
			$stmt->bindValue(":boot_cycles", $performance["boot_cycles"], PDO::PARAM_STR);
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
