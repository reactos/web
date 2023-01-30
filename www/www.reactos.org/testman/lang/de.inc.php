<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Translation
  COPYRIGHT:  Copyright 2008-2015 Colin Finck <colin@reactos.org>
  TRANSLATOR: Colin Finck
  
  charset=utf-8 without BOM
*/

	$testman_langres = array(
		// Index page
		"index_title" => "ReactOS Web Test Manager",
		"index_intro" => "Mit dieser Oberfläche können Sie die Ergebnisse automatisch ausgeführter Regression-Tests suchen, anzeigen und vergleichen.",
		"js_disclaimer" => "Sie müssen JavaScript aktivieren, um die Oberfläche zu benutzen!",
		
		"date" => "Datum",
		"revision" => "Revision",
		"source" => "Quelle",
		"platform" => "Plattform",
		"comment" => "Kommentar",
		
		"search_header" => "Nach Testergebnissen suchen",
		"search_button" => "Suchen",
		"comparefirsttwo_button" => "Erste zwei Ergebnisse vergleichen",
		"compareselected_button" => "Gewählte Ergebnisse vergleichen",
		"opennewwindow_checkbox" => "In neuem Fenster öffnen",
		
		"foundresults" => "%s Ergebnisse gefunden!",
		"noresults" => "Keine Suchergebnisse!",
		"status" => "%s Tests zum Vergleich ausgewählt",
		"clearselected" => "Auswahl aufheben",
		
		"noselection" => "Sie haben keine Ergebnisse ausgewählt!",
		"selectatleast" => "Sie müssen mindestens %d Ergebnisse zum Vergleich auswählen!",
		"maxselection" => "Sie dürfen nur bis zu %d Ergebnisse zum Vergleich auswählen!",
		
		// Compare page
		"compare_title" => "Ergebnisse vergleichen",
		"showchanged" => "Nur geänderte Ergebnisse anzeigen",
		"showcrashed" => "Nur Crash/Canceled-Ergebnisse anzeigen",
		"hideok" => "Erfolgreiche Ergebnisse verstecken",
		"hideblacklisted" => "Ergebnisse auf der schwarzen Liste verstecken",
		"export_as" => "Exportieren als",
		
		"healthindicator_intro" => "Der <i>Health Indicator</i> gibt einen groben Überblick über den gesamten Testverlauf.<br />Ein Streifen stellt dabei das Ergebnis einer einzelnen Test Suite dar. Folgende Farben werden dabei verwendet:",
		"healthindicator_test_crashedcanceled" => "Die Test Suite ist abgestürzt oder wurde abgebrochen.",
		"healthindicator_test_succeeded" => "Die Test Suite wurde ohne Fehler abgeschlossen.",
		"healthindicator_test_failed" => "Alle Tests der Test Suite sind fehlgeschlagen.",
		"healthindicator_outro" => "Eine Farbe zwischen grün und rot kennzeichnet ungefähr, wie viele Tests fehlgeschlagen sind.",
		
		"legend" => "Legende",
		"totaltests" => "Ausgeführte Tests",
		"failedtests" => "Fehlgeschlagene Tests",
		"skippedtests" => "Übersprungene Tests",
		"todotests" => "Todo tests",
		"timetest" => "Time",
		"difference" => "Unterschied zum vorherigen Ergebnis",
		
		"testsuite" => "Test Suite",
		"resulthead" => "Revision %d (%s)<br />am %s<br />von %s<br />unter %s",
		"totals" => "Gesamtzahlen",

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
		"detail_title" => "Ergebnis-Details",
		
		"show_diff" => "Diff to previous run",
		"diff_sbs" => "Side by side",
		"diff_sbs_stripped" => "Side by side (no debug)",
		"diff_inline_stripped" => "Inline (no debug)",
		
		"thisresult" => "Informationen über dieses Ergebnis",
		"log" => "Log",
		"associatedtest" => "Informationen über den zugeordneten Test",
	);
?>
