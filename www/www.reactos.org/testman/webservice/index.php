<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Web Service for receiving test results from "rosautotest"
 * COPYRIGHT:   Copyright 2008-2025 Colin Finck (colin@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("autoload.inc.php");
	require_once(ROOT_PATH . "rosweb/exceptions.php");

	try
	{
		// Check the parameters.
		if (!array_key_exists("sourceid", $_POST) || !array_key_exists("password", $_POST) || !array_key_exists("action", $_POST))
			throw new ErrorMessageException("Necessary information not specified");

		$sourceid = $_POST["sourceid"];
		$password = $_POST["password"];
		$action = $_POST["action"];

		$writer = new WineTest_Writer($sourceid, $password);

		// What shall we do?
		switch ($action)
		{
			case "gettestid":
				if (!array_key_exists("revision", $_POST) || !array_key_exists("platform", $_POST) || !array_key_exists("comment", $_POST))
					throw new RuntimeException("gettestid parameters not specified");

				$revision = $_POST["revision"];
				$platform = $_POST["platform"];
				$comment = $_POST["comment"];

				// Optional, and only the CI job can supply them: "ref" is what it checked
				// out, "baserevision" the master commit that ref sits on top of. Without
				// them the writer falls back to resolving the revision against gitinfo,
				// which is what every existing submitter relies on.
				$baserevision = array_key_exists("baserevision", $_POST) && $_POST["baserevision"] !== "" ? $_POST["baserevision"] : NULL;
				$ref = array_key_exists("ref", $_POST) && $_POST["ref"] !== "" ? $_POST["ref"] : NULL;

				die((string)$writer->getTestId($revision, $platform, $comment, $baserevision, $ref));

			case "getsuiteid":
				if (!array_key_exists("module", $_POST) || !array_key_exists("test", $_POST))
					throw new RuntimeException("getsuiteid parameters not specified");

				$module = $_POST["module"];
				$test = $_POST["test"];
				die((string)$writer->getSuiteId($module, $test));

			case "submit":
				if (!array_key_exists("testid", $_POST) || !array_key_exists("suiteid", $_POST) || !array_key_exists("log", $_POST))
					throw new RuntimeException("submit parameters not specified");

				$testid = $_POST["testid"];
				$suiteid = $_POST["suiteid"];
				$log = $_POST["log"];
				$writer->submit($testid, $suiteid, $log);
				die("OK");

			case "finish":
				if (!array_key_exists("testid", $_POST))
					throw new RuntimeException("finish parameters not specified");

				$testid = $_POST["testid"];

				// Performance data is only supported for buildbot_aggregator.php. So feed the finish() method with dummy one.
				$perf = array("boot_cycles" => 0, "context_switches" => 0, "interrupts" => 0, "reboots" => 0, "system_calls" => 0, "time" => 0);
				$writer->finish($testid, $perf);
				die("OK");

			default:
				throw new RuntimeException("Invalid action");
		}
	}
	catch (ErrorMessageException $e)
	{
		die($e->getMessage());
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}
