<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     English strings
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 * TRANSLATOR:  Colin Finck (colin@reactos.org)
 *
 * charset=utf-8 without BOM
 */

	$testman_langres = array(
		// Index page
		"index_title" => "ReactOS Testman",
		"index_intro" => "This interface enables you to find, view and compare Results of automatically performed Regression Tests.",

		"date" => "Date",
		"source" => "Source",
		"platform" => "Platform",
		"comment" => "Comment",

		"search_header" => "Search for Test Results",
		"search_button" => "Search",
		"comparefirsttwo_button" => "Compare first two Results",
		"compareselected_button" => "Compare selected Results",
		"opennewwindow_checkbox" => "Open in new Window",

		// Compare page
		"compare_title" => "Comparing Results",
		"showchanged" => "Show only changed results",
		"showcrashed" => "Show only Crash/Canceled results",
		"hideok" => "Hide successful results",
		"hideblacklisted" => "Hide blacklisted results",
		"export_as" => "Export as",

		"healthindicator_intro" => "The <i>Health Indicator</i> gives a rough overview about the entire test result.<br />A stripe represents the result of a single test suite. The following colors are used for this:",
		"healthindicator_test_crashedcanceled" => "The test suite has crashed or has been canceled.",
		"healthindicator_test_succeeded" => "The test suite has been completed without errors.",
		"healthindicator_test_failed" => "All tests of the test suite have failed.",
		"healthindicator_outro" => "A color between green and red approximately shows how many tests have failed.",

		"legend" => "Legend",
		"totaltests" => "Total Tests",
		"failedtests" => "Failed Tests",
		"skippedtests" => "Skipped Tests",
		"todotests" => "Todo Tests",
		"timetest" => "Time",
		"difference" => "Difference to the previous result",

		"testsuite" => "Test Suite",
		"resulthead" => "Revision %s (%s)<br />at %s<br />by %s<br />under %s",
		"totals" => "Totals",

		"blacklisted" => "blacklisted",

		//Performance
		"boot_cycles" => "boot cycles",
		"context_switches" => "boot context switches",
		"interrupts" => "boot interrupts",
		"reboots" => "machine reboots",
		"system_calls" => "boot system calls",
		"time" => "total time (min)",
		"testing_time" => "tests time (min)",

		//Summary
		"summary" => "Totals (non blacklisted)",
		"count" => "Tests performed",
		"failures" => "Failures",
		"inc" => "Increase",
		"dec" => "Decrease",

		// Result Details page
		"detail_title" => "Result Details",

		"show_diff" => "Diff to previous run",
		"diff_sbs" => "Side by side",
		"diff_sbs_stripped" => "Side by side (no debug)",
		"diff_inline_stripped" => "Inline (no debug)",

		"thisresult" => "Information about this Result",
		"log" => "Log",
		"associatedtest" => "Information about the associated Test",
	);
