<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Compare Page
  COPYRIGHT:  Copyright 2008-2009 Colin Finck <colin@reactos.org>
  
  charset=utf-8 without BOM
*/

	require_once("config.inc.php");
	require_once("common.inc.php");
	require_once("autoload.inc.php");
	require_once("utils.inc.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	$rw = new RosWeb($supported_languages);
	$lang = $rw->getLanguage();

	require_once("lang/$lang.inc.php");
	
	if (!array_key_exists("ids", $_GET))
		die("Necessary information not specified");
	
	$reader = new WineTest_ResultReader();
	$result = $reader->setTestIDList($_GET["ids"]);
	
	// A string return value indicates an error.
	if (is_string($result))
		die($result);
		
	// Activate the option to only show the changed results between several test runs if more than one Test ID was passed.
	$testman_controls = "";
	$testman_controls .= sprintf('<div%s><input type="checkbox" id="showchanged" name="filter"> <label for="showchanged">%s</label></div>', ($reader->getTestIDCount() > 1 ? '' : ' style="display: none;"'), $testman_langres["showchanged"]);
	$testman_controls .= sprintf('<div><input type="checkbox" id="showcrashed" name="filter"> <label for="showcrashed">%s</label></div>', $testman_langres["showcrashed"]);
	$testman_controls .= sprintf('<div><input type="checkbox" id="hideok" name="filter"> <label for="hideok">%s</label></div>', $testman_langres["hideok"]);
	$testman_controls .= sprintf('<div><input type="checkbox" id="hideblacklisted" name="filter"> <label for="hideblacklisted">%s</label></div>', $testman_langres["hideblacklisted"]);
	$testman_controls .= $testman_langres["export_as"];
	$testman_controls .= ":";

	$table_summary = "";
	$table_totals = "";
	$table_performance = "";
	$table_results = "";
	$table_separator = "";
	$odd = true;
	$performance = array("boot_cycles" => "", "context_switches" => "",
		"interrupts" => "", "system_calls" => "",
		"reboots" => "", "time" => "", "testing_time" => "");
	$prev_row = null;
	$result_stmt = array();
	
	for ($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$stmt = $reader->getTestRunInfoStatement($i);
		
		if (is_string($stmt))
			die($stmt);
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$indicator = new Indicator($row["id"]);
		
		$table_summary .= '<th onmousedown="ResultHead_OnMouseDown(this)">';
		$table_summary .= sprintf($testman_langres["resulthead"], $row["revision"], GetDateString($row["timestamp"]), $row["name"], GetPlatformString($row["platform"]));
		$table_summary .= '</th>';
		
		$table_totals .= '<td>';
		$table_totals .= sprintf('<div title="%s" class="box totaltests totals">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], $row["count"], GetDifference($row, $prev_row, "count"));
		$table_totals .= sprintf('<div title="%s" class="box %s_failedtests totals">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], ($row["failures"] > 0 ? 'real' : 'zero'), $row["failures"], GetDifference($row, $prev_row, "failures"));
		$table_totals .= sprintf('<div class="healthindicator" onmouseover="HealthIndicator_OnMouseOver()" onmouseout="HealthIndicator_OnMouseOut()"><img src="%s" alt="healthindicator"/></div>', $indicator->imagePath);
		$table_totals .= '</td>';
		
		$table_separator .= "<td>&nbsp;</td>";
		
		foreach ($performance as $key => $val)
			$performance[$key] .= sprintf('<td><div title="%s" class="box performancetests">%s <span class="diff">%s</span></div></td>', $testman_langres[$key], $row[$key], GetDifference($row, $prev_row, $key, true));

		// Get the test results for each column
		$result_stmt[$i] = $reader->getListResultInfoStatement($i);
		
		if (is_string($result_stmt[$i]))
			die($result_stmt[$i]);

		$prev_row = $row;
	}
	
	foreach ($performance as $key => $perf_text)
	{
		$table_performance .= '<tr class="'.(($odd == true) ? "odd" : "even").'"><td>'.$testman_langres[$key].'</td>'.$perf_text.'</tr>';
		$odd = !$odd;
	}

	$suites_stmt = $reader->getListTestSuiteInfoStatement();
	
	if (is_string($suites_stmt))
		die($suites_stmt);
	
	$unchanged = array();
	$uncrashed = array();
	
	$summary = array_fill(-1, $reader->getTestIDCount() + 1, array("total" => 0, "failed" => 0, "fail_inc" => 0, "fail_dec" => 0, "count_inc" => 0, "count_dec" => 0));
	$summary[-1] = array("total" => null, "failed" => null, "fail_inc" => NULL, "fail_dec" => NULL, "count_inc" => NULL, "count_dec" => NULL);
	
	$blacklist = GetBlacklist();

	while ($suites_row = $suites_stmt->fetch(PDO::FETCH_ASSOC))
	{
		$changed = false;
		$crashed = false;
		$blacklisted = false;
		$prev_row = null;
		$temp_totaltests = -1;
		$temp_failedtests = -1;
		$temp_skippedtests = -1;

		$suite_name = $suites_row["module"].':'.$suites_row["test"];

		if (in_array($suite_name, $blacklist))
			$blacklisted = true;

		$table_results .= sprintf('<tr id="suite_%s" class="%s" title="%s">', $suites_row["id"], ($blacklisted ? "blacklisted" : ($odd ? "odd" : "even")), ($blacklisted ? $testman_langres["blacklisted"] : $suite_name));
		$table_results .= sprintf('<td%s>%s</td>', ($blacklisted ? ' class="blacklisted"' : null), $suite_name);
	
		for ($i = 0; $i < $reader->getTestIDCount(); $i++)
		{
			$row = $result_stmt[$i]->fetch(PDO::FETCH_ASSOC);
			
			$table_results .= '<td onmouseover="Cell_OnMouseOver(this)" onmouseout="Cell_OnMouseOut(this)"';
			
			if ($row["id"])
				$table_results .= sprintf(' class="clickable" onclick="Result_OnClick(%d, %d)"', $row["id"], $prev_row["id"]);
			
			$table_results .= '>';
			
			// Check whether there are any changes within the test results of several runs
			CheckIfChanged($changed, $temp_totaltests, $row["count"]);
			CheckIfChanged($changed, $temp_failedtests, $row["failures"]);
			CheckIfChanged($changed, $temp_skippedtests, $row["skipped"]);
			
			if (!$blacklisted)
			{
				$summary[$i]["total"] += $row["count"];
				$summary[$i]["failed"] += $row["failures"];
		        
				if ($prev_row)
				{
					$fail_diff = $row["failures"] - $prev_row["failures"];
					$count_diff = $row["count"] - $prev_row["count"];
                    
					if ($fail_diff > 0)
						$summary[$i]["fail_inc"] += $fail_diff;
					else
						$summary[$i]["fail_dec"] += $fail_diff;
                       
					if ($count_diff > 0)
						$summary[$i]["count_inc"] += $count_diff;
					else
						$summary[$i]["count_dec"] += $count_diff;

				}
			}
			
			if ($row["id"])
			{
				$crashed = ($crashed || $row["status"] != "ok");
				
				$class = 'zero';
				
				if ($row["failures"] > 0 || $row["status"] != "ok")
				{
					$class = 'real';
				}
				else if ($row['todo'] > 0)
				{
					$class = 'todo';
				}
				
				$table_results .= sprintf('<div title="%s" class="box totaltests">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], GetTotalTestsString($row), GetDifference($row, $prev_row, "count"));
				$table_results .= sprintf('<div title="%s" class="box %s_failedtests">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], $class, $row["failures"], GetDifference($row, $prev_row, "failures"));
				$table_results .= sprintf('<div title="%s" class="box skippedtests">%d <span class="diff">%s</span></div>', $testman_langres["skippedtests"], $row["skipped"], GetDifference($row, $prev_row, "skipped"));
			}
			else
			{
				// Bloody IE Hack
				$table_results .= "&nbsp;";
			}
			
			$table_results .= '</td>';
			
			$prev_row = $row;
		}
		
		$table_results .= '</tr>';
				
		if (!$changed || !$crashed || $row["failures"] == 0 || $blacklisted)
		{
			$filterable_rows[] = $suites_row["id"];
			$filterable_rows[] = ((!$changed && $reader->getTestIdCount() > 1) ? 1 : 0);
			$filterable_rows[] = (!$crashed ? 1 : 0);
			$filterable_rows[] = (($row["failures"] == 0 && !$crashed) ? 1 : 0);
			$filterable_rows[] = ($blacklisted ? 1 : 0);
		}
		
		$odd = !$odd;
	}
	
	// Display summary (excluding blacklisted suites)

	$summary_count = NULL;
	$summary_failures = NULL;
	for ($i = 0; $i < $reader->getTestIDCount(); $i++)
	{
		$summary_count .= '<td>';
	   	$summary_count .= sprintf('<div title="%s" class="box totaltests totals">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], $summary[$i]["total"], GetDifference($summary[$i], $summary[$i - 1], "total"));
		$summary_count .= sprintf('<div title="%s" class="box difference better">%s%s</div>', $testman_langres["totaltests"].' '.$testman_langres["inc"], $summary[$i]["count_inc"] > 0 ? '+' : '', $summary[$i]["count_inc"]);
		$summary_count .= sprintf('<div title="%s" class="box difference worse">%s%s</div>', $testman_langres["totaltests"].' '.$testman_langres["dec"], $summary[$i]["count_dec"] > 0 ? '+' : '', $summary[$i]["count_dec"]);
		$summary_count .= '</td>';
		
		$summary_failures .= '<td>';
		$summary_failures .= sprintf('<div title="%s" class="box %s_failedtests totals">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], (($summary[$i]["failed"] > 0) ? 'real' : 'zero'), $summary[$i]["failed"], GetDifference($summary[$i], $summary[$i - 1], "failed"));
		$summary_failures .= sprintf('<div title="%s" class="box difference better">%s%s</div>', $testman_langres["failedtests"].' '.$testman_langres["dec"], $summary[$i]["fail_dec"] > 0 ? '+' : '', $summary[$i]["fail_dec"]);
		$summary_failures .= sprintf('<div title="%s" class="box difference worse">%s%s</div>', $testman_langres["failedtests"].' '.$testman_langres["inc"], $summary[$i]["fail_inc"] > 0 ? '+' : '', $summary[$i]["fail_inc"]);
		$summary_failures .= '</td>';
	}
	
	$testman_filterable = implode(",", $filterable_rows);
	$summary_class = $odd ? "odd" : "even";
	
	// Actually show the content
	require_once("compare.templ.php");
