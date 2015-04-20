<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2015 Colin Finck <colin@reactos.org>
*/

	define("ROOT_PATH", "../");

	// Configuration
	$AJAX_GETFILES_PROVIDER_URL = "http://iso.reactos.org/scripts/ajax-getfiles-provider.php";
	$BUILDBOT_URL = "https://build.reactos.org/";
	$ISO_DOWNLOAD_URL = "http://iso.reactos.org/";
	$SVN_BROWSE_URL = "https://code.reactos.org/";

	$MAX_FILES_PER_PAGE = 100;			// The same value has to be set in "ajax-getfiles-provider.php"
?>
