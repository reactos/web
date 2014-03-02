<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Exporting the results as a XML file
  COPYRIGHT:  Copyright 2009 Colin Finck <colin@reactos.org>
*/

	require_once("autoload.inc.php");
	require_once("utils.inc.php");
	
	if(!array_key_exists("f", $_GET) || !array_key_exists("ids", $_GET))
		die("Necessary information not specified");
	
	$reader = new WineTest_ResultReader();
	$result = $reader->setTestIDList($_GET["ids"]);
	
	// A string return value indicates an error.
	if(is_string($result))
		die($result);

	switch($_GET["f"])
	{
		case "csv": require_once("export_csv.inc.php"); break;
		case "xml": require_once("export_xml.inc.php"); break;
	}
?>
