<?php
/*
  PROJECT:    People Map of the ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Configuration settings
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
*/

	define("ROOT_PATH", "../");
	define("SHARED_PATH", ROOT_PATH . "shared/");
	
	require_once("../../www.reactos.org_config/peoplemap-connect.php");
	
	// Image Settings
	$MARKERS = array("red", "blue", "green", "violet", "yellow", "cyan", "lightgrey");
?>
