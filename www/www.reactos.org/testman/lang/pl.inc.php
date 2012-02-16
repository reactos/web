<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Translation
  COPYRIGHT:  Copyright 2008-2011 Colin Finck <colin@reactos.org>
  TRANSLATOR: Maciej Bialas
              Mariusz Przybylski
              Olaf Siejka
  
  charset=utf-8 without BOM
*/

	$testman_langres = array(
		// Index page
		"index_header" => '<a href="http://www.reactos.org/">Strona główna</a> &gt; Menedżer testów ReactOS',
		"index_title" => "Menedżer testów ReactOS",
		"index_intro" => "Ten interfejs pozwala Tobie znaleźć, zobaczyć i porównać wyniki przeprowadzanych automatycznie testów regresji.",
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
		
		"foundresults" => "Znaleziono %s wyników!",
		"noresults" => "Brak wyników wyszukiwania!",		
		"status" => "%s testów wybranych do porównania",
		
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
		"difference" => "Różnica względem poprzedniego wyniku",
		
		"testsuite" => "Zestaw testów",
		"resulthead" => "Rewizja %d<br />dnia %s<br />przez %s<br /> na %s",
		"totals" => "Łącznie",
		
		"blacklisted" => "blacklisted",

		//Performance
		"boot_cycles" => "boot cycles",
		"context_switches" => "boot context switches",
		"interrupts" => "boot interrupts",
		"reboots" => "machine reboots",
		"system_calls" => "boot system calls",

		//Summary
		"summary" => "Totals (non blacklisted)",
		
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
