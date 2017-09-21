<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Exporting the results as a CSV file
 * COPYRIGHT:   Copyright 2009-2017 Colin Finck (colin@reactos.org)
 */

	// First row: Revisions
	$output = ";;";

	for ($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$stmt = $reader->getTestRunInfoStatement($i);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// Add a blank cell and four times the revision (so that we can later add the headers)
		$output .= $row["revision"] . ";" . $row["revision"] . ";" . $row["revision"] . ";" . $row["revision"] . ";;";
	}

	$output .= "\n";

	// Second row: Status, Total Tests, Failures, Skipped headers
	$output .= ";;";
	
	for ($i = 0; $i < $reader->getTestIDCount(); $i++)
		$output .= "Status;Total Tests;Failures;Skipped;;";

	$output .= "\n";


	// Next rows: Module and Test on the left, results for each column
	// Get the test results for each column
	$result_stmt = array();
	for ($i = 0; $i < $reader->getTestIDCount(); $i++)
		$result_stmt[$i] = $reader->getListResultInfoStatement($i);

	$suites_stmt = $reader->getListTestSuiteInfoStatement();

	while ($suites_row = $suites_stmt->fetch(PDO::FETCH_ASSOC))
	{
		$output .= $suites_row["module"] . ";" . $suites_row["test"] . ";";

		for ($i = 0; $i < $reader->getTestIDCount(); $i++)
		{
			$row = $result_stmt[$i]->fetch(PDO::FETCH_ASSOC);

			$output .= strtoupper($row["status"]) . ";";
			$output .= $row["count"] . ";";
			$output .= $row["failures"] . ";";
			$output .= $row["skipped"] . ";;";
		}

		$output .= "\n";
	}

	header("Content-Type: text/csv");
	header("Content-Disposition: filename=Results.csv");
