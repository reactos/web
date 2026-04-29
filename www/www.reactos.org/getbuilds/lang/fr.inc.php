<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Pierre Schweitzer <heis_spiter@hotmail.com>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "Télécharger les binaires du tronc de ReactOS";
	$getbuilds_langres["intro"] = 'Ici vous pouvez télécharger les binaires récents, mais aussi les plus anciennes version de ReactOS, qui ont été créées par notre <a href="https://build.reactos.org">BuildBot</a>.';

	$getbuilds_langres["imagetypes"] = "Types d'images";
	$getbuilds_langres["browsebuilds"] = "Parcourir tous les binaires créés";
	$getbuilds_langres["browsegithub"] = "Parcourir le répertoire GitHub";

	//$getbuilds_langres["js_disclaimer"] = 'JavaScript a besoin d\'être activé dans votre navigateur pour utiliser la liste des fichiers de révision.<br>Autrement, vous pouvez télécharger tous les binaires des révisions <a href="%s">ici</a>.';
	$getbuilds_langres["prevrev"] = "Révision précédente";
	$getbuilds_langres["nextrev"] = "Révision suivante";

	$getbuilds_langres["foundfiles"] = "%s fichiers trouvés !";
	$getbuilds_langres["filename"] = "Nom du fichier";
	$getbuilds_langres["size"] = "Taille";
	$getbuilds_langres["date"] = "Derniers changements";

	$getbuilds_langres["nofiles"] = "Il n'y a pas de fichiers disponibles pour la révision %s ! Les derniers fichiers sont pour la révision  " . $rev;
	$getbuilds_langres["invalidrev"] = "Numéro de révision invalide !";

	$getbuilds_langres["rangelimitexceeded"] = "L'intervalle de révisions ne peut contenir qu'un maximum de %s révisions !";

	$getbuilds_langres["legend"] = "Légende";
	$getbuilds_langres["build_bootcd"] = "Les Boot Media sont conçus pour installer ReactOS sur un disque dur et vous permettre de profiter des ses toutes dernières fonctionnalités depuis la dernière version. Vous n'aurez besoin du fichier ISO seulement pour son installation. Ceci est la méthode recommandée pour une installation sur machine virtuelle (VirtualBox, VMWare, QEMU). Ou bien, vous pouvez choisir d'essayer ReactOS sans l'installer, par exemple si votre disque dur n'est pas détecté durant l'installation, ou, si vous n'avez aucun système/machine virtuelle sur lequel l'installer.";
	$getbuilds_langres["build_livecd"] = "Les Live CDs (obsolètes) étaient l'ancien moyen de tester ReactOS sans installation. Ils ont été remplacés par les Boot Media depuis la version ReactOS 0.4.16.";
	$getbuilds_langres["build_dbg"] = "Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
	$getbuilds_langres["build_rel"] = "Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
?>
