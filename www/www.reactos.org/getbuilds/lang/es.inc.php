<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Gabriel Ilardi <gabrielilardi@hotmail.it>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "Descargar las builds del trunk";
	$getbuilds_langres["intro"] = 'Aquí puedes descargar versiones recientes de desarrollo de ReactOS pero también viejas versiones, que han sido creadas por nuestro <a href="https://build.reactos.org">BuildBot</a>.';

	$getbuilds_langres["imagetypes"] = "Image Types";
	$getbuilds_langres["browsebuilds"] = "Hojear todas las builds creadas";
	$getbuilds_langres["browsegithub"] = "Hojear el repositorio GitHub";

	//$getbuilds_langres["js_disclaimer"] = 'Tienes que tener JavaScript habilitado en tu browser para poder ver la lista de archivos de las revisiones.<br>Alternativamente, puedes descargar todas las versiones precompiladas desde <a href="%s">aquí</a>.';
	$getbuilds_langres["prevrev"] = "Revisión anterior";
	$getbuilds_langres["nextrev"] = "Revisión siguiente";

	$getbuilds_langres["foundfiles"] = "Encontrado(s) %s archivo(s)!";
	$getbuilds_langres["filename"] = "Nombre de archivo";
	$getbuilds_langres["size"] = "Tamaño";
	$getbuilds_langres["date"] = "Modificado";

	$getbuilds_langres["nofiles"] = "No hay archivos precompilados para la revisión %s! Los últimos ficheros disponibles son de la revision " . $rev;
	$getbuilds_langres["invalidrev"] = "Número de revisión inválido!";

	$getbuilds_langres["rangelimitexceeded"] = "El rango de revisiones puede contener un máximo de %s revisiones!";

	$getbuilds_langres["legend"] = "Legend";
	$getbuilds_langres["build_bootcd"] = "Boot Media are designed to install ReactOS onto an HDD and enjoy the new features since the last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU). Alternatively, you can choose to give ReactOS a try without installing it, for example in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.";
	$getbuilds_langres["build_livecd"] = "Live CDs (deprecated) were the former way to test ReactOS without installing it. These have been replaced by the Boot Media since ReactOS 0.4.16 release.";
	$getbuilds_langres["build_dbg"] = "Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
	$getbuilds_langres["build_rel"] = "Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
?>
