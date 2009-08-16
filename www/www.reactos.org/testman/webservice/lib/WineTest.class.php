<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Class for submitting Wine Test results
  COPYRIGHT:  Copyright 2008-2009 Colin Finck <colin@reactos.org>
*/

	class WineTest implements Test
	{
		public function getTestId($revision, $platform, $comment)
		{
			global $dbh;
			global $user_id;
			
			if(!isset($revision) || !isset($platform))
				return "Necessary sub-information not specified!";
			
			// Add a new Test ID with the given information
			$stmt = $dbh->prepare("INSERT INTO " . DB_TESTMAN . ".winetest_runs (user_id, revision, platform, comment) VALUES (:userid, :revision, :platform, :comment)");
			$stmt->bindParam(":userid", $user_id);
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
			$stmt = $dbh->prepare("SELECT id FROM " . DB_TESTMAN . ".winetest_suites WHERE module = :module AND test = :test");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute() or die("GetSuiteID(): SQL failed #1");
			$id = $stmt->fetchColumn();
			
			if($id)
				return $id;
			
			// Add this combination to the table and return the ID for it
			$stmt = $dbh->prepare("INSERT INTO " . DB_TESTMAN . ".winetest_suites (module, test) VALUES (:module, :test)");
			$stmt->bindParam(":module", $module);
			$stmt->bindParam(":test", $test);
			$stmt->execute() or die("GetSuiteID(): SQL failed #2");
			
			return $dbh->lastInsertId();
		}
		
		public function submit($test_id, $suite_id, $log)
		{
			global $dbh;
			global $user_id;
			
			if(!isset($test_id) || !isset($suite_id) || !isset($log))
				return "Necessary sub-information not specified!";
			
			// Make sure we may add information to the test with this Test ID
			$stmt = $dbh->prepare("SELECT COUNT(*) FROM " . DB_TESTMAN . ".winetest_runs WHERE id = :testid AND finished = 0 AND user_id = :userid");
			$stmt->bindParam(":testid", $test_id);
			$stmt->bindParam(":userid", $user_id);
			$stmt->execute() or die("Submit(): SQL failed #1");
			
			if(!$stmt->fetchColumn())
				return "No such test or no permissions!";
			
			// Get the test name
			$stmt = $dbh->prepare("SELECT test FROM " . DB_TESTMAN . ".winetest_suites WHERE id = :id");
			$stmt->bindParam(":id", $suite_id);
			$stmt->execute() or die("Submit(): SQL failed #2");
			$test = $stmt->fetchColumn();
			
			// Get all summary lines belonging to this test in the whole log (a test may have multiple summary lines)
			$result = preg_match_all("#^{$test}: ([0-9]+) tests executed \([0-9]+ marked as todo, ([0-9]+) failure[s]?\), ([0-9]+) skipped.#m", $log, $matches, PREG_PATTERN_ORDER);
			
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
			}
			else
			{
				// Sum up the values of each summary line
				$status = "ok";
				$count = array_sum($matches[1]);
				$failures = array_sum($matches[2]);
				$skipped = array_sum($matches[3]);
			}
			
			// Add the information into the DB
			$stmt = $dbh->prepare("INSERT INTO " . DB_TESTMAN . ".winetest_results (test_id, suite_id, status, count, failures, skipped) VALUES (:testid, :suiteid, :status, :count, :failures, :skipped)");
			$stmt->bindValue(":testid", (int)$test_id);
			$stmt->bindValue(":suiteid", (int)$suite_id);
			$stmt->bindParam(":status", $status);
			$stmt->bindParam(":count", $count);
			$stmt->bindParam(":failures", $failures);
			$stmt->bindParam(":skipped", $skipped);
			$stmt->execute() or die("Submit(): SQL failed #3");
			
			$stmt = $dbh->prepare("INSERT INTO " . DB_TESTMAN . ".winetest_logs (id, log) VALUES (:id, COMPRESS(:log))");
			$stmt->bindValue(":id", (int)$dbh->lastInsertId());
			$stmt->bindParam(":log", $log);
			$stmt->execute() or die("Submit(): SQL failed #4");
			
			return "OK";
		}
		
		public function finish($test_id)
		{
			global $dbh;
			global $user_id;
			
			if(!isset($test_id))
				return "Necessary sub-information not specified!";
			
			// Sum up all results and mark this test as finished, so no more results can be submitted for it
			$stmt = $dbh->prepare(
				"UPDATE " . DB_TESTMAN . ".winetest_runs " .
				"SET " .
					"finished = 1, " .
					"count    = (SELECT SUM(count) FROM  " . DB_TESTMAN . ".winetest_results WHERE test_id = :testid), " .
					"failures = (SELECT SUM(failures) FROM " . DB_TESTMAN . ".winetest_results WHERE test_id = :testid) " .
				"WHERE id = :testid AND user_id = :userid"
			);
			$stmt->bindParam(":userid", $user_id);
			$stmt->bindParam(":testid", $test_id);
			$stmt->execute() or die("Finish(): SQL failed #1");
			
			if(!$stmt->rowCount())
				return "Did not update anything!";
			
			return "OK";
		}
	}
?>
