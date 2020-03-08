<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Compare Page
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2016 Kamil Hornicek (kamil.hornicek@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("autoload.inc.php");
	require_once("utils.inc.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/exceptions.php");
	require_once(ROOT_PATH . "rosweb/gitinfo.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	//$rw = new RosWeb($supported_languages);
	$rw = new RosWeb();
	$lang = $rw->getLanguage();
	require_once("lang/$lang.inc.php");

	try
	{
		// Check the parameters.
		if (!array_key_exists("ids", $_GET))
			throw new ErrorMessageException("Necessary information not specified");

		$gi = new GitInfo();
		$reader = new WineTest_Reader();
		$result = $reader->setTestIDList($_GET["ids"]);

		// Hide the filter to show only changed results if just one Test ID was passed.
		// We can't simply leave out the option entirely, because this would break the cookies storing the selected filters.
		$testman_controls  = sprintf('<div class="checkbox" %s><label><input type="checkbox" id="showchanged" name="filter"> %s</label></div>', ($reader->getTestIDCount() > 1 ? '' : 'style="display: none;"'), $testman_langres["showchanged"]);
		$testman_controls .= sprintf('<div class="checkbox"><label><input type="checkbox" id="showcrashed" name="filter"> %s</label></div>', $testman_langres["showcrashed"]);
		$testman_controls .= sprintf('<div class="checkbox"><label><input type="checkbox" id="hideok" name="filter"> %s</label></div>', $testman_langres["hideok"]);
		$testman_controls .= sprintf('<div class="checkbox"><label><input type="checkbox" id="hideblacklisted" name="filter"> %s</label></div>', $testman_langres["hideblacklisted"]);
		$testman_controls .= $testman_langres["export_as"];

		$table_summary = "";
		$table_totals = "";
		$table_performance = "";
		$table_results = "";
		$table_separator = "";
		$performance = array(
			"boot_cycles" => "",
			"context_switches" => "",
			"interrupts" => "",
			"system_calls" => "",
			"reboots" => "",
			"time" => "",
			"testing_time" => ""
		);
		$prev_row = null;
		$result_stmt = array();

		for ($i = 0; $i < $reader->getTestIDCount(); $i++)
		{
			$stmt = $reader->getTestRunInfoStatement($i);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$indicator = new Indicator($row["id"]);

			$table_summary .= '<th>';
			$table_summary .= sprintf($testman_langres["resulthead"], $gi->getShortHash($row["revision"]), GetDateString($row["timestamp"]), $row["name"], GetPlatformString($row["platform"]));
			$table_summary .= '</th>';

			$table_totals .= '<td>';
			$table_totals .= sprintf('<div title="%s" class="testmanbox totaltests totals">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], $row["count"], GetDifference($row, $prev_row, "count"));
			$table_totals .= sprintf('<div title="%s" class="testmanbox %s_failedtests totals">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], ($row["failures"] > 0 ? 'real' : 'zero'), $row["failures"], GetDifference($row, $prev_row, "failures"));
			$table_totals .= sprintf('<div class="healthindicator" onmouseover="HealthIndicator_OnMouseOver()" onmouseout="HealthIndicator_OnMouseOut()"><img src="%s" alt="healthindicator"/></div>', $indicator->getImagePath());
			$table_totals .= '</td>';

			$table_separator .= "<td>&nbsp;</td>";

			foreach ($performance as $key => $val)
			{
				$failed_reboots = ($key == 'reboots' && $row[$key] > MACHINE_REBOOTS_THRESHOLD) ? ' worse' : '';

				$performance[$key] .= sprintf('<td><div title="%s" class="testmanbox performancetests%s">%s <span class="diff">%s</span></div></td>', $testman_langres[$key], $failed_reboots, $row[$key], GetDifference($row, $prev_row, $key, true));
			}

			// Get the test results for each column.
			$result_stmt[$i] = $reader->getListResultInfoStatement($i);

			$prev_row = $row;
		}

		foreach ($performance as $key => $perf_text)
			$table_performance .= '<tr><td>' . $testman_langres[$key] . '</td>' . $perf_text . '</tr>';

		$suites_stmt = $reader->getListTestSuiteInfoStatement();

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

			$suite_name = $suites_row["module"] . ':' . $suites_row["test"];

			if (in_array($suite_name, $blacklist))
				$blacklisted = true;

			$table_results .= sprintf('<tr id="suite_%s" title="%s">', $suites_row["id"], ($blacklisted ? $testman_langres["blacklisted"] : $suite_name));
			$table_results .= sprintf('<td class="%s">%s</td>', ($blacklisted ? 'blacklisted' : ''), $suite_name);

			for ($i = 0; $i < $reader->getTestIDCount(); $i++)
			{
				$row = $result_stmt[$i]->fetch(PDO::FETCH_ASSOC);

				$table_results .= sprintf('<td class="%s %s"', ($blacklisted ? 'blacklisted' : ''), ($row["id"] ? 'clickable' : ''));

				if ($row["id"])
					$table_results .= sprintf(' onclick="Result_OnClick(%d, %d)"', $row["id"], $prev_row["id"]);

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

					$table_results .= sprintf('<div title="%s" class="testmanbox totaltests">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], GetTotalTestsString($row), GetDifference($row, $prev_row, "count"));
					$table_results .= sprintf('<div title="%s" class="testmanbox %s_failedtests">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], $class, $row["failures"], GetDifference($row, $prev_row, "failures"));
					$table_results .= sprintf('<div title="%s" class="testmanbox skippedtests">%d <span class="diff">%s</span></div>', $testman_langres["skippedtests"], $row["skipped"], GetDifference($row, $prev_row, "skipped"));
					$table_results .= sprintf('<div title="%s" class="testmanbox timetest">%g </div>', $testman_langres["timetest"], $row["time"]);
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
		}

		// Display summary (excluding blacklisted suites)
		$summary_count = NULL;
		$summary_failures = NULL;
		for ($i = 0; $i < $reader->getTestIDCount(); $i++)
		{
			$summary_count .= '<td>';
			$summary_count .= sprintf('<div title="%s" class="testmanbox totaltests totals">%s <span class="diff">%s</span></div>', $testman_langres["totaltests"], $summary[$i]["total"], GetDifference($summary[$i], $summary[$i - 1], "total"));
			$summary_count .= sprintf('<div title="%s" class="testmanbox difference better">%s%s</div>', $testman_langres["totaltests"].' '.$testman_langres["inc"], $summary[$i]["count_inc"] > 0 ? '+' : '', $summary[$i]["count_inc"]);
			$summary_count .= sprintf('<div title="%s" class="testmanbox difference worse">%s%s</div>', $testman_langres["totaltests"].' '.$testman_langres["dec"], $summary[$i]["count_dec"] > 0 ? '+' : '', $summary[$i]["count_dec"]);
			$summary_count .= '</td>';

			$summary_failures .= '<td>';
			$summary_failures .= sprintf('<div title="%s" class="testmanbox %s_failedtests totals">%d <span class="diff">%s</span></div>', $testman_langres["failedtests"], (($summary[$i]["failed"] > 0) ? 'real' : 'zero'), $summary[$i]["failed"], GetDifference($summary[$i], $summary[$i - 1], "failed"));
			$summary_failures .= sprintf('<div title="%s" class="testmanbox difference better">%s%s</div>', $testman_langres["failedtests"].' '.$testman_langres["dec"], $summary[$i]["fail_dec"] > 0 ? '+' : '', $summary[$i]["fail_dec"]);
			$summary_failures .= sprintf('<div title="%s" class="testmanbox difference worse">%s%s</div>', $testman_langres["failedtests"].' '.$testman_langres["inc"], $summary[$i]["fail_inc"] > 0 ? '+' : '', $summary[$i]["fail_inc"]);
			$summary_failures .= '</td>';
		}

		$testman_filterable = implode(",", $filterable_rows);
	}
	catch (ErrorMessageException $e)
	{
		die($e->getMessage());
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}

	// Actually show the content
	require_once("compare.templ.php");
