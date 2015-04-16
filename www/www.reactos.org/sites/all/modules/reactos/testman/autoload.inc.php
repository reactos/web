<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Autoload of all classes
  COPYRIGHT:  Copyright 2008-2011 Colin Finck <colin@reactos.org>
*/

	// All classes are autoloaded through this magic function
	function __autoload($class)
	{
		require_once("lib/$class.class.php");
	}
?>