<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Vytis Girdzijauskas <cman@cman.us>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["header"] = '<a href="http://www.reactos.org/">Pagrindinis</a> &gt; ReactOS SVN laidos';
	$getbuilds_langres["title"] = "Parsisiųsti ReactOS SVN laidas";
	$getbuilds_langres["intro"] = 'Čia Jūs galite parsisiųsti naujausias, o taip pat ir senesnes ReactOS SVN laidas, sukurtas mūsų <a href="http://www.reactos.org/wiki/index.php/RosBuild">BuildBot\'o</a>.';
	
	$getbuilds_langres["overview"] = "Apibendrinimas";
	$getbuilds_langres["latestrev"] = "Naujausia ReactOS SVN laida";
	$getbuilds_langres["browsesvn"] = "Naršyti SVN saugyklą";
	$getbuilds_langres["buildbot_status"] = "BuildBot'o būklė";
	$getbuilds_langres["buildbot_web"] = "BuildBot'o Web sąsaja";
	$getbuilds_langres["browsebuilds"] = "Naršyti visas sukurtas laidas";
	
	$getbuilds_langres["downloadrev"] = "Parsisiųsti ReactOS SVN laidas";
	$getbuilds_langres["js_disclaimer"] = 'JavaScript turi būti įjungtas Jūsų naršyklėje, kad galėtumėte naudotis SVN bylų sarašu.<br>Kitu atveju, Jūs galite parsisiųsti SVN laidas <a href="%s">čia</a>.';
	$getbuilds_langres["showrevfiles"] = "Rodyti bylas laidai";
	$getbuilds_langres["prevrev"] = "Ankstesnė laida";
	$getbuilds_langres["nextrev"] = "Sekanti laida";
	$getbuilds_langres["showrev"] = "Rodyti";
	$getbuilds_langres["gettinglist"] = "Ieškoma bylų";
	$getbuilds_langres["isotype"] = "Rodyti CD atvaizdų tipus";
	
	$getbuilds_langres["foundfiles"] = "Rasta %s bylų!";
	
	$getbuilds_langres["filename"] = "Bylos vardas";
	$getbuilds_langres["filesize"] = "Dydis";
	$getbuilds_langres["filedate"] = "Data";
	
	$getbuilds_langres["nofiles"] 	 = "Laidai %s bylų nerasta! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Neteisingas laidos numeris!";
	
	$getbuilds_langres["rangelimitexceeded"] = "Laidų skaičius negali viršyti %s!";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<tt>bootcd</tt> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
    $getbuilds_langres["build_livecd"] = "<tt>livecd</tt> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
    $getbuilds_langres["build_rel"] = "<tt>-rel</tt> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
    $getbuilds_langres["build_dbg"] = "<tt>-dbg</tt> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
    $getbuilds_langres["build_dbgwin"] = "<tt>-dbgwin</tt> - The same as the -dbg version + includes wine Gecko and winetests. ";
?>
