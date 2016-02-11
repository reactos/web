<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Pierre Schweitzer <heis_spiter@hotmail.com>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["header"] = '<a href="http://www.reactos.org/">Accueil</a> &gt; Binaires du tronc de ReactOS';
	$getbuilds_langres["title"] = "Télécharger les binaires du tronc de ReactOS";
	$getbuilds_langres["intro"] = 'Ici vous pouvez télécharger les récentes binaires, mais aussi les plus anciennes version de ReactOS, qui ont été créées par notre <a href="http://www.reactos.org/wiki/index.php/RosBuild">BuildBot</a>.';
	
	$getbuilds_langres["overview"] = "Aperçu";
	$getbuilds_langres["latestrev"] = "Dernière révision de ReactOS sur le serveur SVN";
	$getbuilds_langres["browsesvn"] = "Parcourir le répertoire SVN en ligne";
	$getbuilds_langres["buildbot_status"] = "Statut du robot BuildBot";
	$getbuilds_langres["buildbot_web"] = "View details at the BuildBot Web Interface";
	$getbuilds_langres["browsebuilds"] = "Parcourir toutes les binaires créées";
	
	$getbuilds_langres["downloadrev"] = "Télécharger les binaires d'une révision de ReactOS";
	$getbuilds_langres["js_disclaimer"] = 'JavaScript a besoin d\'être activé dans votre navigateur pour utiliser la liste des fichiers de révision.<br>Autrement, vous pouvez télécharger tous les binaires des révisions <a href="%s">ici</a>.';
	$getbuilds_langres["showrevfiles"] = "Montrer les fichiers de la révision ";
	$getbuilds_langres["prevrev"] = "Révision précédente";
	$getbuilds_langres["nextrev"] = "Révision suivante";
	$getbuilds_langres["showrev"] = "Montrer";
	$getbuilds_langres["gettinglist"] = "Récupération de la liste des fichiers";
	$getbuilds_langres["isotype"] = "Montrer les types d'images de CD ";
	
	$getbuilds_langres["foundfiles"] = "%s fichiers trouvés !";
	
	$getbuilds_langres["filename"] = "Nom du fichier";
	$getbuilds_langres["filesize"] = "Taille";
	$getbuilds_langres["filedate"] = "Derniers changements";
	
	$getbuilds_langres["nofiles"] 	 = "Il n'y a pas de fichiers disponibles pour la révision %s ! Les derniers fichiers sont pour la révision  " . $rev;
	$getbuilds_langres["invalidrev"] = "Numéro de révision invalide !";
	
	$getbuilds_langres["rangelimitexceeded"] = "L'intervalle de révisions ne peut contenir qu'un maximum de %s révisions !";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<tt>bootcd</tt> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
    $getbuilds_langres["build_livecd"] = "<tt>livecd</tt> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
    $getbuilds_langres["build_rel"] = "<tt>-rel</tt> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
    $getbuilds_langres["build_dbg"] = "<tt>-dbg</tt> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
    $getbuilds_langres["build_dbgwin"] = "<tt>-dbgwin</tt> - The same as the -dbg version + includes wine Gecko and winetests. ";
	$getbuilds_langres["build_msvc"] = "<strong>-msvc</strong> - Debug version includes debugging information and PDB files, use this version to debug with Windbg.";
?>
