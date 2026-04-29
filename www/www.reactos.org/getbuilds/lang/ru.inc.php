<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Shashkov Maxim <bz00mmer@mail.ru>, Aleksey Bragin <aleksey@reactos.org>, Stas'M <binarymaster@mail.ru>
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "Скачать свежие сборки ReactOS";
	$getbuilds_langres["intro"] = 'Здесь Вы можете скачать как свежие, так и старые версии ReactOS для разработчиков, которые создаются нашим <a href="https://build.reactos.org">BuildBot</a> при каждом новом коммите в <a href="https://github.com/reactos/reactos">репозиторий ReactOS</a>. Свежие сборки содержат последние изменения и исправления, однако тестируются менее тщательно, чем официальные релизы. Возможно вы найдёте в них регрессии и баги.';

	$getbuilds_langres["imagetypes"] = "Типы образов";
	$getbuilds_langres["browsebuilds"] = "Обзор всех созданных сборок";
	$getbuilds_langres["browsegithub"] = "Обзор репозитория на GitHub";

	$getbuilds_langres["legend"] = "Обозначения";
	$getbuilds_langres["build_bootcd"] = "Boot Media are designed to install ReactOS onto an HDD and enjoy the new features since the last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU). Alternatively, you can choose to give ReactOS a try without installing it, for example in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.";
	$getbuilds_langres["build_livecd"] = "Live CDs (deprecated) were the former way to test ReactOS without installing it. These have been replaced by the Boot Media since ReactOS 0.4.16 release.";
	$getbuilds_langres["build_dbg"] = "Debug-версия включает отладочную информацию, и используя эту версию можно тестировать ReactOS, получать дебаг-логи, создавать описания найденных ошибок. Это рекомендуемый вариант для установки, особенно для тех, кто хочет сообщить о найденных проблемах с системой.";
	$getbuilds_langres["build_rel"] = "Release-версия без отладочной информации. Она меньше по размеру, но с её помощью нельзя получать отладочную информацию. (Спасибо, Кэп!)";
?>
