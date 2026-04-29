<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Gabriel Ilardi <gabrielilardi@hotmail.it>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "Scaricare le builds dal trunk";
	$getbuilds_langres["intro"] = 'Qui puoi scaricare versioni di sviluppo di ReactOS recenti ma anche vecchie, che sono state create da <a href="https://build.reactos.org">BuildBot</a>.';

	$getbuilds_langres["imagetypes"] = "Image Types";
	$getbuilds_langres["browsebuilds"] = "Sfogliare tutte le Builds create";
	$getbuilds_langres["browsegithub"] = "Sfogliare il repositorio GitHub";

	//$getbuilds_langres["js_disclaimer"] = 'Serve JavaScript abilitato nel tuo browser per usare la lista di file delle revisioni.<br>Alternativamente, puoi scaricare tutte le revisioni precompilate da <a href="%s">qui</a>.';
	$getbuilds_langres["prevrev"] = "Revisione precedente";
	$getbuilds_langres["nextrev"] = "Revisione successiva";

	$getbuilds_langres["foundfiles"] = "Trovato(i) %s file(s)!";
	$getbuilds_langres["filename"] = "Nome file";
	$getbuilds_langres["size"] = "Dimensioni";
	$getbuilds_langres["date"] = "Modificato";

	$getbuilds_langres["nofiles"] = "Non ci sono files precompilati per la revisione %s! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Numero di revisione invalido!";

	$getbuilds_langres["rangelimitexceeded"] = "Il range delle revisioni può comprendere un massimo di %s revisioni!";

	$getbuilds_langres["legend"] = "Legend";
	$getbuilds_langres["build_bootcd"] = "Boot Media are designed to install ReactOS onto an HDD and enjoy the new features since the last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU). Alternatively, you can choose to give ReactOS a try without installing it, for example in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.";
	$getbuilds_langres["build_livecd"] = "Live CDs (deprecated) were the former way to test ReactOS without installing it. These have been replaced by the Boot Media since ReactOS 0.4.16 release.";
	$getbuilds_langres["build_dbg"] = "Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
	$getbuilds_langres["build_rel"] = "Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
?>
