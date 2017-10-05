<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Easily download prebuilt ReactOS Revisions
 * COPYRIGHT:   Copyright 2007-2017 Colin Finck (colin@reactos.org)
 */

	define("ROOT_PATH", "../");

	// Configuration
	$AJAX_GETFILES_PROVIDER_URL = "https://iso.reactos.org/scripts/ajax-getfiles-provider.php";
	$BUILDBOT_URL = "https://build.reactos.org/";
	$ISO_DOWNLOAD_URL = "https://iso.reactos.org/";

	$PREFIXES = array(
		"reactos-bootcd-" => "Boot CDs",
		"reactos-livecd-" => "Live CDs",
	);

	$SUFFIXES = array(
		"-x86-gcc-lin-dbg" => "x86 GCC Debug",
		"-x86-gcc-lin-rel" => "x86 GCC Release",
		"-x86-msvc-win-dbg" => "x86 MSVC Debug",
		"-x64-msvc-win-dbg" => "x64 MSVC Debug",
	);

	$SVN_PREFIX_TRANSLATIONS = array(
		"reactos-bootcd-" => "bootcd-",
		"reactos-livecd-" => "livecd-"
	);

	$SVN_SUFFIX_TRANSLATIONS = array(
		"-x86-gcc-lin-dbg" => "-dbg",
		"-x86-gcc-lin-rel" => "-rel",
		"-x86-msvc-win-dbg" => "-dbg-msvc",
		"-x64-msvc-win-dbg" => "-x64-dbg-msvc"
	);

	// We never had builds < r10000 and never reached > r99999...
	$SVN_PATTERN = "#^[0-9]{5}$#";

	// The following values need to be set here and in "ajax-getfiles-provider.php"!
	$MAX_FILES_PER_PAGE = 100;
	$REV_RANGE_LIMIT = 3000;
