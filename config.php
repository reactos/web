<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2005-2006  Klemens Friedl <frik85@reactos.org>
                  2009       Danny Götte <dangerground@web.de>

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

define('CDBT_ATTACHMENTS', 'cdb_attachments');
define('CDBT_CATEGORIES' , 'cdb_categories');
define('CDBT_COMMENTS'   , 'cdb_comments');
define('CDBT_ENTRIES'    , 'cdb_entries');
define('CDBT_REPORTS'    , 'cdb_entries_reports');
define('CDBT_LANGUAGES'  , 'cdb_languages');
define('CDBT_LOGS'       , 'cdb_logs');
define('CDBT_TAGGED'     , 'cdb_rel_entries_tags');
define('CDBT_TAGS'       , 'cdb_tags');
define('CDBT_VERTAGS'    , 'cdb_entries_tags');
define('CDBT_VERSIONS'   , 'cdb_entries_versions');




		// Config: (please sync this with the database)
		$RSDB_intern_version = "RSDB 0.1 - http://www.reactos.org/"; // RSDB version info
		$RSDB_intern_path_server = "/reactos/"; // complete server path
		$RSDB_intern_path = "compat/"; // the dirs after http://www.reactos.org
		
		// script file fix (for Safari browser)
		$RSDB_intern_index_php = $RSDB_intern_path_server.$RSDB_intern_path."index.php";
		
		// Global Login System
		$RSDB_intern_loginsystem_path = "roscms/"; // RosCMS dir
		$RSDB_intern_loginsystem_fullpath = $RSDB_intern_path_server.$RSDB_intern_loginsystem_path; // RosCMS dir
	
		// Items per Page
		$RSDB_intern_items_per_page = 25;

		// User ID
    require_once(ROSCMS_PATH.'lib/RosCMS_Autoloader.class.php');
		$RSDB_intern_user_id = Subsystem::in(Login::OPTIONAL, '/'.$RSDB_intern_path);
		
		if($RSDB_intern_user_id !== false) {
			
			// Name
			$RSDB_USER_name = Subsystem::getUserName($RSDB_intern_user_id);
			
			
			// RSDB user settings
			
				// Items per page
				$RSDB_USER_setting_itemsperpage = 30; //$result_roscms_user['user_setting_itemsperpage'];
				$RSDB_intern_items_per_page = $RSDB_USER_setting_itemsperpage;

		}
		else {
			$RSDB_USER_name = "Anonymous";
		}
?>