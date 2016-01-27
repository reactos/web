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

	//$rw = new RosWeb($supported_languages);
	$rw = new RosWeb();
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
	<?php echo $rw->getHead(); ?>
	<link rel="stylesheet" type="text/css" href="/sites/all/themes/Porto/css/skins/default-style.css" />
	<script type="text/javascript" src="/rosweb/js/ajax.js"></script>
	<script type="text/javascript">
		<?php require_once("getbuilds.js.php"); ?>
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
							<li><a href="/getbuilds">Get Builds</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h2><?php echo $getbuilds_langres["title"]; ?></h2>
				</div>
			</div>
		</div>
	</section>

	<div class="content">
		<div class="container">
			<p class="lead center"><?php echo $getbuilds_langres["intro"]; ?></p>
			<hr>

			<div class="col-md-9">
				<div class="form-horizontal">
					<div class="form-group">
						<label for="revnum" class="col-sm-2 control-label">Revision</label>

						<div class="col-sm-10 form-inline">
							<button class="btn btn-default" onclick="PrevRev()"><i class="icon icon-chevron-left"></i></button>
							<input class="form-control" type="text" id="revnum" value="<?php echo $rev; ?>" size="12" onkeyup="CheckRevNum(this);"> 
							<button class="btn btn-default" onclick="NextRev()"><i class="icon icon-chevron-right"></i></button><br>

							<?php printf($shared_langres["rangeinfo"], $rev, ($rev - 50), $rev); ?><br>
							<?php echo $getbuilds_langres["latestrev"]; ?>: <strong><?php echo $rev; ?></strong>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Image Types</label>

						<div class="col-sm-3">
							<div class="checkbox"><label><input type="checkbox" id="bootcd-dbg" checked="checked"> Debug Boot CDs</label></div>
							<div class="checkbox"><label><input type="checkbox" id="bootcd-rel" checked="checked"> Release Boot CDs</label></div>
						</div>

						<div class="col-sm-3">
							<div class="checkbox"><label><input type="checkbox" id="livecd-dbg" checked="checked"> Debug Live CDs</label></div>
							<div class="checkbox"><label><input type="checkbox" id="livecd-rel" checked="checked"> Release Live CDs</label></div>
						</div>

						<div class="col-sm-3">
							<button class="btn btn-primary btn-lg" style="margin-top: 7px;" onclick="ShowRev()"><?php echo $getbuilds_langres["showrev"]; ?></button>
						</div>
					</div>
				</div>

				<div id="ajax_loading">
					<i class="icon icon-cog icon-spin"></i> <?php echo $getbuilds_langres["gettinglist"]; ?>...
				</div>

				<div id="filetable">
					<!-- Filled by the JavaScript -->
				</div>
			</div>

			<div class="col-md-3">
				<a class="button-margin center-block mcround" href="<?php echo $SVN_BROWSE_URL; ?>" title="<?php echo $getbuilds_langres["browsesvn"]; ?>" rel="tooltip"><i class="icon icon-code"></i></a>
				<a class="button-margin center-block mcround" href="<?php echo $ISO_DOWNLOAD_URL; ?>" title="<?php echo $getbuilds_langres["browsebuilds"]; ?>" rel="tooltip"><i class="icon icon-folder-open-o"></i></a>
			</div>

			<div class="col-md-12">
				<hr>
				<h1><?php echo $getbuilds_langres["legend"]; ?></h1>

				<ul class="list-unstyled">
					<li><?php echo $getbuilds_langres["build_bootcd"]; ?></li>
					<li><?php echo $getbuilds_langres["build_livecd"]; ?></li>
					<li><?php echo $getbuilds_langres["build_dbg"]; ?></li>
					<li><?php echo $getbuilds_langres["build_rel"]; ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php echo $rw->getFooter(); ?>

</div>
</body>
</html>
