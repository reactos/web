<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Main Page
  COPYRIGHT:  Copyright 2008-2011 Colin Finck <colin@reactos.org>
  
  charset=utf-8 without BOM
*/
	
	require_once("config.inc.php");
	require_once("connect.db.php");
	require_once("utils.inc.php");
	require_once("languages.inc.php");
	require_once(SHARED_PATH . "subsys_layout.php");
	require_once(SHARED_PATH . "svn.php");
	
	GetLanguage();
	require_once(SHARED_PATH . "lang/$lang.inc.php");
	require_once("lang/$lang.inc.php");
	
	$rev = GetLatestRevision();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $testman_langres["index_title"]; ?></title>
	<link rel="stylesheet" type="text/css" href="../shared/css/menu.css" />
	<link rel="stylesheet" type="text/css" href="../shared/css/reactos.css" />
	<link rel="stylesheet" type="text/css" href="css/index.css" />
	<script type="text/javascript">
	//<![CDATA[
		document.write('<style type="text/css">');
		document.write('#js_stuff {display: block;}');
		document.write('<\/style>');
	//]]>
	</script>
	<script type="text/javascript" src="../shared/js/ajax.js"></script>
	<script type="text/javascript" src="js/shared.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		<?php require_once("js/index.js.php"); ?>
	//]]>
	</script>
</head>
<body onload="Load()">

<?php
	BasicLayout($lang);
	LanguageBox($lang);
?>
</td>
<td id="content">

<h1><?php echo $testman_langres["index_header"]; ?></h1>
<h2><?php echo $testman_langres["index_title"]; ?></h2>

<p><?php echo $testman_langres["index_intro"]; ?></p>

<noscript>
	<div class="bubble_bg">
		<div class="rounded_ll">
		<div class="rounded_lr">
		<div class="rounded_ul">
		<div class="rounded_ur">
		
		<div class="bubble">
			<b><?php echo $testman_langres["js_disclaimer"]; ?></b>
		</div>
		
		</div>
		</div>
		</div>
		</div>
	</div>
</noscript>

<div id="js_stuff">
	<div class="bubble_bg">
		<div class="rounded_ll">
		<div class="rounded_lr">
		<div class="rounded_ul">
		<div class="rounded_ur">
		
		<div class="bubble">
			<h1><?php echo $testman_langres["search_header"]; ?></h1>
			
			<table id="searchform">
				<tr>
					<td><label for="search_revision"><?php echo $testman_langres["revision"]; ?>:</label></td>
					<td>
						<input type="text" id="search_revision" value="" size="24" onkeypress="SearchInputs_OnKeyPress(event)" onkeyup="SearchRevisionInput_OnKeyUp(this)" /><br />
						
						<img src="../shared/images/info.gif" alt="" /> <?php printf($shared_langres["rangeinfo"], $rev, ($rev - 50), $rev); ?>
					</td>
				</tr>
				<tr>
					<td><label for="search_source"><?php echo $testman_langres["source"]; ?>:</label></td>
					<td>
						<input type="text" id="search_source" value="" size="24" onkeypress="SearchInputs_OnKeyPress(event)" />
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
				<img id="ajax_loading_search" src="../shared/images/ajax_loading.gif" alt="" />
			</span>
			
			<span class="controlgroup">
				<button onclick="CompareFirstTwoButton_OnClick()"><?php echo $testman_langres["comparefirsttwo_button"]; ?></button>
				<button onclick="CompareSelectedButton_OnClick()"><?php echo $testman_langres["compareselected_button"]; ?></button>
				<input type="checkbox" id="opennewwindow" onclick="OpenNewWindowCheckbox_OnClick(this)" /> <label for="opennewwindow"><?php echo $testman_langres["opennewwindow_checkbox"]; ?></label>
			</span>
			
			<div id="searchtable">
				<!-- Filled by the JavaScript -->
			</div>
		</div>
		
		</div>
		</div>
		</div>
		</div>
	</div><br />
	
	<iframe id="comparepage_frame" frameborder="0" onload="ResizeIFrame()" scrolling="no"></iframe>
</div>

</body>
</html>
