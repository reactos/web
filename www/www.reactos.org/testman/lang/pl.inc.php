<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Translation
  COPYRIGHT:  Copyright 2008-2015 Colin Finck <colin@reactos.org>
  TRANSLATOR: Maciej Bialas
              Mariusz Przybylski
              Olaf Siejka
  
  charset=utf-8 without BOM
*/

	$testman_langres = array(
		// Index page
		"index_title" => "Menedżer testów ReactOS",
		"js_disclaimer" => "Musisz włączyć obsługę JavaScriptu, aby używać tego interfejsu!",
		
		"date" => "Data",
		"revision" => "Rewizja",
		"source" => "Źródło",
		"platform" => "Platforma",
		"comment" => "Komentarz",
		
		"search_header" => "Szukaj wyników testów",
		"search_button" => "Szukaj",
		"comparefirsttwo_button" => "Porównaj dwa ostatnie wyniki testów",
		"compareselected_button" => "Porównaj wybrane wyniki",
		"opennewwindow_checkbox" => "Otwórz w nowym oknie",

		"datefrom" => "From",
		"dateto" => "To",
		"minfailures" => "Min. Failures",
		"revisionhint" => "Start of the commit hash, e.g. %s. Also matches pull request builds based on that commit.",
		"revisionfrom" => "From revision",
		"revisionto" => "To revision",
		"revisionrangehint" => "Position on master, so PR builds based on a commit in the range are included too",
		"allsources" => "All Sources",
		"allplatforms" => "All Platforms",
		"reset_button" => "Reset",
		"overview_title" => "Latest Result per Source",
		"showhistory" => "History",
		"prbuilds" => "Builds",
		"masteronly" => "master only",
		"allbuilds" => "master and pull requests",
		"onepr" => "Pull request %s",
		"basedon" => "based on %s",
		"approximate" => "Position estimated from the run time, not from the commit it was built on",
		"prbaseline" => "Compared against the newest master run of the same builder at or below this position.",
		"includepr" => "Include pull request builds",
		"noresults" => "No Results!",

		// Suite History page
		"suite_title" => "Test Suite History",
		"teststatus" => "Status",
		"notrun" => "not run",
		"newer" => "Newer",
		"older" => "Older",
		"showdiff" => "Diff",
		"suitehistory" => "History of this Test Suite",
		
		"foundresults" => "Znaleziono %s wyników!",
		"noresults" => "Brak wyników wyszukiwania!",		
		"status" => "%s testów wybranych do porównania",
		"clearselected" => "Clear selection",
		
		"noselection" => "Nie wybrałeś/aś żadnych wyników!",
		"selectatleast" => "Musisz wybrać przynajmniej %d wyników do porównania!",
		"maxselection" => "Możesz zaznaczyć do porównania maksymalnie %d wyników!",
		
		// Compare page
		"compare_title" => "Porównywanie wyników",
		"showchanged" => "Pokaż tylko zmienione wyniki",
		"showcrashed" => "Pokaż tylko wyniki Crash/Canceled",
		"hideok" => "Hide successful results",
		"hideblacklisted" => "Hide blacklisted results",
		"export_as" => "Eksportuj jako",
		
		"healthindicator_intro" => "<i>Health Indicator</i> podaje uogólniony rezultat wszystkich zestawów testów.<br />Każdy pasek reprezentuje wynik danego zestawu. Stosuje się następujące oznaczenia:",
		"healthindicator_test_crashedcanceled" => "Krytyczny błąd aplikacji testowej lub jej anulowanie.",
		"healthindicator_test_succeeded" => "Zestaw testów ukończony pomyślnie.",
		"healthindicator_test_failed" => "Wszystkie testy z zestawu zakończyły się niepowodzeniem.",
		"healthindicator_outro" => "Barwa pomiędzy czerwoną a zieloną. Im bardziej zielona, tym więcej testów zakończyło się pomyślnie.",
		
		"legend" => "Legenda",
		"totaltests" => "Wszystkie testy",
		"failedtests" => "Nieudane",
		"skippedtests" => "Pominięte",
		"todotests" => "Todo tests",
		"timetest" => "Time",
		"difference" => "Różnica względem poprzedniego wyniku",
		
		"testsuite" => "Zestaw testów",
		"resulthead" => "Rewizja %d (%s)<br />dnia %s<br />przez %s<br /> na %s",
		"totals" => "Łącznie",

		"blacklisted" => "blacklisted",

		//Performance
		"boot_cycles" => "boot cycles",
		"context_switches" => "boot context switches",
		"interrupts" => "boot interrupts",
		"reboots" => "machine reboots",
		"system_calls" => "boot system calls",
		"time" => "total time (min)",

		//Summary
		"summary" => "Totals (non blacklisted)",
		"count" => "Tests performed",
		"failures" => "Failures",
		"inc" => "Increase",
		"dec" => "Decrease",
		
		// Result Details page
		"detail_title" => "Szczegóły wyniku",
		
		"show_diff" => "Diff to previous run",
		"diff_sbs" => "Side by side",
		"diff_sbs_stripped" => "Side by side (no debug)",
		"diff_inline_stripped" => "Inline (no debug)",
		
		"thisresult" => "Informacje o tym wyniku",
		"log" => "Dziennik",
		"associatedtest" => "Informacje o powiązanym teście",
	);
?>
