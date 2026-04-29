<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Tomoya Kitagawa
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["title"] = "ReactOS SVN トランクビルドのダウンロード";
	$getbuilds_langres["intro"] = 'ここでは最近のものから古いものまで、<a href="https://build.reactos.org">ビルドボット</a>に作成されたReactOSの開発者向けバージョンをダウンロードできます。';

	$getbuilds_langres["imagetypes"] = "Image Types";
	$getbuilds_langres["browsebuilds"] = "作成されたビルドをすべて見る";
	$getbuilds_langres["browsegithub"] = "GitHub リポジトリ オンラインを見る";

	//$getbuilds_langres["js_disclaimer"] = 'リビジョンファイルリストを使うにはJavaScriptをブラウザで有効にする必要があります。<br>もしくは、<a href="%s">ここ</a>ですべてのあらかじめビルドされたリビジョンをダウンロードできます。';
	$getbuilds_langres["prevrev"] = "前のリビジョン";
	$getbuilds_langres["nextrev"] = "次のリビジョン";

	$getbuilds_langres["foundfiles"] = "%sつのファイルが見つかりました!";
	$getbuilds_langres["filename"] = "ファイル名";
	$getbuilds_langres["size"] = "サイズ";
	$getbuilds_langres["date"] = "変更日時";

	$getbuilds_langres["nofiles"] = "リビジョン %sのあらかじめビルドされたファイルはありません! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "無効なリビジョン番号です!";

	$getbuilds_langres["rangelimitexceeded"] = "リビジョン範囲は最大で%sリビジョンのみ含めます!";

	$getbuilds_langres["legend"] = "Legend";
	$getbuilds_langres["build_bootcd"] = "Boot Media are designed to install ReactOS onto an HDD and enjoy the new features since the last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU). Alternatively, you can choose to give ReactOS a try without installing it, for example in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.";
	$getbuilds_langres["build_livecd"] = "Live CDs (deprecated) were the former way to test ReactOS without installing it. These have been replaced by the Boot Media since ReactOS 0.4.16 release.";
	$getbuilds_langres["build_dbg"] = "Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
	$getbuilds_langres["build_rel"] = "Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
?>
