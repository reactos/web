<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $testman_langres["compare_title"]; ?></title>
	<?php $rw->printHead(); ?>
	<link rel="stylesheet" type="text/css" href="css/compare.css">
	<script type="text/javascript">
		var FilterableRows = Array(<?php echo $testman_filterable; ?>);
	</script>
	<script type="text/javascript" src="js/compare.js"></script>
</head>
<body onload="Load()">

<h2><?php echo $testman_langres["compare_title"]; ?></h2>

<div>
	<?php echo $testman_controls ?>
	<button class="btn btn-default" onclick="window.open('export.php?f=csv&amp;ids=<?php echo $_GET["ids"]; ?>')">CSV</button>
	<button class="btn btn-default" onclick="window.open('export.php?f=xml&amp;ids=<?php echo $_GET["ids"]; ?>')">XML</button>
</div><br>

<div id="healthindicator_tooltip">
	<div class="intro"><?php echo $testman_langres["healthindicator_intro"]; ?></div>

	<div class="testmanbox crashedcanceledtests"></div>
	<div class="desc"><?php echo $testman_langres["healthindicator_test_crashedcanceled"]; ?></div>

	<div class="testmanbox zero_failedtests"></div>
	<div class="desc"><?php echo $testman_langres["healthindicator_test_succeeded"]; ?></div>

	<div class="testmanbox real_failedtests"></div>
	<div class="desc"><?php echo $testman_langres["healthindicator_test_failed"]; ?></div>

	<div class="outro"><?php echo $testman_langres["healthindicator_outro"]; ?></div>
</div>

<div id="legend">
	<div class="intro"><?php echo $testman_langres["legend"]; ?></div>

	<div class="testmanbox totaltests"></div>
	<div class="desc"><?php echo $testman_langres["totaltests"]; ?></div>

	<div class="testmanbox zero_failedtests" style="border-right: none; margin: 0; width: 10px;"></div>
	<div class="testmanbox real_failedtests" style="border-left: none; width: 9px;"></div>
	<div class="desc"><?php echo $testman_langres["failedtests"]; ?></div>

	<div class="testmanbox skippedtests"></div>
	<div class="desc"><?php echo $testman_langres["skippedtests"]; ?></div>

	<div class="testmanbox diff_legend"></div>
	<div class="desc"><?php echo $testman_langres["difference"]; ?></div>
</div>

<table id="comparetable" class="table table-bordered table-striped table-hover">
	<thead>
		<tr class="head">
			<th class="TestSuite"><?php echo $testman_langres["testsuite"];?></th>
			<?php echo $table_summary; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td id="totals"><?php echo $testman_langres["totals"]; ?></td>
			<?php echo $table_totals; ?>
		</tr>
		<?php echo $table_performance; ?>
		<tr>
			<td id="summary"><?php echo $testman_langres["summary"]; ?></td>
			<?php echo $table_separator; ?>
		</tr>
		<tr>
			<td><?php echo $testman_langres["count"]; ?></td>
			<?php echo $summary_count; ?>
		</tr>
		<tr>
			<td><?php echo $testman_langres["failures"]; ?></td>
			<?php echo $summary_failures ?>
		</tr>
		<tr class="separator">
			<td colspan="3"></td>
		</tr>
		<?php echo $table_results; ?>
	</tbody>
</table>

<?php $rw->printCookieBanner(); ?>

</body>
</html>
