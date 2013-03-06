<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Gabriel Ilardi <gabrielilardi@hotmail.it>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["header"] = '<a href="http://www.reactos.org/">Home</a> &gt; Builds del Trunk di ReactOS SVN';
	$getbuilds_langres["title"] = "Scaricare le builds dal trunk";
	$getbuilds_langres["intro"] = 'Qui puoi scaricare versioni di sviluppo di ReactOS recenti ma anche vecchie, che sono state create da <a href="http://www.reactos.org/wiki/index.php/RosBuild">BuildBot</a>.';
	
	$getbuilds_langres["overview"] = "Descrizone";
	$getbuilds_langres["latestrev"] = "Ultima revisione di ReactOS sul server SVN";
	$getbuilds_langres["browsesvn"] = "Sfogliare il repositorio online SVN";
	$getbuilds_langres["buildbot_status"] = "Stato di BuildBot";
	$getbuilds_langres["buildbot_web"] = "Vedere i dettagli dall'interfaccia web di BuildBot";
	$getbuilds_langres["browsebuilds"] = "Sfogliare tutte le Builds create";
	
	$getbuilds_langres["downloadrev"] = "Scaricare una revisione precompilata di ReactOS";
	$getbuilds_langres["js_disclaimer"] = 'Serve JavaScript abilitato nel tuo browser per usare la lista di file delle revisioni.<br>Alternativamente, puoi scaricare tutte le revisioni precompilate da <a href="%s">qui</a>.';
	$getbuilds_langres["showrevfiles"] = "Mostrare i files della revisione";
	$getbuilds_langres["prevrev"] = "Revisione precedente";
	$getbuilds_langres["nextrev"] = "Revisione successiva";
	$getbuilds_langres["showrev"] = "Mostrare";
	$getbuilds_langres["gettinglist"] = "Ottentendo l'elenco dei file";
	$getbuilds_langres["isotype"] = "Mostrare imagini cd";
	
	$getbuilds_langres["foundfiles"] = "Trovato(i) %s file(s)!";
	
	$getbuilds_langres["filename"] = "Nome file";
	$getbuilds_langres["filesize"] = "Dimensioni";
	$getbuilds_langres["filedate"] = "Modificato";
	
	$getbuilds_langres["nofiles"] 	 = "Non ci sono files precompilati per la revisione %s! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Numero di revisione invalido!";
	
	$getbuilds_langres["rangelimitexceeded"] = "Il range delle revisioni può comprendere un massimo di %s revisioni!";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<tt>bootcd</tt> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
    $getbuilds_langres["build_livecd"] = "<tt>livecd</tt> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
    $getbuilds_langres["build_rel"] = "<tt>-rel</tt> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
    $getbuilds_langres["build_dbg"] = "<tt>-dbg</tt> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
    $getbuilds_langres["build_dbgwin"] = "<tt>-dbgwin</tt> - The same as the -dbg version + includes wine Gecko and winetests. ";
?>
