<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Web Service for receiving test results from "rosautotest"
  COPYRIGHT:  Copyright 2008-2011 Colin Finck <colin@reactos.org>
*/

	require_once("config.inc.php");
	require_once(TESTMAN_PATH . "connect.db.php");
	require_once("utils.inc.php");
	
	if(!isset($_POST["sourceid"]) || !isset($_POST["password"]) || !isset($_POST["testtype"]))
		die("Necessary information not specified!");

	try
	{
		$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_TESTMAN, DB_USER, DB_PASS);
	}
	catch(PDOException $e)
	{
		// Give no exact error message here, so no server internals are exposed
		die("Could not establish the DB connection");
	}
	
	VerifyLogin($_POST["sourceid"], $_POST["password"]);
	
	switch($_POST["testtype"])
	{
		case "wine":
			$t = new WineTest();
			break;
		
		default:
			die("Invalid test type!");
	}
	
	// What shall we do?
	switch($_POST["action"])
	{
		case "gettestid":  die($_POST["sourceid"], $t->getTestId($_POST["revision"], $_POST["platform"], $_POST["comment"]));
		case "getsuiteid": die($t->getSuiteId($_POST["module"], $_POST["test"]));
		case "submit":     die($_POST["sourceid"], $t->submit($_POST["testid"], $_POST["suiteid"], $_POST["log"]));
		case "finish":     die($_POST["sourceid"], $t->finish($_POST["testid"]));
		
		default:
			die("Invalid action");
	}
?>
