<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Configuration Settings
 * COPYRIGHT:   Copyright 2008-2018 Colin Finck (colin@reactos.org)
 */

	define("ROOT_PATH", "../");

	define("MAX_COMPARE_RESULTS", 16);
	define("RESULTS_PER_PAGE", 10);
	define("MACHINE_REBOOTS_THRESHOLD", 2);

	// A source is listed on the front page if it submitted a result within this many days.
	define("LANDING_ACTIVE_DAYS", 30);

	// Runs per page of the test suite history.
	define("SUITE_HISTORY_PAGE_SIZE", 50);

	define("VIEWVC", "https://git.reactos.org/?p=reactos.git");
	define("VIEWVC_TRUNK", VIEWVC . ";a=blob");
	define("BLACKLIST_URL", "blacklist.txt");
	define("GITHUB_PR_URL", "https://github.com/reactos/reactos/pull/%u");
