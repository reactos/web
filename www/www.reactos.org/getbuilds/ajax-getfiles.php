<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Easily download prebuilt ReactOS Revisions
 * COPYRIGHT:   Copyright 2007-2017 Colin Finck (colin@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "rosweb/gitinfo.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	$gi = new GitInfo();
	$rw = new RosWeb();
	$lang = $rw->getLanguage();

	require_once("lang/$lang.inc.php");

	header("Content-type: text/xml");

	try
	{
		// Check the parameters.
		if (!array_key_exists("startrev", $_GET) || !array_key_exists("endrev", $_GET) || !array_key_exists("prefixes", $_GET) || !array_key_exists("suffixes", $_GET))
			throw new Exception("Necessary information not specified");

		$startrev = $_GET["startrev"];
		$endrev = $_GET["endrev"];

		if (is_numeric($startrev) && is_numeric($endrev))
		{
			// The user wants to find old SVN builds.
			// Translate the prefixes and suffixes to their SVN counterparts.
			$prefixes = preg_split("#,#", $_GET["prefixes"], NULL, PREG_SPLIT_NO_EMPTY);
			$translated_prefixes = array();
			foreach ($prefixes as $p)
			{
				$translation = $SVN_PREFIX_TRANSLATIONS[$p];
				if ($translation)
					$translated_prefixes[] = $translation;
			}

			$suffixes = preg_split("#,#", $_GET["suffixes"], NULL, PREG_SPLIT_NO_EMPTY);
			$translated_suffixes = array();
			foreach ($suffixes as $s)
			{
				$translation = $SVN_SUFFIX_TRANSLATIONS[$s];
				if ($translation)
					$translated_suffixes[] = $translation;
			}

			$_GET["prefixes"] = implode(",", $translated_prefixes);
			$_GET["suffixes"] = implode(",", $translated_suffixes);
		}
		else if (!is_numeric($startrev) && !is_numeric($endrev))
		{
			// The user wants to find GIT builds.

			// Get the long hashes for searching.
			$start_hash = $gi->getLongHash($_GET["startrev"]);
			$end_hash = $gi->getLongHash($_GET["endrev"]);
			if (!$start_hash || !$end_hash)
				throw new Exception($getbuilds_langres["invalidinput"]);

			// Get all revisions between $start_hash and $end_hash.
			$range = $gi->getRevisionRange($start_hash, $end_hash);
			if (count($range) > $REV_RANGE_LIMIT)
				throw new Exception(sprintf($getbuilds_langres["rangelimitexceeded"], $REV_RANGE_LIMIT));

			// Shorten the hashes again to save space.
			$short_range = array();
			foreach ($range as $r)
				$short_range[] = $gi->getShortHash($r);

			// Pass a list of revisions instead of a start and an end to the provider, because it has no access to GitInfo!
			$_GET["range"] = implode(",", $short_range);
			unset($_GET["startrev"]);
			unset($_GET["endrev"]);
		}
		else
		{
			throw new Exception($getbuilds_langres["invalidinput"]);
		}

		// The query string may get very long, so we have to do a POST request.
		$opts = array(
			"http" => array(
				"header" => "Content-type: application/x-www-form-urlencoded\r\n",
				"method" => "POST",
				"content" => http_build_query($_GET)
			)
		);
		$context = stream_context_create($opts);
		die(file_get_contents($AJAX_GETFILES_PROVIDER_URL, false, $context));
	}
	catch (Exception $e)
	{
		die("<error><message>" . $e->getMessage() . "</message></error>");
	}
