<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Result Details Page
  COPYRIGHT:  Copyright 2008-2009 Colin Finck <colin@reactos.org>
  
  charset=utf-8 without BOM
*/
	
	require_once("config.inc.php");
	require_once("connect.db.php");
	require_once("utils.inc.php");
	require_once("languages.inc.php");
	require_once(SHARED_PATH . "subsys_layout.php");
	
	GetLanguage();
	require_once("lang/$lang.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $testman_langres["detail_title"]; ?></title>
	<link rel="stylesheet" type="text/css" href="../shared/css/basic.css" />
	<link rel="stylesheet" type="text/css" href="../shared/css/reactos.css" />
	<link rel="stylesheet" type="text/css" href="css/detail.css" />
	<script type="text/javascript" src="js/detail.js"></script>
</head>
<body>

<h2><?php echo $testman_langres["detail_title"]; ?></h2>

<?php
	if(!array_key_exists("id", $_GET))
		die("Necessary information not specified");
	
	// Establish a DB connection
	try
	{
		$dbh = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
	}
	catch(PDOException $e)
	{
		// Give no exact error message here, so no server internals are exposed
		die("Could not establish the DB connection");
	}
	
	// Get information about this result
	$stmt = $dbh->prepare(
		"SELECT UNCOMPRESS(l.log) log, e.status, e.count, e.failures, e.skipped, s.module, s.test, UNIX_TIMESTAMP(r.timestamp) timestamp, r.revision, r.platform, a.name, r.comment " .
		"FROM " . DB_TESTMAN . ".winetest_results e " .
		"JOIN " . DB_TESTMAN . ".winetest_logs l ON e.id = l.id " .
		"JOIN " . DB_TESTMAN . ".winetest_suites s ON e.suite_id = s.id " .
		"JOIN " . DB_TESTMAN . ".winetest_runs r ON e.test_id = r.id " .
		"JOIN " . DB_ROSCMS . ".roscms_accounts a ON r.user_id = a.id " .
		"WHERE e.id = :id"
	);
	$stmt->bindParam(":id", $_GET["id"]);
	$stmt->execute() or die("Query failed #1");
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<table class="datatable" cellspacing="0" cellpadding="0">
	<tr class="head">
		<th colspan="2"><?php echo $testman_langres["thisresult"]; ?></th>
	</tr>
	
	<tr class="even" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["testsuite"]; ?>:</td>
		<td><?php echo $row["module"]; ?>:<?php echo $row["test"]; ?></td>
	</tr>
	<tr class="odd" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["totaltests"]; ?>:</td>
		<td><?php echo GetTotalTestsString($row); ?></td>
	</tr>
	<tr class="even" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["failedtests"]; ?>:</td>
		<td><?php echo $row["failures"]; ?></td>
	</tr>
	<tr class="odd" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["skippedtests"]; ?>:</td>
		<td><?php echo $row["skipped"]; ?></td>
	</tr>
	<tr class="even" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["log"]; ?>:</td>
		<td><pre><?php
			$patterns[0] = "#^([a-z]*:?\()([a-zA-Z0-9\/]+.[a-z]+):([0-9]+)(\))#m";
			$patterns[1] = "#^([a-zA-Z0-9]+.[a-z]+):([0-9]+)(: )#m";

			$replacements[0] = '$1<a href="' . VIEWVC_TRUNK . '/reactos/$2?revision=' . $row["revision"] . '&amp;view=markup#l_$3">$2:$3</a>$4';
			$replacements[1] = '<a href="' . VIEWVC_TRUNK . '/rostests/winetests/' . $row["module"] . '/$1?revision=' . $row["revision"] . '&amp;view=markup#l_$2">$1:$2</a>$3';
			
			echo preg_replace($patterns, $replacements, htmlspecialchars($row["log"]));
		?></pre></td>
	</tr>
</table><br />

<table class="datatable" cellspacing="0" cellpadding="0">
	<tr class="head">
		<th colspan="2"><?php echo $testman_langres["associatedtest"]; ?></th>
	</tr>
	
	<tr class="even" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["revision"]; ?>:</td>
		<td><?php echo $row["revision"]; ?></td>
	</tr>
	<tr class="odd" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["date"]; ?>:</td>
		<td><?php echo GetDateString($row["timestamp"]); ?></td>
	</tr>
	<tr class="even" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["user"]; ?>:</td>
		<td><?php echo $row["name"]; ?></td>
	</tr>
	<tr class="odd" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["platform"]; ?>:</td>
		<td><?php echo GetPlatformString($row["platform"]); ?></td>
	</tr>
	<tr class="even" onmouseover="Row_OnMouseOver(this)" onmouseout="Row_OnMouseOut(this)">
		<td class="info"><?php echo $testman_langres["comment"]; ?>:</td>
		<td><?php echo $row["comment"]; ?></td>
	</tr>
</table>

</body>
</html>
