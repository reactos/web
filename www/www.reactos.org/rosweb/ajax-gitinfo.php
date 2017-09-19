<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     AJAX Interface to access the GitInfo data
 * COPYRIGHT:   Copyright 2017 Colin Finck (colin@reactos.org)
 */

	define("ROOT_PATH", "../");
	require_once("gitinfo.php");

	header("Content-type: text/xml");
	$gi = new GitInfo();

	try
	{
		if (!array_key_exists("f", $_GET) || !array_key_exists("r", $_GET))
			throw new Exception("Necessary information not specified");

		$rev_hash = $gi->getLongHash($_GET["r"]);
		$output_short = (array_key_exists("short", $_GET) && $_GET["short"] == 1);

		switch($_GET["f"])
		{
			case "next":
				$output = $gi->getNextRevision($rev_hash, $output_short);
				die("<gitinfo>$output</gitinfo>");

			case "prev":
				$output = $gi->getPreviousRevision($rev_hash, $output_short);
				die("<gitinfo>$output</gitinfo>");

			case "revinfo":
				$output = $gi->getRevisionInformation($rev_hash);

				echo "<gitinfo>";
				if ($output)
				{
					echo "<author_name>" . $output["author_name"] . "</author_name>";
					echo "<author_email>" . $output["author_email"] . "</author_email>";
					echo "<commit_timestamp>" . $output["commit_timestamp"] . "</commit_timestamp>";
					echo "<message>" . $output["message"] . "</message>";
				}
				die("</gitinfo>");
		}
	}
	catch (Exception $e)
	{
		die("<error><message>" . $e->getMessage() . "</message></error>");
	}
