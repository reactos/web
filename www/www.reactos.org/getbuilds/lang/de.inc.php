<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Colin Finck <mail@colinfinck.de>
			  zehnvor 2013
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "ReactOS Trunk-Builds herunterladen";
	$getbuilds_langres["intro"] = 'Hier können Sie aktuelle aber auch ältere ReactOS-Entwicklerversionen herunterladen, die von unserem <a href="https://build.reactos.org">BuildBot</a> erstellt wurden.';

	$getbuilds_langres["imagetypes"] = "Image Types";
	$getbuilds_langres["browsebuilds"] = "Alle erstellten Builds durchsuchen";
	$getbuilds_langres["browsegithub"] = "GitHub-Server durchsuchen";

	//$getbuilds_langres["js_disclaimer"] = 'Sie müssen JavaScript in Ihrem Browser aktivieren, um die Revisions-Dateiliste zu benutzen.<br>Alternativ können Sie alle vorkompilierten Versionen <a href="%s">hier</a> herunterladen.';
	$getbuilds_langres["prevrev"] = "Vorherige Revision";
	$getbuilds_langres["nextrev"] = "Nächste Revision";

	$getbuilds_langres["foundfiles"] = "%s Dateien gefunden!";
	$getbuilds_langres["filename"] = "Dateiname";
	$getbuilds_langres["size"] = "Größe";
	$getbuilds_langres["date"] = "Zuletzt geändert";

	$getbuilds_langres["nofiles"] = "Für Revision %s gibt es keine vorkompilierten Dateien! Die letzte verfügbare Revision ist " . $rev;
	$getbuilds_langres["invalidrev"] = "Ungültige Revisionsnummer!";

	$getbuilds_langres["rangelimitexceeded"] = "Der Revisionsbereich darf maximal %s Revisionen umfassen!";

	$getbuilds_langres["legend"]= "Legende";
	$getbuilds_langres["build_bootcd"] = "Boot Media are designed to install ReactOS onto an HDD and enjoy the new features since the last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU). Alternatively, you can choose to give ReactOS a try without installing it, for example in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.";
	$getbuilds_langres["build_livecd"] = "Live CDs (deprecated) were the former way to test ReactOS without installing it. These have been replaced by the Boot Media since ReactOS 0.4.16 release.";
	$getbuilds_langres["build_dbg"] = "Debugging Version. Diese Versionen können benutzt werden, um Debugmeldungen auszulesen. Dies kann hilfreich sein, wenn Sie einen Fehler melden möchten.";
	$getbuilds_langres["build_rel"] = "Release Version, ohne Debugging-Funktionen. (Hinweis: Hier finden Sie nur Vorabversionen, Hauptversionen gibt es auf der Download-Seite!)";
?>
