<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     PHP Class Autoloader
 * COPYRIGHT:   Copyright 2009-2017 Colin Finck (colin@reactos.org)
 */

	// All classes are autoloaded through this magic function
	function __autoload($class)
	{
		require_once("lib/$class.class.php");
	}
