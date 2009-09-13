<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2005-2006  Klemens Friedl <frik85@reactos.org>

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

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

if (get_magic_quotes_gpc()) {
	die("ERROR: Disable 'magic quotes' in php.ini (=Off)");
}

define('ROSCMS_PATH', '../roscms/');
define('CDB_PATH', '');
require_once("lib/Compat_Autoloader.class.php");
require_once('config.php');
$RSDB_intern_link_db_sec = 'index.php?show=';

switch (@$_GET['show']) {

  default:
    // AJAX requests
    if (isset($_GET['get']) && $_SERVER['QUERY_STRING'] != '') {
      switch (@$_GET['get']) {

        // Suggestions
        case 'suggestions':
          new List_Suggestions();
          break;

        // Filter
        case 'filter':
          new List_Filter(@$_GET['part']);
          break;

        // Query listing
        case 'querylist':
          new List_Query(@$_GET['query']);
          break;

      } // end switch get
      break;
    }

  case 'home': 
    new HTML_Home();
    break;

  // preferences
  case 'preferences': 
    new HTML_Preferences();
    break;

  // Administration
  case 'administration': 
    new HTML_Administration();
    break;

  // RSDB About Page
  case 'about': 
    new HTML_About();
    break;

  // RSDB Submit Conditions Page
  case 'conditions': 
    new HTML_Conditions();
    break;

  // Browse by name
  case 'list': 
    $filter = '';
    if (isset($_GET['letter']) && $_GET['letter'] != '*') {
      $filter .= 'n_s_'.$_GET['letter'].'|a_is_rosversion|o_asc_name';
    }
    elseif (isset($_GET['letter']) && $_GET['letter'] == '*') {
      $filter .= 'a_is_category|a_is_rosversion|o_asc_name';
    }
    if (isset($_GET['cat'])) {
      if ($filter !== '') $filter .= '|';
      $filter .= 'c_is_'.$_GET['cat'].'|a_is_rosversion|o_asc_name';
    }
    if (isset($_GET['tag']) && $_GET['tag'] != '*') {
      if ($filter !== '') $filter .= '|';
      $filter .= 't_is_'.$_GET['tag'].'|a_is_rosversion|o_asc_name';
    }
    if (isset($_GET['filter']) && $_GET['filter'] == 'custom') {
      $filter = HTML_List::formToFilter();
    }
    elseif (isset($_GET['filter']) && $_GET['filter'] != '') {
      $filter = $_GET['filter'];
    }
    if (isset($_GET['by']) && $_GET['by'] != '') {
      $filter .= 'n_h_'.str_replace(Listing::DEVIDE_FILTER, '%', $_GET['by']);
    }
    
    new HTML_List($filter);
    break;

  // show specific version
  case 'version':
    new HTML_Version();
    break;

  // show entry overview
  case 'entry':
    new HTML_Entry();
    break;
  

  // Submit
  case 'submit': 
    new HTML_Submit();
    break;

  // Help
  case 'help':
    new HTML_Help();
    break;

} // end switch page

?>
