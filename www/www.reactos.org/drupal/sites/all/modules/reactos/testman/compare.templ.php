<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $testman_langres["compare_title"]; ?></title>
	<link rel="stylesheet" type="text/css" href="/sites/default/shared/css/basic.css" />
	<link rel="stylesheet" type="text/css" href="/sites/default/shared/css/reactos.css" />
	<link rel="stylesheet" type="text/css" href="css/compare.css" />
	<script type="text/javascript" src="js/shared.js"></script>
	<script type="text/javascript" src="js/compare.js"></script>
</head>
<body onload="Load()">

<h2><?php echo $testman_langres["compare_title"]; ?></h2>

<div>
	<?php echo $testman_controls ?>	
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

<table id="comparetable" class="datatable" cellspacing="0" cellpadding="0"><thead><tr class="head"><th class="TestSuite"><?php echo $testman_langres["testsuite"];?></th><?php echo $table_summary; ?></tr></thead><tbody><tr class="even"><td id="totals"><?php echo $testman_langres["totals"]; ?></td><?php echo $table_totals; ?></tr><?php echo $table_performance; ?><tr class="even"><td id="summary"><?php echo $testman_langres["summary"]; ?></td><?php echo  $table_separator; ?></tr><tr class="odd"><td><?php echo $testman_langres["count"]; ?></td><?php echo  $summary_count; ?></tr><tr class="even"><td><?php echo $testman_langres["failures"]; ?></td><?php echo  $summary_failures ?></tr><tr class="separator"><td colspan="3"></td></tr><?php echo $table_results; ?></tbody></table>

<script type="text/javascript">
//<![CDATA[
var FilterableRows = Array(<?php echo $testman_filterable; ?>);
//]]>
</script>
</body>
</html>
