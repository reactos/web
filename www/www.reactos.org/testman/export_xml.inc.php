<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Exporting the results as a XML file
 * COPYRIGHT:   Copyright 2009-2017 Colin Finck (colin@reactos.org)
 */

	$output  = '<?xml version="1.0" encoding="us-ascii" ?>';
	$output .= '<!DOCTYPE testinfo SYSTEM "http://' . $_SERVER["SERVER_NAME"] . dirname($_SERVER["SCRIPT_NAME"]) . '/res/testinfo.dtd">';
	$output .= '<testinfo>';

	for ($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		// Add an element for each revision
		$stmt = $reader->getTestRunInfoStatement($i);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$output .= '<run id="' . $row["id"] . '" revision="' . $row["revision"] . '" timestamp="' . $row["timestamp"] . '" source="' . $row["name"] . '" platform="' . $row["platform"] . '" bootcycles="' . $row["boot_cycles"] . '" contextswitches="' . $row["context_switches"] . '" interrupts="' . $row["interrupts"] . '" reboots="' . $row["reboots"] . '" systemcalls="' . $row["system_calls"] . '" time="' . $row["time"] . '" testingtime="' . $row["testing_time"] . '">';
		
		// Now get the all test results for this revision
		$stmt = $reader->getSingleResultInfoStatement($i);		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$output .= '<test ';
			$output .= 'id="' . $row["id"] . '" ';
			$output .= 'module="' . $row["module"] . '" ';
			$output .= 'test="' . $row["test"] . '" ';
			$output .= 'status="' . $row["status"] . '" ';
			$output .= 'count="' . $row["count"] . '" ';
			$output .= 'failures="' . $row["failures"] . '" ';
			$output .= 'skipped="' . $row["skipped"] . '" ';
			$output .= 'todo="' . $row["todo"] . '" ';
			$output .= 'time="' . $row["time"] . '" />';
		}

		$output .= '</run>';
	}

	$output .= '</testinfo>';

	header("Content-Type: text/xml");
	header("Content-Disposition: filename=Results.xml");
