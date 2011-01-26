<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    AJAX backend for the Search feature
  COPYRIGHT:  Copyright 2008-2011 Colin Finck <colin@reactos.org>
*/

	header("Content-type: text/xml");
	
	require_once("config.inc.php");
	require_once("connect.db.php");
	require_once("utils.inc.php");
	
	if(!isset($_GET["source"]))
		die("<error>Necessary information not specified!</error>");
	
	try
	{
		$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_TESTMAN, DB_USER, DB_PASS);
	}
	catch(PDOException $e)
	{
		// Give no exact error message here, so no server internals are exposed
		die("<error>Could not establish the DB connection</error>");
	}

	// Prepare the WHERE clause
	$where = "";
	
	if($_GET["startrev"] || $_GET["startid"] || $_GET["source"] || $_GET["platform"])
	{
		$where = "WHERE r.finished = 1 ";
		
		if($_GET["startrev"])
			$where .= "AND r.revision >= " . (int)$_GET["startrev"] . " AND r.revision <= " . (int)$_GET["endrev"] . " ";
		
		if($_GET["startid"])
			$where .= "AND r.id >= " . (int)$_GET["startid"] . " ";
		
		if($_GET["source"])
			$where .= "AND src.name LIKE " . $dbh->quote($_GET["source"] . "%") . " ";
		
		if($_GET["platform"])
			$where .= "AND r.platform LIKE " . $dbh->quote($_GET["platform"] . "%") . " ";
	}
	
	// Prepare some clauses
	$tables = "FROM winetest_runs r JOIN sources src ON r.source_id = src.id ";
	
	if($_GET["desc"])
		$order = "ORDER BY revision DESC, r.id DESC ";
	else
		$order = "ORDER BY revision ASC, r.id ASC ";
	
	echo "<results>";
	
	// First determine how many results we would get in total with this query
	$stmt = $dbh->query("SELECT COUNT(*) " . $tables . $where) or die("<error>Query failed #1</error>");
	
	$result_count = $stmt->fetchColumn();
	
	if($_GET["limit"] && $result_count > $_GET["limit"])
	{
		$result_count = (int)$_GET["limit"];
		echo "<moreresults>0</moreresults>";
	}	
	else if($result_count > RESULTS_PER_PAGE)
	{
		// The number of results exceeds the number of results per page.
		// Therefore we will only output all results up to the maximum number of results per page with this call.
		$result_count = RESULTS_PER_PAGE;
		echo "<moreresults>1</moreresults>";
	}
	else
	{
		echo "<moreresults>0</moreresults>";
	}
	
	printf("<resultcount>%d</resultcount>", $result_count);
	
	$first_id = 0;
	$first_revision = 0;
	$last_revision = 0;
	$next_id = 0;
	
	if($result_count)
	{
		if($_GET["resultlist"])
		{
			$stmt = $dbh->query(
				"SELECT r.id, UNIX_TIMESTAMP(r.timestamp) timestamp, src.name, r.revision, r.platform, r.comment, r.count, r.failures " .
				$tables .	$where . $order .
				"LIMIT " . $result_count
			) or die("<error>Query failed #2</error>");
			
			$first = true;
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($first)
				{
					$first_id = $row["id"];
					$first_revision = $row["revision"];
					$first = false;
				}
				
				echo "<result>";
				printf("<id>%d</id>", $row["id"]);
				printf("<date>%s</date>", GetDateString($row["timestamp"]));
				printf("<source>%s</source>", htmlspecialchars($row["name"]));
				printf("<revision>%d</revision>", $row["revision"]);
				printf("<platform>%s</platform>", GetPlatformString($row["platform"]));
				printf("<comment>%s</comment>", htmlspecialchars($row["comment"]));
				printf("<count>%d</count>", $row["count"]);
				printf("<failures>%d</failures>", $row["failures"]);
				echo "</result>";
				
				$last_revision = $row["revision"];
			}
		}
		else
		{
			// Get the first and last revision belonging to this call
			$stmt = $dbh->query("SELECT r.id, r.revision " . $tables . $where .	$order . "LIMIT 1") or die("<error>Query failed #3</error>");
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$first_id = $row["id"];
			$first_revision = $row["revision"];
			
			$stmt = $dbh->query("SELECT r.revision " . $tables . $where . $order . "LIMIT " . ($result_count - 1) . ", 1") or die("<error>Query failed #4</error>");
			$last_revision = $stmt->fetchColumn();
		}
		
		// Get the next ID (= the first ID after our limit)
		$stmt = $dbh->query("SELECT r.id " . $tables . $where .	$order . "LIMIT " . $result_count . ", 1") or die("<error>Query failed #5</error>");
		$next_id = $stmt->fetchColumn();
	}
	
	printf("<firstid>%d</firstid>", $first_id);
	printf("<firstrev>%d</firstrev>", $first_revision);
	printf("<lastrev>%d</lastrev>", $last_revision);
	printf("<nextid>%d</nextid>", $next_id);
	
	echo "</results>";
?>
