<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Gabriel Ilardi <gabrielilardi@hotmail.it>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["header"] = '<a href="http://www.reactos.org/">Home</a> &gt; Builds del Trunk de ReactOS SVN';
	$getbuilds_langres["title"] = "Descargar las builds del trunk";
	$getbuilds_langres["intro"] = 'Aquí puedes descargar versiones recientes de desarrollo de ReactOS pero también viejas versiones, que han sido creadas por nuestro <a href="http://www.reactos.org/wiki/index.php/RosBuild">BuildBot</a>.';~
	
	$getbuilds_langres["overview"] = "Resumen";
	$getbuilds_langres["latestrev"] = "Ultima revisión de ReactOS en el server SVN";
	$getbuilds_langres["browsesvn"] = "Hojear el repositorio SVN online";
	$getbuilds_langres["buildbot_status"] = "Estado de BuildBot";
	$getbuilds_langres["buildbot_web"] = "Ver detalles de la interfaz web de BuildBot";
	$getbuilds_langres["browsebuilds"] = "Hojear todas las builds creadas";
	
	$getbuilds_langres["downloadrev"] = "Descargar una revisión precompilada de ReactOS";
	$getbuilds_langres["js_disclaimer"] = 'Tienes que tener JavaScript habilitado en tu browser para poder ver la lista de archivos de las revisiones.<br>Alternativamente, puedes descargar todas las versiones precompiladas desde <a href="%s">aquí</a>.';
	$getbuilds_langres["showrevfiles"] = "Mostrar los archivos de la revisión";
	$getbuilds_langres["prevrev"] = "Revisión anterior";
	$getbuilds_langres["nextrev"] = "Revisión siguiente";
	$getbuilds_langres["showrev"] = "Mostrar";
	$getbuilds_langres["gettinglist"] = "Obteniendo la lista de archivos";
	$getbuilds_langres["isotype"] = "Mostrar tipos de imagen de CD";
	
	$getbuilds_langres["foundfiles"] = "Encontrado(s) %s archivo(s)!";
	
	$getbuilds_langres["filename"] = "Nombre de archivo";
	$getbuilds_langres["filesize"] = "Tamaño";
	$getbuilds_langres["filedate"] = "Modificado";
	
	$getbuilds_langres["nofiles"] 	 = "No hay archivos precompilados para la revisión %s! Los últimos ficheros disponibles son de la revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Número de revisión inválido!";
	
	$getbuilds_langres["rangelimitexceeded"] = "El rango de revisiones puede contener un máximo de %s revisiones!";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<tt>bootcd</tt> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
    $getbuilds_langres["build_livecd"] = "<tt>livecd</tt> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
    $getbuilds_langres["build_rel"] = "<tt>-rel</tt> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
    $getbuilds_langres["build_dbg"] = "<tt>-dbg</tt> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
    $getbuilds_langres["build_dbgwin"] = "<tt>-dbgwin</tt> - The same as the -dbg version + includes wine Gecko and winetests. ";
	$getbuilds_langres["build_msvc"] = "<strong>-msvc</strong> - Debug version includes debugging information and PDB files, use this version to debug with Windbg.";
?>
