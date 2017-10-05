<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     AJAX Interface to access the GitInfo data
 * COPYRIGHT:   Copyright 2017 Colin Finck (colin@reactos.org)
 */

	header("Content-type: text/xml");

	define("ROOT_PATH", "../");
	require_once("exceptions.php");
	require_once("gitinfo.php");

	try
	{
		if (!array_key_exists("f", $_GET) || !array_key_exists("r", $_GET))
			throw new ErrorMessageException("Necessary information not specified");

		$gi = new GitInfo();
		$rev_hash = $gi->getLongHash($_GET["r"]);
		$output_short = (array_key_exists("short", $_GET) && $_GET["short"] == 1);

		$output = "<gitinfo>";

		switch($_GET["f"])
		{
			case "next":
				$output .= $gi->getNextRevision($rev_hash, $output_short);
				break;

			case "prev":
				$output .= $gi->getPreviousRevision($rev_hash, $output_short);
				break;

			case "revinfo":
				$row = $gi->getRevisionInformation($rev_hash);
				if ($row)
				{
					$output .= "<author_name>" . $row["author_name"] . "</author_name>";
					$output .= "<author_email>" . $row["author_email"] . "</author_email>";
					$output .= "<commit_timestamp>" . $row["commit_timestamp"] . "</commit_timestamp>";
					$output .= "<message>" . htmlspecialchars($row["message"], ENT_NOQUOTES) . "</message>";
				}
				break;

			default:
				throw new ErrorMessageException("Invalid function");
		}

		$output .= "</gitinfo>";
		die($output);
	}
	catch (ErrorMessageException $e)
	{
		die("<error>" . $e->getMessage() . "</error>");
	}
	catch (Exception $e)
	{
		die("<error>" . $e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage() . "</error>");
	}
