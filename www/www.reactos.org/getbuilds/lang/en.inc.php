<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Colin Finck <mail@colinfinck.de>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "Download ReactOS Trunk Builds";
	$getbuilds_langres["intro"] = 'ReactOS Trunk Builds are automatically built by our <a href="https://build.reactos.org">BuildBot</a> each time a change is committed to the ReactOS Repository. This way, Trunk Builds incorporate latest fixes, however they are not as thoroughly tested as the Release ones. You may find regressions and bugs.';

	$getbuilds_langres["overview"] = "Overview";
	$getbuilds_langres["latestrev"] = "Latest ReactOS Revision on the SVN Server";
	$getbuilds_langres["browsesvn"] = "Browse SVN Repository online";
	$getbuilds_langres["browsebuilds"] = "Browse all created Builds";
	
	$getbuilds_langres["downloadrev"] = "Download a prebuilt ReactOS Revision";
	$getbuilds_langres["showrevfiles"] = "Show files of revision";
	$getbuilds_langres["prevrev"] = "Previous revision";
	$getbuilds_langres["nextrev"] = "Next revision";
	$getbuilds_langres["showrev"] = "Show";
	$getbuilds_langres["gettinglist"] = "Getting file list";
	$getbuilds_langres["rangeinfo"] = "You can enter a revision number (e.g. %s) or a revision range (e.g. %s-%s)";
	$getbuilds_langres["isotype"] = "Show CD Image types";
	
	$getbuilds_langres["foundfiles"] = "Found %s files!";
	
	$getbuilds_langres["filename"] = "File name";
	$getbuilds_langres["filesize"] = "Size";
	$getbuilds_langres["filedate"] = "Last changed";
	
	$getbuilds_langres["nofiles"] 	 = "There are no prebuilt files for revision %s! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Invalid revision number!";
	
	$getbuilds_langres["rangelimitexceeded"] = "The revision range can only comprise a maximum of %s revisions!";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<strong>bootcd</strong> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
	$getbuilds_langres["build_livecd"] = "<strong>livecd</strong> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
	$getbuilds_langres["build_dbg"] = "<strong>-dbg</strong> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
	$getbuilds_langres["build_rel"] = "<strong>-rel</strong> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
	$getbuilds_langres["build_msvc"] = "<strong>-msvc</strong> - Debug version includes debugging information and PDB files, use this version to debug with Windbg.";
?>
