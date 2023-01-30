<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Class for reading WineTest results
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2013 Kamil Hornicek (kamil.hornicek@reactos.org)
 */

	class WineTest_Reader
	{
		// Member Variables
		private $_dbh;
		private $_suite_id_list;
		private $_test_id_array = array();
		private $_test_id_list = null;

		// Public Functions
		/**
		 * Constructs a WineTest_ResultReader object and establishes the DB connection.
		 */
		public function __construct()
		{
			// Connect to the database.
			$this->_dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
			$this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		/**
		 * Validate and set the passed ID list and do some basic tasks.
		 *
		 * @param string $new_test_id_list
		 * A comma-separated list of Test IDs to compare.
		 *
		 * @return
		 * Boolean true on success, otherwise a string containing an error message.
		 */
		public function setTestIDList($new_test_id_list)
		{
			$new_test_id_array = explode(",", $new_test_id_list);

			// Verify that a suitable value was passed
			if (!$new_test_id_array)
				throw new RuntimeException("new_test_id_list cannot be converted into an array");

			// Verify that the array only contains numeric values and store them as integers to prevent SQL injections
			for ($i = 0; $i < count($new_test_id_array); $i++)
			{
				if(!is_numeric($new_test_id_array[$i]))
					throw new RuntimeException("new_test_id_list is not entirely numeric!");

				$new_test_id_array[$i] = (int)$new_test_id_array[$i];
			}

			// Verify that the user did not select more results than he's allowed to
			if (count($new_test_id_array) > MAX_COMPARE_RESULTS)
				throw new RuntimeException("You may only select up to " . MAX_COMPARE_RESULTS . " results for comparison!");

			// We're safe to use these IDs now.
			$this->_test_id_array = $new_test_id_array;
			$this->_test_id_list = $new_test_id_list;

			// Get all Suite IDs linked to our Test IDs
			$stmt = $this->_dbh->query(
				"SELECT s.id " .
				"FROM winetest_suites s " .
				"JOIN winetest_results e ON e.suite_id = s.id " .
				"WHERE e.test_id IN (" . $this->_test_id_list . ")"
			);
			$suite_id_array = $stmt->fetchAll(PDO::FETCH_COLUMN);
			$this->_suite_id_list = implode(",", $suite_id_array);
		}

		/**
		 * Retrieves the number of Test IDs of the stored $test_id_array.
		 *
		 * @return
		 * An int value containing the number of IDs.
		 */
		public function getTestIDCount()
		{
			return count($this->_test_id_array);
		}

		/**
		 * Retrieves a PDOStatement for getting general information about a Test Run.
		 *
		 * @param int $i
		 * The index of the Test ID to get the information from.
		 *
		 * @return
		 * On success, the method returns a PDOStatement, from which you can fetch the information.
		 * In case of failure, the method returns a string containing an error message.
		 */
		public function getTestRunInfoStatement($i)
		{
			if ($i >= count($this->_test_id_array))
				throw new RuntimeException("Index $i is out of range!");

			return $this->_dbh->query(
				"SELECT UNIX_TIMESTAMP(r.timestamp) timestamp, src.name, r.revision, r.platform, r.count, r.failures, r.id, " .
				" r.boot_cycles, r.context_switches, r.interrupts, r.reboots, r.system_calls, ROUND(r.time/60, 1) as time, ROUND(SUM(wr.time)/60,1) as testing_time, r.comment " .
				"FROM winetest_runs r " .
				"JOIN sources src ON r.source_id = src.id " .
				"JOIN winetest_results wr ON wr.test_id = r.id " .
				"WHERE r.id = " . $this->_test_id_array[$i] . " " .
				"GROUP BY r.id"
			);
		}

		/**
		 * Retrieves a PDOStatement for getting test result information.
		 * Compared to getListResultInfoStatement, this method will only output full rows and the output will also contain information about the test suite.
		 *
		 * @param int $i
		 * The index of the Test ID to get the information from.
		 *
		 * @return
		 * On success, the method returns a PDOStatement, from which you can fetch the information.
		 * In case of failure, the method returns a string containing an error message.
		 */
		public function getSingleResultInfoStatement($i)
		{
			if ($i >= count($this->_test_id_array))
				throw new RuntimeException("Index $i is out of range!");

			return $this->_dbh->query(
				"SELECT e.id, e.status, e.count, e.failures, e.skipped, e.todo, e.time, s.module, s.test " .
				"FROM winetest_results e " .
				"JOIN winetest_suites s ON e.suite_id = s.id " .
				"WHERE e.test_id = " . $this->_test_id_array[$i] . " " .
				"ORDER BY s.module, s.test"
			);
		}

		/**
		 * Retrieves a PDOStatement for getting information about the Test Suites used by at least one result in our ID list.
		 *
		 * @return
		 * On success, the method returns a PDOStatement, from which you can fetch the information.
		 * In case of failure, the method returns a string containing an error message.
		 */
		public function getListTestSuiteInfoStatement()
		{
			if (!$this->_test_id_list)
				throw new RuntimeException("test_id_list was not initialized, call setTestIDList first!");

			// Get all test suites for which we have at least one result in our ID list
			return $this->_dbh->query(
				"SELECT DISTINCT s.id, s.module, s.test " .
				"FROM winetest_suites s " .
				"JOIN winetest_results e ON e.suite_id = s.id " .
				"WHERE test_id IN (" . $this->_test_id_list . ") " .
				"ORDER BY s.module ASC, s.test ASC"
			);
		}

		/**
		 * Retrieves a PDOStatement for getting test result information.
		 * Compared to getSingleResultInfoStatement, this method will output a row for each suite, for which we have at least one result in our ID list.
		 *
		 * @param int $i
		 * The index of the Test ID to get the information from.
		 *
		 * @return
		 * On success, the method returns a PDOStatement, from which you can fetch the information.
		 * In case of failure, the method returns a string containing an error message.
		 */
		public function getListResultInfoStatement($i)
		{
			if (!$this->_suite_id_list)
				throw new RuntimeException("suite_id_list was not initialized, call setTestIDList first!");
			
			if ($i >= count($this->_test_id_array))
				throw new RuntimeException("Index $i is out of range!");
			
			return $this->_dbh->query(
				"SELECT e.id, e.status, e.count, e.failures, e.skipped, e.time, e.todo " .
				"FROM winetest_suites s " .
				"LEFT JOIN winetest_results e ON e.suite_id = s.id AND e.test_id = " . $this->_test_id_array[$i] . " " .
				"WHERE s.id IN (" . $this->_suite_id_list . ")" .
				"ORDER BY s.module, s.test"
			);
		}
	}
