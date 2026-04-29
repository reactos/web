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

	$getbuilds_langres["title"] = "Pobierz skompilowane wersje rozwojowe ReactOS";
	$getbuilds_langres["intro"] = 'Tutaj możesz pobrać najnowszą ale także starsze wersje rozwojowe Reactos, które zostały stworzone przez naszego <a href="https://build.reactos.org">BuildBota</a>.';

	$getbuilds_langres["imagetypes"] = "Image Types";
	$getbuilds_langres["browsebuilds"] = "Przeglądaj wszystkie stworzone wersje";
	$getbuilds_langres["browsegithub"] = "Przeglądaj repozytorium GitHub";

	//$getbuilds_langres["js_disclaimer"] = 'Musisz włączyć JavaScript w Twojej przeglądarce, aby używać listy plików.<br>Możesz również pobrać wszystkie skompilowane wersje <a href="%s">tutaj</a>.';
	$getbuilds_langres["prevrev"] = "Poprzednia wersja";
	$getbuilds_langres["nextrev"] = "Następna wersja";

	$getbuilds_langres["foundfiles"] = "Znaleziono %s plików!";
	$getbuilds_langres["filename"] = "Nazwa pliku";
	$getbuilds_langres["size"] = "Rozmiar";
	$getbuilds_langres["date"] = "Ostatnio modyfikowany";

	$getbuilds_langres["nofiles"] = "Brak skompilowanych plików dla wersji %s! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Błędny numer wersji!";

	$getbuilds_langres["rangelimitexceeded"] = "Przedział może zawierać maksymalnie %s wersji!";

	$getbuilds_langres["legend"] = "Legend";
	$getbuilds_langres["build_bootcd"] = "Boot Media are designed to install ReactOS onto an HDD and enjoy the new features since the last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU). Alternatively, you can choose to give ReactOS a try without installing it, for example in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.";
	$getbuilds_langres["build_livecd"] = "Live CDs (deprecated) were the former way to test ReactOS without installing it. These have been replaced by the Boot Media since ReactOS 0.4.16 release.";
	$getbuilds_langres["build_dbg"] = "Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
	$getbuilds_langres["build_rel"] = "Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
?>
