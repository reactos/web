<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     AJAX Backend for the Search feature
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 */

	header("Content-type: text/xml");

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("utils.inc.php");
	require_once(ROOT_PATH . "rosweb/exceptions.php");
	require_once(ROOT_PATH . "rosweb/gitinfo.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	$rw = new RosWeb();
	$lang = $rw->getLanguage();
	require_once(ROOT_PATH . "rosweb/lang/$lang.inc.php");

	try
	{
		// Check the common parameter for all queries.
		if (!array_key_exists("page", $_GET))
			throw new ErrorMessageException("Necessary information not specified");

		$page = (int)$_GET["page"];
		$gi = new GitInfo();

		// Connect to the database.
		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Check all other parameters and prepare the WHERE clause.
		$query = "FROM winetest_runs r JOIN sources src ON r.source_id = src.id WHERE r.finished = 1";

		if (array_key_exists("startrev", $_GET) && array_key_exists("endrev", $_GET))
		{
			$startrev = $_GET["startrev"];
			$endrev = $_GET["endrev"];

			if (preg_match($SVN_PATTERN, $startrev) && preg_match($SVN_PATTERN, $endrev))
			{
				// The user wants to find old SVN test results.
				$range = range((int)$startrev, (int)$endrev);
			}
			else
			{
				// The user wants to find GIT test results.

				// Get the long hashes for searching.
				$start_hash = $gi->getLongHash($startrev);
				$end_hash = $gi->getLongHash($endrev);
				if (!$start_hash || !$end_hash)
					throw new RuntimeException($shared_langres["invalidinput"]);

				// Get all revisions between $start_hash and $end_hash.
				$range = $gi->getRevisionRange($start_hash, $end_hash);
			}

			if (count($range) > REV_RANGE_LIMIT)
				throw new RuntimeException(sprintf($shared_langres["rangelimitexceeded"], REV_RANGE_LIMIT));

			$query .= " AND r.revision IN ('" . implode("','", $range) . "')";
		}

		if (array_key_exists("source", $_GET) && $_GET["source"])
		{
			$query .= " AND src.name LIKE " . $dbh->quote("%" . $_GET["source"] . "%");
		}

		if (array_key_exists("platform", $_GET) && $_GET["platform"])
		{
			$query .= " AND r.platform LIKE " . $dbh->quote($_GET["platform"] . "%");
		}

		if (array_key_exists("limit", $_GET))
		{
			$limit = (int)$_GET["limit"];
			if ($limit < 1)
				throw new RuntimeException("limit is out of range");

			$limit_count = min(RESULTS_PER_PAGE, $limit);
		}
		else
		{
			$limit_count = RESULTS_PER_PAGE;
		}

		$output = "<results>";

		// Determine how many results we would get in total with this query.
		$stmt = $dbh->query("SELECT COUNT(*) $query");
		$limit_offset = ($page - 1) * RESULTS_PER_PAGE;
		$result_count = max(0, (int)$stmt->fetchColumn() - $limit_offset);

		if (isset($limit) && $result_count > $limit)
		{
			// Don't count higher than the manually supplied limit.
			$result_count = $limit;
		}

		if ($result_count)
		{
			$query .= " ORDER BY r.id " . (array_key_exists("desc", $_GET) ? "DESC" : "ASC");

			if (array_key_exists("resultlist", $_GET))
			{
				$stmt = $dbh->query(
					"SELECT r.id, UNIX_TIMESTAMP(r.timestamp) AS timestamp, src.name, r.revision, r.platform, r.comment, r.count, r.failures $query " .
					"LIMIT $limit_offset, $limit_count"
				);

				while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== FALSE)
				{
					$output .= "<result>";
					$output .= "<id>" . $row["id"] . "</id>";
					$output .= "<date>" . GetDateString($row["timestamp"]) . "</date>";
					$output .= "<source>" . htmlspecialchars($row["name"]) . "</source>";
					$output .= "<revision>" . $gi->getShortHash($row["revision"]) . "</revision>";
					$output .= "<platform>" . GetPlatformString($row["platform"]) . "</platform>";
					$output .= "<comment>" . htmlspecialchars($row["comment"]) . "</comment>";
					$output .= "<count>" . $row["count"] . "</count>";
					$output .= "<failures>" . $row["failures"] . "</failures>";
					$output .= "</result>";

					if (!isset($first_revision))
						$first_revision = $row["revision"];

					$last_revision = $row["revision"];
				}
			}
			else
			{
				// Get the first and last revision belonging to this call
				$stmt = $dbh->query("SELECT r.revision $query LIMIT $limit_offset, 1");
				$first_revision = $gi->getShortHash($stmt->fetchColumn());

				$stmt = $dbh->query("SELECT r.revision $query LIMIT " . ($limit_offset + $limit_count - 1) . ", 1");
				$last_revision = $gi->getShortHash($stmt->fetchColumn());
			}

			$output .= "<firstrev>$first_revision</firstrev>";
			$output .= "<lastrev>$last_revision</lastrev>";
		}

		$output .= "<resultcount>$result_count</resultcount>";
		$output .= "</results>";
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
