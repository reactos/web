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
	$getbuilds_langres["intro"] = 'Здесь Вы можете скачать как свежие, так и старые версии ReactOS для разработчиков, которые создаются нашим <a href="http://www.reactos.org/wiki/index.php/RosBuild">BuildBot</a> при каждом новом коммите в <a href="https://github.com/reactos/reactos">репозиторий ReactOS</a>. Свежие сборки содержат последние изменения и исправления, однако тестируются менее тщательно, чем официальные релизы. Возможно вы найдёте в них регрессии и баги.';
	
	$getbuilds_langres["imagetypes"] = "Типы образов";
	$getbuilds_langres["browsebuilds"] = "Обзор всех созданных сборок";
	$getbuilds_langres["browsegithub"] = "Обзор репозитория на GitHub";
	
	$getbuilds_langres["legend"]= "Обозначения";
	$getbuilds_langres["build_bootcd"] = "Образы BootCD ISO предназначены для установки новейших версий ReactOS на жёсткий диск. ISO-образ нужен только для процесса установки. Установка с помощью этого типа образа является рекомендуемой для тестирования ReactOS в виртуальной машине (VirtualBox, VMWare, QEMU).";
	$getbuilds_langres["build_livecd"] = "Образы LiveCD ISO позволяет использовать ReactOS без необходимости его установки. Также можно использовать LiveCD, если Ваш жёсткий диск не определяется во время установки с помощью BootCD или у Вас нет свободного ПК или виртуальной машины для установки ReactOS.";
	$getbuilds_langres["build_rel"] = "Release-версия без отладочной информации. Она меньше по размеру, но с её помощью нельзя получать отладочную информацию. (Спасибо, Кэп!)";
	$getbuilds_langres["build_dbg"] = "Debug-версия включает отладочную информацию, и используя эту версию можно тестировать ReactOS, получать дебаг-логи, создавать описания найденных ошибок. Это рекомендуемый вариант для установки, особенно для тех, кто хочет сообщить о найденных проблемах с системой.";
?>