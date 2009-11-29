<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Compare Page
  COPYRIGHT:  Copyright 2008-2009 Colin Finck <colin@reactos.org>
  
  charset=utf-8 without BOM
*/

	require_once("config.inc.php");
	require_once("utils.inc.php");
	require_once("languages.inc.php");
	require_once(SHARED_PATH . "subsys_layout.php");
	
	GetLanguage();
	require_once("lang/$lang.inc.php");
	
	
	function GetDifference(&$current_row, &$prev_row, $subject)
	{
		// Return &nbsp; ("" is not possible because of IE...) if
		//  - we have no previous array to compare with
		//  - we have both arrays, but not the values for both of them
		//  - both values are identical
		if(!$prev_row ||
		   $current_row[$subject] === null ||
		   $prev_row[$subject] === null ||
		   $current_row[$subject] == $prev_row[$subject])
		{
			return "&nbsp;";
		}
		
		$diff = $current_row[$subject] - $prev_row[$subject];
		
		if($diff > 0)
			return "(+$diff)";
		else
			return "($diff)";
	}
	
	function CheckIfChanged(&$changed, &$temp, &$current)
	{
		if($changed)
			return;
		
		if($temp == -1)
			$temp = $current;
		else if($current != $temp)
			$changed = true;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $testman_langres["compare_title"]; ?></title>
	<link rel="stylesheet" type="text/css" href="../shared/css/basic.css" />
	<link rel="stylesheet" type="text/css" href="../shared/css/reactos.css" />
	<link rel="stylesheet" type="text/css" href="css/compare.css" />
	<script type="text/javascript" src="js/shared.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		<?php require_once("js/compare.js.php"); ?>
	//]]>
	</script>
</head>
<body onload="Load()">

<h2><?php echo $testman_langres["compare_title"]; ?></h2>

<?php
	if(!array_key_exists("ids", $_GET))
		die("Necessary information not specified");
	
	$reader = new WineTest_ResultReader();
	$result = $reader->setTestIDList($_GET["ids"]);
	
	// A string return value indicates an error.
	if(is_string($result))
		die($result);
?>

<div>
	<?php
		// Activate the option to only show the changed results between several test runs if more than one Test ID was passed.
		if($reader->getTestIDCount() > 1)
			printf('<input type="checkbox" id="showchanged" onclick="ShowChangedCheckbox_OnClick(this)" /> <label for="showchanged">%s</label><br />', $testman_langres["showchanged"]);
		
		printf('<input type="checkbox" id="showcrashed" onclick="ShowCrashedCheckbox_OnClick(this)" /> <label for="showcrashed">%s</label><br />', $testman_langres["showcrashed"]);

		echo $testman_langres["export_as"];
	?>:
	
	<button onclick="window.open('export.php?f=csv&amp;ids=<?php echo $_GET["ids"]; ?>')">CSV</button>
	<button onclick="window.open('export.php?f=xml&amp;ids=<?php echo $_GET["ids"]; ?>')">XML</button>
</div><br />

<div id="healthindicator_tooltip">
	<div class="intro"><?php echo $testman_langres["healthindicator_intro"]; ?></div>
	
	<div class="box crashedcanceledtests"></div>
	<div class="desc"><?php echo $testman_langres["healthindicator_test_crashedcanceled"]; ?></div>

	<div class="box zero_failedtests"></div>
	<div class="desc"><?php echo $testman_langres["healthindicator_test_succeeded"]; ?></div>
	
	<div class="box real_failedtests"></div>
	<div class="desc"><?php echo $testman_langres["healthindicator_test_failed"]; ?></div>
	
	<div class="outro"><?php echo $testman_langres["healthindicator_outro"]; ?></div>
</div>

<div id="legend">
	<div class="intro"><?php echo $testman_langres["legend"]; ?>:</div>
	
	<div class="box totaltests"></div>
	<div class="desc"><?php echo $testman_langres["totaltests"]; ?></div>
	
	<div class="zero_failedtests" style="border: solid 1px black; border-right: none; margin: 0; width: 8px;"></div>
	<div class="real_failedtests" style="border: solid 1px black; border-left: none; width: 7px;"></div>
	<div class="desc"><?php echo $testman_langres["failedtests"]; ?></div>
	
	<div class="box skippedtests"></div>
	<div class="desc"><?php echo $testman_langres["skippedtests"]; ?></div>
	
	<div class="box diff_legend"></div>
	<div class="desc"><?php echo $testman_langres["difference"]; ?></div>
</div>

<?php
	// Add the table and fill in the table head part
	echo '<table id="comparetable" class="datatable" cellspacing="0" cellpadding="0">';
	echo '<thead><tr class="head">';
	printf('<th class="TestSuite">%s</th>', $testman_langres["testsuite"]);
	
	for($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$stmt = $reader->getTestRunInfoStatement($i);
		
		if(is_string($stmt))
			die($stmt);
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		echo '<th onmousedown="ResultHead_OnMouseDown(this)">';
		printf($testman_langres["resulthead"], $row["revision"], GetDateString($row["timestamp"]), $row["name"], GetPlatformString($row["platform"]));
		echo '</th>';
	}
	
	echo '</tr></thead>';
	echo '<tbody>';
	
	// Get the total numbers
	echo   '<tr class="even">';
	printf('<td id="totals" onmouseover="Cell_OnMouseOver(this)" onmouseout="Cell_OnMouseOut(this)">%s</td>', $testman_langres["totals"]);
	
	$prev_row = null;
	
	for($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$stmt = $reader->getTestRunInfoStatement($i);
		
		if(is_string($stmt))
			die($stmt);
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		echo '<td onmouseover="Cell_OnMouseOver(this)" onmouseout="Cell_OnMouseOut(this)">';
		printf('<div title="%s" class="box totaltests totals">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], $row["count"], GetDifference($row, $prev_row, "count"));
		printf('<div title="%s" class="box %s_failedtests totals">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], ($row["failures"] > 0 ? 'real' : 'zero'), $row["failures"], GetDifference($row, $prev_row, "failures"));
		printf('<div title="%s" class="healthindicator" onmouseover="HealthIndicator_OnMouseOver()" onmouseout="HealthIndicator_OnMouseOut()"><img src="indicator.php?id=%d" /></div>', $testman_langres["healthindicator"], $row["id"]);
		echo '</td>';
		
		$prev_row = $row;
	}
	
	// Add an empty separation row
	echo '</tr>';
	echo '<tr class="separator"></tr>';
	
	// Get the test results for each column
	$result_stmt = array();
	
	for($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$result_stmt[$i] = $reader->getListResultInfoStatement($i);
		
		if(is_string($result_stmt[$i]))
			die($result_stmt[$i]);
	}
	
	$suites_stmt = $reader->getListTestSuiteInfoStatement();
	
	if(is_string($suites_stmt))
		die($suites_stmt);
	
	$oddeven = true;
	$unchanged = array();
	$uncrashed = array();
	
	while($suites_row = $suites_stmt->fetch(PDO::FETCH_ASSOC))
	{
		printf('<tr id="suite_%s" class="%s">', $suites_row["id"], ($oddeven ? "odd" : "even"));
		printf('<td onmouseover="Cell_OnMouseOver(this)" onmouseout="Cell_OnMouseOut(this)">%s:%s</td>', $suites_row["module"], $suites_row["test"]);
		
		$changed = false;
		$crashed = false;
		$prev_row = null;
		$temp_totaltests = -1;
		$temp_failedtests = -1;
		$temp_skippedtests = -1;
		
		for($i = 0; $i < $reader->getTestIDCount(); $i++)
		{
			$row = $result_stmt[$i]->fetch(PDO::FETCH_ASSOC);
			
			echo '<td onmouseover="Cell_OnMouseOver(this)" onmouseout="Cell_OnMouseOut(this)"';
			
			if($row["id"])
				printf(' class="clickable" onclick="Result_OnClick(%d)"', $row["id"]);
			
			echo '>';
			
			// Check whether there are any changes within the test results of several runs
			CheckIfChanged($changed, $temp_totaltests, $row["count"]);
			CheckIfChanged($changed, $temp_failedtests, $row["failures"]);
			CheckIfChanged($changed, $temp_skippedtests, $row["skipped"]);
			$crashed = ($crashed || $row["status"] != "ok");
			
			if($row["id"])
			{
				printf('<div title="%s" class="box totaltests">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], GetTotalTestsString($row), GetDifference($row, $prev_row, "count"));
				printf('<div title="%s" class="box %s_failedtests">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], (($row["failures"] > 0 || $row["status"] != "ok") ? 'real' : 'zero'), $row["failures"], GetDifference($row, $prev_row, "failures"));
				printf('<div title="%s" class="box skippedtests">%d <span class="diff">%s</span></div>', $testman_langres["skippedtests"], $row["skipped"], GetDifference($row, $prev_row, "skipped"));
			}
			else
			{
				// Bloody IE Hack
				echo "&nbsp;";
			}
			
			echo '</td>';
			
			$prev_row = $row;
		}
		
		echo '</tr>';
		
		if(!$changed)
			$unchanged[] = $suites_row["id"];
		
		if(!$crashed)
			$uncrashed[] = $suites_row["id"];
		
		$oddeven = !$oddeven;
	}
	
	echo '</tbody></table>';
	
	// Prepare the array containing all "unchanged" rows
	echo "<script type=\"text/javascript\">\n";
	echo "//<![CDATA[\n";
	echo "var UncrashedRows = Array(";
	echo implode(",", $uncrashed);
	echo ");\n";
	echo "var UnchangedRows = Array(";
	echo implode(",", $unchanged);
	echo ");\n";
	echo "//]]>\n";
	echo "</script>";
?>

</body>
</html>
