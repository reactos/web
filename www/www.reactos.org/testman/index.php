<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Test results management via web
  COPYRIGHT:  Copyright 2008-2015 Colin Finck <mail@colinfinck.de>
              Aleksey Bragin <aleksey@reactos.org>
*/

	require_once("config.inc.php");
	require_once("connect.db.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	$rw = new RosWeb($supported_languages);
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
	<link rel="stylesheet" type="text/css" href="/rosweb/css/full.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript">
		document.write('<style type="text/css">');
		document.write('#js_stuff {display: block;}');
		document.write('<\/style>');
	</script>
	<script type="text/javascript" src="/rosweb/js/ajax.js"></script>
	<script type="text/javascript" src="js/shared.js"></script>
	<script type="text/javascript">
		<?php require_once("js/index.js.php"); ?>
	</script>
</head>
<body onload="Load()">

<?php
	echo $rw->getHeader();
	echo $rw->getSidebar();
	echo $rw->getLanguageBox();
?>
</div>

<div id="content" class="column dtcell dtcell-vtop"><div class="section">
	<h1><?php echo $testman_langres["index_title"]; ?></h1>

	<p><?php echo $testman_langres["index_intro"]; ?></p>

	<noscript>
		<b><?php echo $testman_langres["js_disclaimer"]; ?></b>
	</noscript>

	<div id="js_stuff">
		<div class="round_corners">
			<h2 class="pane-title"><?php echo $testman_langres["search_header"]; ?></h2>
			
			<table id="searchform">
				<tr>
					<td><label for="search_revision"><?php echo $testman_langres["revision"]; ?>:</label></td>
					<td>
						<input type="text" id="search_revision" value="" size="24" onkeypress="SearchInputs_OnKeyPress(event)" onkeyup="SearchRevisionInput_OnKeyUp(this)"><br>

						<img src="/rosweb/images/info.gif" alt=""> <?php printf($shared_langres["rangeinfo"], $rev, ($rev - 50), $rev); ?>
					</td>
				</tr>
				<tr>
					<td><label for="search_source"><?php echo $testman_langres["source"]; ?>:</label></td>
					<td>
						<div class="comboedit">
							<select onchange="document.getElementById('search_source').value=this.value">
								<?php echo $sources; ?>
							</select>
							<input type="text" name="format" id="search_source" value="" onkeypress="SearchInputs_OnKeyPress(event)">
						</div>
					</td>
				</tr>
				<tr>
					<td><label for="search_platform"><?php echo $testman_langres["platform"]; ?>:</label></td>
					<td>
						<select id="search_platform" size="1" onkeypress="SearchInputs_OnKeyPress(event)">
							<option></option>
							<option value="reactos">ReactOS</option>
							<option value="5.0">Windows 2000</option>
							<option value="5.1">Windows XP</option>
							<option value="5.2">Windows XP x64/Server 2003</option>
							<option value="6.0">Windows Vista/Server 2008</option>
							<option value="6.1">Windows 7</option>
						</select>
					</td>
				</tr>
			</table><br>
			
			<span class="controlgroup">
				<button onclick="SearchButton_OnClick()"><?php echo $testman_langres["search_button"]; ?></button>
				<img id="ajax_loading_search" src="/rosweb/images/ajax_loading.gif" alt="">
			</span>
			
			<span class="controlgroup">
				<button onclick="CompareFirstTwoButton_OnClick()"><?php echo $testman_langres["comparefirsttwo_button"]; ?></button>
				<button onclick="CompareSelectedButton_OnClick()"><?php echo $testman_langres["compareselected_button"]; ?></button>
				<input type="checkbox" id="opennewwindow" onclick="OpenNewWindowCheckbox_OnClick(this)"> <label for="opennewwindow"><?php echo $testman_langres["opennewwindow_checkbox"]; ?></label>
			</span>
			
			<div id="searchtable">
				<!-- Filled by the JavaScript -->
			</div>
		</div><br>
	
		<iframe id="comparepage_frame" frameborder="0" onload="ResizeIFrame()" scrolling="yes"></iframe>
	</div>
</div></div>

<?php echo $rw->getFooter(); ?>

</body>
</html>
