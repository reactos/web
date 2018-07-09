<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Easily download prebuilt ReactOS Revisions
 * COPYRIGHT:   Copyright 2007-2018 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2013 Aleksey Bragin (aleksey@reactos.org)
 */

	require_once("config.inc.php");
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
	<title><?php echo $getbuilds_langres["title"]; ?></title>
	<?php echo $rw->getHead(); ?>
	<link rel="stylesheet" type="text/css" href="/sites/all/themes/Porto/css/skins/default-style.css" />
	<link rel="stylesheet" type="text/css" href="getbuilds.css" />
	<script type="text/javascript">
		var ISO_DOWNLOAD_URL = '<?php echo $ISO_DOWNLOAD_URL; ?>';
		var MAX_FILES_PER_PAGE = <?php echo $MAX_FILES_PER_PAGE; ?>;
	</script>
	<script type="text/javascript" src="/rosweb/lang/<?php echo $lang; ?>.js"></script>
	<script type="text/javascript" src="/rosweb/js/ajax.js"></script>
	<script type="text/javascript" src="lang/<?php echo $lang; ?>.js"></script>
	<script type="text/javascript" src="getbuilds.js"></script>
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

			<div class="form-horizontal">
				<div class="form-group">
					<label for="revision" class="col-sm-2 control-label"><?php echo $shared_langres["revision"]; ?></label>

					<div class="col-sm-10 form-inline">
						<button class="btn btn-default" id="previous_button" disabled="disabled"><i class="icon icon-chevron-left"></i></button>
						<input class="form-control" type="text" id="revision" value="<?php echo $rev; ?>" size="50"> 
						<button class="btn btn-default" id="next_button" disabled="disabled"><i class="icon icon-chevron-right"></i></button><br>

						<?php printf($shared_langres["rangeinfo"], $rev, $rev_before, $rev); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $getbuilds_langres["imagetypes"]; ?></label>

					<div class="col-sm-3">
						<?php
							foreach ($PREFIXES as $k => $v)
								printf('<div class="checkbox"><label><input type="checkbox" name="prefixes" id="%s" checked="checked"> %s</label></div>', $k, $v);
						?>
					</div>

					<div class="col-sm-3">
						<?php
							foreach ($SUFFIXES as $k => $v)
								printf('<div class="checkbox"><label><input type="checkbox" name="suffixes" id="%s" %s> %s</label></div>', $k, $v[1] == TRUE ? 'checked="checked"' : '', $v[0]);
						?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<button class="btn btn-primary" onclick="SearchButton_OnClick()"><i class="icon icon-search"></i> <?php echo $shared_langres["search_button"]; ?></button>
					<i class="icon icon-cog icon-spin" id="ajax_loading"></i><br><br>
				</div>

				<div class="col-md-6">
					<a class="btn btn-default" href="<?php echo $ISO_DOWNLOAD_URL; ?>" target="_blank"><?php echo $getbuilds_langres["browsebuilds"]; ?></a>
					<a class="btn btn-default" href="<?php echo $GITHUB_URL; ?>" target="_blank"><?php echo $getbuilds_langres["browsegithub"]; ?></a>
				</div>
			</div>

			<div id="filetable">
				<!-- Filled by the JavaScript -->
			</div>

			<hr>
			<h3><?php echo $getbuilds_langres["legend"]; ?></h3>

			<ul class="list-unstyled">
				<li><strong>Boot CD</strong> - <?php echo $getbuilds_langres["build_bootcd"]; ?></li>
				<li><strong>Live CD</strong> - <?php echo $getbuilds_langres["build_livecd"]; ?></li>
				<li><strong>Debug</strong> - <?php echo $getbuilds_langres["build_dbg"]; ?></li>
				<li><strong>Release</strong> - <?php echo $getbuilds_langres["build_rel"]; ?></li>
			</ul>
		</div>
	</div>
</div>

<?php echo $rw->getFooter(); ?>

</div>
</body>
</html>
