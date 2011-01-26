<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Exporting the results as a XML file
  COPYRIGHT:  Copyright 2009-2011 Colin Finck <colin@reactos.org>
*/

	header("Content-Type: text/xml");
	header("Content-Disposition: filename=Results.xml");
	
	echo '<?xml version="1.0" encoding="us-ascii" ?>';
	echo '<!DOCTYPE testinfo SYSTEM "http://' . $_SERVER["SERVER_NAME"] . dirname($_SERVER["SCRIPT_NAME"]) . '/res/testinfo.dtd">';
	echo '<testinfo>';
	
	for($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		// Add an element for each revision
		$stmt = $reader->getTestRunInfoStatement($i);
		
		if(is_string($stmt))
			die($stmt);
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo '<revision id="' . $row["revision"] . '" timestamp="' . $row["timestamp"] . '" source="' . $row["name"] . '" platform="' . $row["platform"] . '">';
		
		// Now get the all test results for this revision
		$stmt = $reader->getSingleResultInfoStatement($i);
		
		if(is_string($stmt))
			die($stmt);
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo '<test ';
			echo 'id="' . $row["id"] . '" ';
			echo 'module="' . $row["module"] . '" ';
			echo 'test="' . $row["test"] . '" ';
			echo 'status="' . $row["status"] . '" ';
			echo 'count="' . $row["count"] . '" ';
			echo 'failures="' . $row["failures"] . '" ';
			echo 'skipped="' . $row["skipped"] . '" />';
		}
		
		echo '</revision>';
	}
	
	echo '</testinfo>';
?>
