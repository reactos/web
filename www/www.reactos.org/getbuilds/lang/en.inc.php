<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Easily download prebuilt ReactOS Revisions
 * COPYRIGHT:   Copyright 2007-2017 Colin Finck (colin@reactos.org)
 * TRANSLATOR:  Colin Finck (colin@reactos.org)
 *
 * charset=utf-8 without BOM
 */

	$getbuilds_langres = array(
		"title" => "Download ReactOS Builds",
		"intro" => 'ReactOS Builds are automatically built by our <a href="https://build.reactos.org">BuildBot</a> each time a change is committed to the <a href="https://github.com/reactos/reactos">ReactOS Repository</a>. This way, they incorporate latest fixes. However, they are not as thoroughly tested as the release builds. You may find regressions and bugs.',

		"imagetypes" => "Image Types",
		"browsebuilds" => "Browse all created Builds",
		"browsegithub" => "Browse GitHub Repository",

		"legend" => "Legend",
		"build_bootcd" => "Boot CDs are designed to install ReactOS onto an HDD and enjoy the new features since last release. You will need the ISO only for the installation. This is the recommended variant to install into a VM (VirtualBox, VMWare, QEMU).",
		"build_livecd" => "Live CDs allow you to use ReactOS without installing it. It can be used to test ReactOS in case your HDD is not detected during installation, or if you have no alternative system/VMs to install it on.",
		"build_dbg" => "Debug versions include debugging information, use these versions to test, produce logs and report bugs. This is the recommended variant to install to report bugs.",
		"build_rel" => "Release versions include no debugging information. These versions are smaller, but cannot be used to produce logs.",
	);
