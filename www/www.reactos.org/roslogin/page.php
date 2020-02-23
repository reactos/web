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

<div class="main" role="main">
	<section class="page-top breadcrumb-wrap">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div id="breadcrumbs">
						<ul class="breadcrumb">
							<li><a href="/">Home</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h2><?php $page->printTitle(); ?></h2>
				</div>
			</div>
		</div>
	</section>

	<div class="content">
		<div class="container">
			<?php $page->printContent(); ?>
		</div>
	</div>
</div>

<?php $rw->printFooter(); ?>

</body>
</html>
