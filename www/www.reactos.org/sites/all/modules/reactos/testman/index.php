<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Test results management via web
  COPYRIGHT:  Copyright 2008-2012 Colin Finck <mail@colinfinck.de>
              Aleksey Bragin <aleksey@reactos.org>
*/
	define("TM_PATH", "./sites/all/modules/reactos/testman/");
	require_once(TM_PATH . "config.inc.php");
	require_once(TM_PATH . "connect.db.php");
	require_once(TM_PATH . "languages.inc.php");

	//GetLanguage();
	global $lang;
	$lang = "en";
	require_once(SHARED_PATH . "lang/$lang.inc.php");
	require_once(TM_PATH . "lang/$lang.inc.php");
	$sources = "<option></option>";

	try
	{
		$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_TESTMAN, DB_USER, DB_PASS);
	}
	catch(PDOException $e)
	{
		die("<error>Could not establish the DB connection</error>");
	}

	foreach($dbh->query("SELECT name FROM sources") as $src)
	{
		$sources .= '<option value="'.$src['name'].'">'.$src['name'].'</option>';
	}


	$rev = reactos_GetLatestRevision();
?>
	<link rel="stylesheet" type="text/css" href="/sites/default/shared/css/reactos.css">
	<link rel="stylesheet" type="text/css" href="/sites/all/modules/reactos/testman/css/index.css">
	<script type="text/javascript">
		document.write('<style type="text/css">');
		document.write('#js_stuff {display: block;}');
		document.write('<\/style>');
	</script>
	<script type="text/javascript" src="/sites/default/shared/js/ajax.js"></script>
	<script type="text/javascript" src="/sites/all/modules/reactos/testman/js/shared.js"></script>
	<script type="text/javascript">
		<?php require_once(TM_PATH . "js/index.js.php"); ?>
		jQuery(document).ready(function () {
			Load();
			jQuery("#javascript_disclaimer").hide();
			//first hide, then fadeIn
			jQuery("#js_stuff").hide();
			jQuery("#js_stuff").fadeIn(500);
		});
	</script>
<h2><?php echo $testman_langres["index_title"]; ?></h2>

<p><?php echo $testman_langres["index_intro"]; ?></p>


<div id="javascript_disclaimer" style="border: 2px solid #FF0000; padding 2px;">
		<b><?php echo $testman_langres["js_disclaimer"]; ?></b>
</div>


<div id="js_stuff" style="display:none">
	<div class="round_corners">
		
			<h1><?php echo $testman_langres["search_header"]; ?></h1>
			
			<table id="searchform">
				<tr>
					<td><label for="search_revision"><?php echo $testman_langres["revision"]; ?>:</label></td>
					<td>
						<input type="text" id="search_revision" value="" size="24" onkeypress="SearchInputs_OnKeyPress(event)" onkeyup="SearchRevisionInput_OnKeyUp(this)" /><br />
						
						<img src="/sites/default/shared/images/info.gif" alt="" /> <?php printf($shared_langres["rangeinfo"], $rev, ($rev - 50), $rev); ?>
					</td>
				</tr>
				<tr>
					<td><label for="search_source"><?php echo $testman_langres["source"]; ?>:</label></td>
					<td>
						<div class="comboedit">
							<select onchange="document.getElementById('search_source').value=this.value">
								<?php echo $sources; ?>
							</select>
							<input type="text" name="format" id="search_source" value="" onkeypress="SearchInputs_OnKeyPress(event)"/>
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
			</table><br />
			
			<span class="controlgroup">
				<button onclick="SearchButton_OnClick()"><?php echo $testman_langres["search_button"]; ?></button>
				<img id="ajax_loading_search" src="/sites/default/shared/images/ajax_loading.gif" alt="" />
			</span>
			
			<span class="controlgroup">
				<button onclick="CompareFirstTwoButton_OnClick()"><?php echo $testman_langres["comparefirsttwo_button"]; ?></button>
				<button onclick="CompareSelectedButton_OnClick()"><?php echo $testman_langres["compareselected_button"]; ?></button>
				<input type="checkbox" id="opennewwindow" onclick="OpenNewWindowCheckbox_OnClick(this)" /> <label for="opennewwindow"><?php echo $testman_langres["opennewwindow_checkbox"]; ?></label>
			</span>
			
			<div id="searchtable">
				<!-- Filled by the JavaScript -->
			</div>
	</div><br />
	
	<iframe id="comparepage_frame" frameborder="0" onload="ResizeIFrame()" scrolling="yes"></iframe>
</div>
