<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     The template for every RosLogin page
 * COPYRIGHT:   Copyright 2018-2020 Colin Finck (colin@reactos.org)
 */

	// This file must only be used as an include from index.php where $page is set.
	if (!isset($page))
		die("Must be used as an include from index.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php
		$page->printTitle();
		echo ROSLOGIN_TITLE_SUFFIX;
	?></title>
	<?php $rw->printHead(); ?>
	<?php $page->printHead(); ?>
</head>
<body>

<?php $rw->printHeader(); ?>

<div class="row" id="heading-breadcrumbs">
	<div class="col-md-offset-1 col-md-10">
		<div class="breadcrumbs">
			<a href="/">home</a> / <a href="/roslogin">roslogin</a>
		</div>
		<h1><?php $page->printTitle(); ?></h1>
	</div>
</div>

<section id="content" class="row">
	<div class="col-md-10 col-md-offset-1">
		<?php $page->printContent(); ?>
	</div>
</section>

<?php
	$rw->printFooter();
	$rw->printCookieBanner();
?>

</body>
</html>
