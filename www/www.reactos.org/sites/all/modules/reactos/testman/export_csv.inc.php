<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Exporting the results as a CSV file
  COPYRIGHT:  Copyright 2009 Colin Finck <colin@reactos.org>
*/

	header("Content-Type: text/csv");
	header("Content-Disposition: filename=Results.csv");


	// First row: Revisions
	echo ";;";
	
	for($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$stmt = $reader->getTestRunInfoStatement($i);
		
		if(is_string($stmt))
			die($stmt);
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		// Add a blank cell and four times the revision (so that we can later add the headers)
		echo $row["revision"] . ";" . $row["revision"] . ";" . $row["revision"] . ";" . $row["revision"] . ";;";
	}
	
	echo "\n";

	
	// Second row: Status, Total Tests, Failures, Skipped headers
	echo ";;";
	
	for($i = 0; $i < $reader->getTestIDCount(); $i++)
		echo "Status;Total Tests;Failures;Skipped;;";

	echo "\n";


	// Next rows: Module and Test on the left, results for each column
	// Get the test results for each column
	$result_stmt = array();
	
	for($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$result_stmt[$i] = $reader->getListResultInfoStatement($i);
		
		if(is_string($result_stmt[$i]))
			die($result_stmt[$i]);
	}
	
	$suites_stmt = $reader->getListTestSuiteInfoStatement();

	if(is_string($suites_stmt))
		die($suites_stmt);
	
	while($suites_row = $suites_stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo $suites_row["module"] . ";" . $suites_row["test"] . ";";
		
		for($i = 0; $i < $reader->getTestIDCount(); $i++)
		{
			$row = $result_stmt[$i]->fetch(PDO::FETCH_ASSOC);
			
			echo strtoupper($row["status"]) . ";";
			echo $row["count"] . ";";
			echo $row["failures"] . ";";
			echo $row["skipped"] . ";;";
		}
		
		echo "\n";
	}
?>
