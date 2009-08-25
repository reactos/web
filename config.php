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

define('CDBTDATABASE', 'compat.');
define('CDBT_ATTACHMENTS', CDBTDATABASE.'cdb_attachments');
define('CDBT_BUGS'       , CDBTDATABASE.'cdb_rel_entries_bugs');
define('CDBT_CATEGORIES' , CDBTDATABASE.'cdb_categories');
define('CDBT_COMMENTS'   , CDBTDATABASE.'cdb_comments');
define('CDBT_ENTRIES'    , CDBTDATABASE.'cdb_entries'); // applications/...
define('CDBT_REPORTS'    , CDBTDATABASE.'cdb_reports'); // test reports
define('CDBT_LANGUAGES'  , CDBTDATABASE.'cdb_languages');
define('CDBT_LOGS'       , CDBTDATABASE.'cdb_logs');
define('CDBT_TAGGED'     , CDBTDATABASE.'cdb_rel_entries_tags'); // assignings for tags - entries
define('CDBT_TAGS'       , CDBTDATABASE.'cdb_tags'); // tags for entries
define('CDBT_VERTAGS'    , CDBTDATABASE.'cdb_os'); // ReactOS version tags
define('CDBT_VERSIONS'   , CDBTDATABASE.'cdb_versions'); // application versions


		// Config: (please sync this with the database)
		$RSDB_intern_path = "compat/"; // the dirs after http://www.reactos.org
		
		// script file fix (for Safari browser)
    $RSDB_intern_path_server = "/reactos/".$RSDB_intern_path;
		$RSDB_intern_index_php = $RSDB_intern_path_server."index.php";
		
		// Global Login System
		$RSDB_intern_loginsystem_path = "roscms/"; // RosCMS dir
		$RSDB_intern_loginsystem_fullpath = "/reactos/".$RSDB_intern_loginsystem_path; // RosCMS dir
	
		// User ID
    require_once(ROSCMS_PATH.'lib/RosCMS_Autoloader.class.php');
		$RSDB_intern_user_id = Subsystem::in(Login::OPTIONAL, '/'.$RSDB_intern_path);

$CDB_upload_path_fs = 'J:\\Web\\reactos\\compat\\media\\files\\picture\\';
$CDB_upload_path_web = $RSDB_intern_path_server.'media/files/picture/';
?>