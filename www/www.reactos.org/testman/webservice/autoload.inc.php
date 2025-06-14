<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     PHP Class Autoloader
 * COPYRIGHT:   Copyright 2009-2025 Colin Finck (colin@reactos.org)
 */

	// All classes are autoloaded through this magic function
	function testman_autoloader($class)
	{
		require_once("lib/$class.class.php");
	}

	spl_autoload_register('testman_autoloader');
