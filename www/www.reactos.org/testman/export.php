<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Exporting the results
 * COPYRIGHT:   Copyright 2009-2017 Colin Finck (colin@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("autoload.inc.php");
	require_once("utils.inc.php");
	require_once(ROOT_PATH . "rosweb/exceptions.php");

	try
	{
		// Check the parameters.
		if (!array_key_exists("f", $_GET) || !array_key_exists("ids", $_GET))
			throw new ErrorMessageException("Necessary information not specified");

		$reader = new WineTest_Reader();
		$result = $reader->setTestIDList($_GET["ids"]);

		switch ($_GET["f"])
		{
			case "csv": require_once("export_csv.inc.php"); break;
			case "xml": require_once("export_xml.inc.php"); break;
		}

		die($output);
	}
	catch (ErrorMessageException $e)
	{
		die($e->getMessage());
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}
