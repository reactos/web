<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2015 Colin Finck <colin@reactos.org>
                                  Aleksey Bragin <aleksey@reactos.org>
*/
	require_once("config.inc.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	$rw = new RosWeb($supported_languages);
	$rev = $rw->getLatestRevision();
	$lang = $rw->getLanguage();

	require_once(ROOT_PATH . "rosweb/lang/$lang.inc.php");
	require_once("lang/$lang.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $getbuilds_langres["title"]; ?></title>
	<link rel="stylesheet" type="text/css" href="/rosweb/css/full.css">
	<link rel="stylesheet" type="text/css" href="getbuilds.css">
	<script type="text/javascript">
		document.write('<style type="text/css">');
		document.write('#js_stuff {display: block;}');
		document.write('<\/style>');
	</script>
	<script type="text/javascript" src="/rosweb/js/ajax.js"></script>
	<script type="text/javascript">
		<?php require_once("getbuilds.js.php"); ?>
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
	<h1><?php echo $getbuilds_langres["title"]; ?></h1>

	<p><?php echo $getbuilds_langres["intro"]; ?></p>

	<div class="round_corners_grey">
		<h2 class="pane-title"><?php echo $getbuilds_langres["overview"]; ?></h2>

		<?php echo $getbuilds_langres["buildbot_status"]; ?>:
		<ul class="web">
			<li><a href="<?php echo $BUILDBOT_URL; ?>"><?php echo $getbuilds_langres["buildbot_web"]; ?></a></li>
			<li><a href="<?php echo $ISO_DOWNLOAD_URL; ?>"><?php echo $getbuilds_langres["browsebuilds"]; ?></a></li>
		</ul>
	</div>

	<div class="round_corners">
		<h2 class="pane-title"><?php echo $getbuilds_langres["downloadrev"]; ?></h2>
		
		<noscript>
			<?php printf($getbuilds_langres["js_disclaimer"], $ISO_DOWNLOAD_URL); ?>
		</noscript>

		<div id="js_stuff">
			<fieldset style="border: 1px solid #808080">
				<legend><?php echo $getbuilds_langres["showrevfiles"]; ?>:</legend>

				<span id="revcontrols">
					<img src="images/left.png" alt="&lt;" title="<?php echo $getbuilds_langres["prevrev"]; ?>" onclick="PrevRev();"> 
					<input type="text" id="revnum" value="<?php echo $rev; ?>" size="12" onkeyup="CheckRevNum(this);"> 
					<img src="images/right.png" alt="&gt;" title="<?php echo $getbuilds_langres["nextrev"]; ?>" onclick="NextRev();">
					<br>
				</span>
				<img src="/rosweb/images/info.gif" alt=""> <?php printf($shared_langres["rangeinfo"], $rev, ($rev - 50), $rev); ?><br>
				<?php echo $getbuilds_langres["latestrev"]; ?>: <strong><?php echo $rev; ?></strong>
				<ul class="web">
					<li><a href="<?php echo $SVN_BROWSE_URL; ?>"><?php echo $getbuilds_langres["browsesvn"]; ?></a></li>
				</ul>
			</fieldset>

			<fieldset style="border: 1px solid #808080">
				<legend><?php echo $getbuilds_langres["isotype"]; ?></legend>

				<input type="checkbox" id="bootcd-dbg" checked="checked" /> Debug Boot CDs
				<input type="checkbox" id="livecd-dbg" checked="checked"> Debug Live CDs
				<input type="checkbox" id="bootcd-rel" checked="checked"> Release Boot CDs
				<input type="checkbox" id="livecd-rel" checked="checked"> Release Live CDs
				<input type="button" onclick="ShowRev();" value="<?php echo $getbuilds_langres["showrev"]; ?>" style="margin-left: 20px; font-weight:bold;">
			</fieldset>

			<div id="controlbox">
				<span id="ajax_loading">
					<img src="/rosweb/images/ajax_loading.gif" alt=""> <?php echo $getbuilds_langres["gettinglist"]; ?>...
				</span>
			</div>

			<div id="filetable">
				<!-- Filled by the JavaScript -->
			</div>
		</div>
	</div>
	<br>
	<div class="round_corners_grey">
		<h2 class="pane-title"><?php echo $getbuilds_langres["legend"]; ?></h2>
		<ul>
			<li><?php echo $getbuilds_langres["build_bootcd"]; ?></li>
			<li><?php echo $getbuilds_langres["build_livecd"]; ?></li>
			<li><?php echo $getbuilds_langres["build_rel"]; ?> </li>
			<li><?php echo $getbuilds_langres["build_dbg"]; ?> </li>
			<li><?php echo $getbuilds_langres["build_dbgwin"]; ?></li>
		</ul>
	</div>
</div></div>

<?php echo $rw->getFooter(); ?>

</body>
</html>
