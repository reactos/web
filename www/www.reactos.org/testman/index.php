<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Front Page for managing ReactOS Regression Test results over the web
 * COPYRIGHT:   Copyright 2008-2020 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2013 Aleksey Bragin (aleksey@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/gitinfo.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	//$rw = new RosWeb($supported_languages);
	$rw = new RosWeb();
	$lang = $rw->getLanguage();
	require_once(ROOT_PATH . "rosweb/lang/$lang.inc.php");
	require_once("lang/$lang.inc.php");

	try
	{
		$gi = new GitInfo();
		$revisions = $gi->getLatestRevisions(2);
		$rev = $gi->getShortHash($revisions[0]);
		$rev_before = $gi->getShortHash($revisions[1]);

		// Connect to the database.
		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $testman_langres["index_title"]; ?></title>
	<?php $rw->printHead(); ?>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript">
		var DEFAULT_SEARCH_LIMIT = <?php echo DEFAULT_SEARCH_LIMIT; ?>;
		var DEFAULT_SEARCH_SOURCE = '<?php echo DEFAULT_SEARCH_SOURCE; ?>';
		var MAX_COMPARE_RESULTS = <?php echo MAX_COMPARE_RESULTS; ?>;
		var RESULTS_PER_PAGE = <?php echo RESULTS_PER_PAGE; ?>;
	</script>
	<script type="text/javascript" src="/rosweb/lang/<?php echo $lang; ?>.js"></script>
	<script type="text/javascript" src="/rosweb/js/ajax.js"></script>
	<script type="text/javascript" src="lang/<?php echo $lang; ?>.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
</head>
<body onload="Load()">

<?php $rw->printHeader(); ?>

<div class="row" id="heading-breadcrumbs">
	<div class="col-md-offset-1 col-md-10">
		<div class="breadcrumbs">
			<a href="/">home</a> / <a href="/testman">testman</a>
		</div>
		<h1><?php echo $testman_langres["index_title"]; ?></h1>
	</div>
</div>

<section id="content" class="row">
	<div class="col-md-10 col-md-offset-1">
		<p class="lead center"><?php echo $testman_langres["index_intro"]; ?></p>
		<hr>

		<div class="form-horizontal">
			<div class="form-group">
				<label for="search_revision" class="col-sm-2 control-label"><?php echo $shared_langres["revision"]; ?></label>

				<div class="col-sm-7">
					<input class="form-control" type="text" id="search_revision" value="" size="50">
					<?php printf($shared_langres["rangeinfo"], $rev, $rev_before, $rev); ?>
				</div>
			</div>

			<div class="form-group">
				<label for="search_source" class="col-sm-2 control-label"><?php echo $testman_langres["source"]; ?></label>

				<div class="col-sm-7">
					<div class="comboedit">
						<select class="form-control" onchange="document.getElementById('search_source').value=this.value">
							<option></option>
							<?php
								$stmt = $dbh->query("SELECT name FROM sources");
								while (($source = $stmt->fetchColumn()) !== FALSE)
									printf('<option value="%s">%s</option>', $source, $source);
							?>
						</select>
						<div><input class="form-control" type="text" name="format" id="search_source" value=""></div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="search_platform" class="col-sm-2 control-label"><?php echo $testman_langres["platform"]; ?></label>

				<div class="col-sm-7">
					<select class="form-control" id="search_platform" size="1">
						<option></option>
						<option value="reactos">ReactOS</option>
						<option value="5.2">Windows Server 2003</option>
					</select><br>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-md-offset-1">
				<button class="btn btn-primary" onclick="SearchButton_OnClick()"><i class="fa fa-search"></i> <?php echo $shared_langres["search_button"]; ?></button>
				<i class="fa fa-cog fa-spin" id="ajax_loading_search"></i><br><br>
			</div>

			<div class="col-md-6">
				<button class="btn btn-default" onclick="CompareFirstTwoButton_OnClick()"><?php echo $testman_langres["comparefirsttwo_button"]; ?></button>
				<button class="btn btn-default" onclick="CompareSelectedButton_OnClick()"><?php echo $testman_langres["compareselected_button"]; ?></button>
			</div>

			<div class="col-md-2 checkbox">
				<label><input type="checkbox" id="opennewwindow" onclick="OpenNewWindowCheckbox_OnClick(this)"> <?php echo $testman_langres["opennewwindow_checkbox"]; ?></label>
			</div>
		</div>

		<div id="searchtable">
			<!-- Filled by the JavaScript -->
		</div>

		<iframe id="comparepage_frame" frameborder="0" onload="ResizeIFrame()" scrolling="yes"></iframe>
	</div>
</section>

<?php
	$rw->printFooter();
	$rw->printCookieBanner();
?>

</body>
</html>
