<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Maciej Bialas
              Olaf Siejka
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["header"] = '<a href="http://www.reactos.org/">Home</a> &gt; Wersje rozwojowe ReactOS z SVN';
	$getbuilds_langres["title"] = "Pobierz skompilowane wersje rozwojowe ReactOS";
	$getbuilds_langres["intro"] = 'Tutaj możesz pobrać najnowszą ale także starsze wersje rozwojowe Reactos, które zostały stworzone przez naszego <a href="http://www.reactos.org/wiki/index.php/RosBuild">BuildBota</a>.';
	
	$getbuilds_langres["overview"] = "Informacje ogólne";
	$getbuilds_langres["latestrev"] = "Ostatnia wersja ReactOS na serwerze SVN";
	$getbuilds_langres["browsesvn"] = "Przeglądaj repozytorium SVN";
	$getbuilds_langres["buildbot_status"] = "Status BuildBota";
	$getbuilds_langres["buildbot_web"] = "Zobacz szczegóły w Interfejsie Web BuildBota";
	$getbuilds_langres["browsebuilds"] = "Przeglądaj wszystkie stworzone wersje";
	
	$getbuilds_langres["downloadrev"] = "Pobierz skompilowaną wersję ReactOS";
	$getbuilds_langres["js_disclaimer"] = 'Musisz włączyć JavaScript w Twojej przeglądarce, aby używać listy plików.<br>Możesz również pobrać wszystkie skompilowane wersje <a href="%s">tutaj</a>.';
	$getbuilds_langres["showrevfiles"] = "Pokaż pliki wersji";
	$getbuilds_langres["prevrev"] = "Poprzednia wersja";
	$getbuilds_langres["nextrev"] = "Następna wersja";
	$getbuilds_langres["showrev"] = "Pokaż";
	$getbuilds_langres["gettinglist"] = "Pobieranie listy plików";
	$getbuilds_langres["isotype"] = "Pokaż typy obrazów CD";
	
	$getbuilds_langres["foundfiles"] = "Znaleziono %s plików!";
	
	$getbuilds_langres["filename"] = "Nazwa pliku";
	$getbuilds_langres["filesize"] = "Rozmiar";
	$getbuilds_langres["filedate"] = "Ostatnio modyfikowany";
	
	$getbuilds_langres["nofiles"] 	 = "Brak skompilowanych plików dla wersji %s! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Błędny numer wersji!";
	
	$getbuilds_langres["rangelimitexceeded"] = "Przedział może zawierać maksymalnie %s wersji!";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<tt>bootcd</tt> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
    $getbuilds_langres["build_livecd"] = "<tt>livecd</tt> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
    $getbuilds_langres["build_rel"] = "<tt>-rel</tt> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
    $getbuilds_langres["build_dbg"] = "<tt>-dbg</tt> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
    $getbuilds_langres["build_dbgwin"] = "<tt>-dbgwin</tt> - The same as the -dbg version + includes wine Gecko and winetests. ";
	$getbuilds_langres["build_msvc"] = "<strong>-msvc</strong> - Debug version includes debugging information and PDB files, use this version to debug with Windbg.";
?>
