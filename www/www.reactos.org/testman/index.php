<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Test results management via web
  COPYRIGHT:  Copyright 2008-2016 Colin Finck <mail@colinfinck.de>
              Aleksey Bragin <aleksey@reactos.org>
*/

	require_once("config.inc.php");
	require_once("connect.db.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	//$rw = new RosWeb($supported_languages);
	$rw = new RosWeb();
	$rev = $rw->getLatestRevision();
	$lang = $rw->getLanguage();

	require_once(ROOT_PATH . "rosweb/lang/$lang.inc.php");
	require_once("lang/$lang.inc.php");

	$sources = "<option></option>";

	try
	{
		$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_TESTMAN, DB_USER, DB_PASS);
	}
	catch(PDOException $e)
	{
		die("Could not establish the DB connection");
	}

	foreach($dbh->query("SELECT name FROM sources") as $src)
	{
		$sources .= '<option value="'.$src['name'].'">'.$src['name'].'</option>';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $testman_langres["index_title"]; ?></title>
	<?php echo $rw->getHead(); ?>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript" src="/rosweb/js/ajax.js"></script>
	<script type="text/javascript" src="js/shared.js"></script>
	<script type="text/javascript">
		<?php require_once("js/index.js.php"); ?>
	</script>
</head>
<body onload="Load()">

<?php echo $rw->getHeader(); ?>

<div class="main" role="main">
	<section class="page-top breadcrumb-wrap">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div id="breadcrumbs">
						<ul class="breadcrumb">
							<li><a href="/">Home</a></li>
							<li><a href="/testman">Testman</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h2><?php echo $testman_langres["index_title"]; ?></h2>
				</div>
			</div>
		</div>
	</section>

	<div class="content">
		<div class="container">
			<p class="lead center"><?php echo $testman_langres["index_intro"]; ?></p>
			<hr>

			<div class="form-horizontal">
				<div class="form-group">
					<label for="search_revision" class="col-sm-2 control-label">Revision</label>

					<div class="col-sm-6">
						<input class="form-control" type="text" id="search_revision" value="" size="24" onkeypress="SearchInputs_OnKeyPress(event)" onkeyup="SearchRevisionInput_OnKeyUp(this)">
						<?php printf($shared_langres["rangeinfo"], $rev, ($rev - 50), $rev); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="search_source" class="col-sm-2 control-label"><?php echo $testman_langres["source"]; ?></label>

					<div class="col-sm-6">
						<div class="comboedit">
							<select class="form-control" onchange="document.getElementById('search_source').value=this.value">
								<?php echo $sources; ?>
							</select>
							<div><input class="form-control" type="text" name="format" id="search_source" value="" onkeypress="SearchInputs_OnKeyPress(event)"></div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="search_platform" class="col-sm-2 control-label"><?php echo $testman_langres["platform"]; ?></label>

					<div class="col-sm-6">
						<select class="form-control" id="search_platform" size="1" onkeypress="SearchInputs_OnKeyPress(event)">
							<option></option>
							<option value="reactos">ReactOS</option>
							<option value="5.0">Windows 2000</option>
							<option value="5.1">Windows XP</option>
							<option value="5.2">Windows XP x64/Server 2003</option>
							<option value="6.0">Windows Vista/Server 2008</option>
							<option value="6.1">Windows 7</option>
						</select><br>
					</div>					
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button class="btn btn-primary" onclick="SearchButton_OnClick()"><i class="icon icon-search"></i> <?php echo $testman_langres["search_button"]; ?></button>
					<i class="icon icon-cog icon-spin" id="ajax_loading_search"></i><br><br>
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
	</div>
</div>

<?php echo $rw->getFooter(); ?>

</body>
</html>
