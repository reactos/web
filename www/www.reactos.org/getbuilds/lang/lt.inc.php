<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Vytis Girdzijauskas <cman@cman.us>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "Parsisiųsti ReactOS SVN laidas";
	$getbuilds_langres["intro"] = 'Čia Jūs galite parsisiųsti naujausias, o taip pat ir senesnes ReactOS SVN laidas, sukurtas mūsų <a href="https://build.reactos.org">BuildBot\'o</a>.';

	$getbuilds_langres["imagetypes"] = "Image Types";
	$getbuilds_langres["browsebuilds"] = "Naršyti visas sukurtas laidas";
	$getbuilds_langres["browsegithub"] = "Naršyti GitHub saugyklą";

	//$getbuilds_langres["js_disclaimer"] = 'JavaScript turi būti įjungtas Jūsų naršyklėje, kad galėtumėte naudotis SVN bylų sarašu.<br>Kitu atveju, Jūs galite parsisiųsti SVN laidas <a href="%s">čia</a>.';
	$getbuilds_langres["prevrev"] = "Ankstesnė laida";
	$getbuilds_langres["nextrev"] = "Sekanti laida";

	$getbuilds_langres["foundfiles"] = "Rasta %s bylų!";
	$getbuilds_langres["filename"] = "Bylos vardas";
	$getbuilds_langres["size"] = "Dydis";
	$getbuilds_langres["date"] = "Data";

	$getbuilds_langres["nofiles"] = "Laidai %s bylų nerasta! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Neteisingas laidos numeris!";

	$getbuilds_langres["rangelimitexceeded"] = "Laidų skaičius negali viršyti %s!";

	$getbuilds_langres["legend"] = "Legend";
	$getbuilds_langres["build_bootcd"] = "Boot Media are designed to install ReactOS onto an HDD and enjoy the new features since the last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU). Alternatively, you can choose to give ReactOS a try without installing it, for example in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.";
	$getbuilds_langres["build_livecd"] = "Live CDs (deprecated) were the former way to test ReactOS without installing it. These have been replaced by the Boot Media since ReactOS 0.4.16 release.";
	$getbuilds_langres["build_dbg"] = "Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
	$getbuilds_langres["build_rel"] = "Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
?>
