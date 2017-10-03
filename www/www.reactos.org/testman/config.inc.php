<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Configuration Settings
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 */

	define("ROOT_PATH", "../");
	define("INDICATORS_PATH", "indicators/");

	define("DEFAULT_SEARCH_LIMIT", 10);
	define("DEFAULT_SEARCH_SOURCE", "Build GCCLin_x86 on Test KVM");
	define("MAX_COMPARE_RESULTS", 8);
	define("RESULTS_PER_PAGE", 10);
	define("MACHINE_REBOOTS_THRESHOLD", 2);
	define("REV_RANGE_LIMIT", 3000);

	define("VIEWVC", "https://svn.reactos.org/svn/reactos");
	define("VIEWVC_TRUNK", VIEWVC . "/trunk");
	define("BLACKLIST_URL", "blacklist.txt");

	// We never had builds < r10000 and never reached > r99999...
	$SVN_PATTERN = "#[0-9]{5}#";
