<?php
    /*
    ReactOS Paste Service
    Copyright (C) 2006  Klemens Friedl <frik85@reactos.org>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
    */

	define("ROOT_PATH", "../");
	define("ROSCMS_PATH", ROOT_PATH.'roscms/');

	require_once(ROSCMS_PATH . "lib/RosCMS_Autoloader.class.php");
	$RSDB_intern_user_id = Subsystem::in(Login::OPTIONAL, "/" . "http://localhost/reactos.org/");

	include("connect.db.php");
	
	if($RSDB_intern_user_id != 0) {
		// Name
		$RSDB_USER_name = Subsystem::getUserName($RSDB_intern_user_id);
		
	}
	else {
		$RSDB_USER_name = "Anonymous";
	}

?>
