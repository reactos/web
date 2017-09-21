<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Configuration Settings for the Web Service
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 */

	define("ROOT_PATH", "../../");

	define("TESTMAN_URL", "https://reactos.org/testman/");
	define("BUILDER_URL", "https://build.reactos.org/builders/");
	define("STATUS_CHECK_EMAIL", "ros-builds@reactos.org");

	// Ensure we don't get bloated logs or even exceed PHP's memory limit
	// by defining a maximum amount of memory, which may be allocated by the
	// aggregator script
	// NOTE: The aggregator script allocates memory per test result, so this
	// has no effect on the total log size
	define("MAX_MEMORY", 4000000);
