<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
  TRANSLATOR: Tomoya Kitagawa
  
  charset=utf-8 without BOM
*/

	$getbuilds_langres["header"] = '<a href="http://www.reactos.org/">ホーム</a> &gt; ReactOS SVN トランクビルド';
	$getbuilds_langres["title"] = "ReactOS SVN トランクビルドのダウンロード";
	$getbuilds_langres["intro"] = 'ここでは最近のものから古いものまで、<a href="http://www.reactos.org/wiki/index.php/RosBuild">ビルドボット</a>に作成されたReactOSの開発者向けバージョンをダウンロードできます。';
	
	$getbuilds_langres["overview"] = "概略";
	$getbuilds_langres["latestrev"] = "SVN サーバで最新のReactOS リビジョン";
	$getbuilds_langres["browsesvn"] = "SVN リポジトリ オンラインを見る";
	$getbuilds_langres["buildbot_status"] = "ビルドボットの状態";
	$getbuilds_langres["buildbot_web"] = "ビルドボット ウェブ インターフェイスで詳細を見る";
	$getbuilds_langres["browsebuilds"] = "作成されたビルドをすべて見る";
	
	$getbuilds_langres["downloadrev"] = "あらかじめビルドされたReactOS リビジョンのダウンロード";
	$getbuilds_langres["js_disclaimer"] = 'リビジョンファイルリストを使うにはJavaScriptをブラウザで有効にする必要があります。<br>もしくは、<a href="%s">ここ</a>ですべてのあらかじめビルドされたリビジョンをダウンロードできます。';
	$getbuilds_langres["showrevfiles"] = "ファイルを表示するリビジョン";
	$getbuilds_langres["prevrev"] = "前のリビジョン";
	$getbuilds_langres["nextrev"] = "次のリビジョン";
	$getbuilds_langres["showrev"] = "表示";
	$getbuilds_langres["gettinglist"] = "ファイルリストを取得中";
	$getbuilds_langres["rangeinfo"] = "リビジョン番号 (例 %s)かリビジョン範囲 (例 %s-%s)を入力することができます";
	$getbuilds_langres["isotype"] = "表示するCD イメージの種類";
	
	$getbuilds_langres["foundfiles"] = "%sつのファイルが見つかりました!";
	
	$getbuilds_langres["filename"] = "ファイル名";
	$getbuilds_langres["filesize"] = "サイズ";
	$getbuilds_langres["filedate"] = "変更日時";
	
	$getbuilds_langres["nofiles"] 	 = "リビジョン %sのあらかじめビルドされたファイルはありません! The latest available files are for revision " . $rev;
	$getbuilds_langres["invalidrev"] = "無効なリビジョン番号です!";
	
	$getbuilds_langres["rangelimitexceeded"] = "リビジョン範囲は最大で%sリビジョンのみ含めます!";
	
	$getbuilds_langres["legend"]= "Legend";
	$getbuilds_langres["build_bootcd"] = "<tt>bootcd</tt> - BootCD ISOs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).";
    $getbuilds_langres["build_livecd"] = "<tt>livecd</tt> - LiveCD ISOs allow to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during BootCD installation or if you have no alternative system/VM to install on.";
    $getbuilds_langres["build_rel"] = "<tt>-rel</tt> - Release version with no debugging information, this version is smaller, but it cannot be used to produce logs.";
    $getbuilds_langres["build_dbg"] = "<tt>-dbg</tt> - Debug version includes debugging information, use this version to test, produce logs and report bugs. This is the recommended variant to install to report bugs.";
    $getbuilds_langres["build_dbgwin"] = "<tt>-dbgwin</tt> - The same as the -dbg version + includes wine Gecko and winetests. ";
	$getbuilds_langres["build_msvc"] = "<strong>-msvc</strong> - Debug version includes debugging information and PDB files, use this version to debug with Windbg.";
?>
