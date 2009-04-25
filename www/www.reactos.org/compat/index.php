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

define('CDB_PATH', '');
require_once("lib/Compat_Autoloader.class.php");
require_once('config.php');



	if ( !defined('RSDB') ) {
		define ("RSDB", "rossupportdb"); // to prevent hacking activity
	}
  define('ROSCMS_PATH', '../roscms/');
	
	
	
	
	// Environment Vars:
		$RSDB_intern_selected="";
	
		
		// Forum bar settings:
		if (isset($_POST['forumsave']) && $_POST['forumsave'] == 1) {
			Cookie::write('rsdb_threshold', (isset($_POST['threshold']) ? htmlspecialchars($_POST['threshold']) : '?'), time() + 24 * 3600 * 30 * 5, '/');
			Cookie::write('rsdb_fstyle', (isset($_POST['fstyle']) ? htmlspecialchars($_POST['fstyle']) : '?'), time() + 24 * 3600 * 30 * 5, '/');
			Cookie::write('rsdb_order', (isset($_POST['order']) ? htmlspecialchars($_POST['order']) : '?'), time() + 24 * 3600 * 30 * 5, '/');
		}
	
		// Test report bar settings:
		if (isset($_POST['testsave']) && $_POST['testsave'] == 1) {
			Cookie::write('rsdb_threshold', (isset($_POST['threshold']) ? htmlspecialchars($_POST['threshold']) : '?'), time() + 24 * 3600 * 30 * 5, '/');
			Cookie::write('rsdb_order', (isset($_POST['order']) ? htmlspecialchars($_POST['order']) : '?'), time() + 24 * 3600 * 30 * 5, '/');
		}



	// Global Vars:
	$RSDB_SET_letter=""; // Browse by Name: Letter: All, A, B, C, ..., X, Y, Z
	$RSDB_SET_group=""; // Group ID
	
	
	$RSDB_SET_threshold="3";
	$RSDB_SET_fstyle="nested";
	$RSDB_SET_order="new";
	$RSDB_SET_save="";
	$RSDB_SET_msg="";
	$RSDB_SET_filter="cur";
	$RSDB_SET_filter2="";
	
	$rpm_lang="";



	if (isset($_COOKIE['rsdb_threshold'])) {
		$RSDB_SET_threshold = $_COOKIE['rsdb_threshold'];
	}
	if (isset($_COOKIE['rsdb_fstyle'])) {
		$RSDB_SET_fstyle = $_COOKIE['rsdb_fstyle'];
	}
	if (isset($_COOKIE['rsdb_order'])) {
		$RSDB_SET_order = $_COOKIE['rsdb_order'];
	}

	if (array_key_exists("letter", $_GET)) $RSDB_SET_letter=htmlspecialchars($_GET["letter"]);
	if (array_key_exists("group", $_GET)) $RSDB_SET_group=htmlspecialchars($_GET["group"]);
	
	if (array_key_exists("threshold", $_GET)) $RSDB_SET_threshold=htmlspecialchars($_GET["threshold"]);
	if (array_key_exists("fstyle", $_GET)) $RSDB_SET_fstyle=htmlspecialchars($_GET["fstyle"]);
	if (array_key_exists("order", $_GET)) $RSDB_SET_order=htmlspecialchars($_GET["order"]);
	if (array_key_exists("save", $_GET)) $RSDB_SET_save=htmlspecialchars($_GET["save"]);
	if (array_key_exists("msg", $_GET)) $RSDB_SET_msg=htmlspecialchars($_GET["msg"]);
	if (array_key_exists("filter", $_GET)) $RSDB_SET_filter=htmlspecialchars($_GET["filter"]);
	if (array_key_exists("filter2", $_GET)) $RSDB_SET_filter2=htmlspecialchars($_GET["filter2"]);
	
	if (array_key_exists("threshold", $_POST)) $RSDB_SET_threshold=htmlspecialchars($_POST["threshold"]);
	if (array_key_exists("fstyle", $_POST)) $RSDB_SET_fstyle=htmlspecialchars($_POST["fstyle"]);
	if (array_key_exists("order", $_POST)) $RSDB_SET_order=htmlspecialchars($_POST["order"]);
	if (array_key_exists("save", $_POST)) $RSDB_SET_save=htmlspecialchars($_POST["save"]);
	if (array_key_exists("msg", $_POST)) $RSDB_SET_msg=htmlspecialchars($_POST["msg"]);
	if (array_key_exists("filter", $_POST)) $RSDB_SET_filter=htmlspecialchars($_POST["filter"]);
	if (array_key_exists("filter2", $_POST)) $RSDB_SET_filter2=htmlspecialchars($_POST["filter2"]);


	session_start();
	
	if(isset($_COOKIE['roscms_usrset_lang'])) {
		$roscms_usrsetting_lang=$_COOKIE["roscms_usrset_lang"];
	}
	else {
		$roscms_usrsetting_lang="";
	}

	require_once('lang.php');


	// Config
	require_once('rsdb_setting.php');
	
	// URI building
	require_once('rsdb_config.php');

	// Tools
	require_once("notools/forum_bar.php");
	require_once("notools/osversion.php");
	require_once("notools/plugins.php");

switch (@$_GET['page']) {

  // Frontpage
  case 'home': 
    new Home();
    break;

  // RSDB About Page
  case 'about': 
    new About();
    break;

  // RSDB Submit Conditions Page
  case 'conditions': 
    new Conditions();
    break;

  // Browse by category
  case 'category':
    new HTML_Category();
    break;

  // Browse by name
  case 'name': 
    new HTML_Name();
    break;

  // browse by Vendor/Company
  case 'vendor': 
    new HTML_Vendor();
    break;

  // Vendor information
  case 'vendor_info': 
    new HTML_VendorInfo();
    break;

  // Rank
  case 'rank': 
    new Rank();
    break;

  // Rank
  case 'group': 
    new HTML_Group();
    break;

  // show specific version
  case 'item':
    switch (@$_GET['addbox']) {
      case 'add':
      case 'submit':
        switch (@$_GET['item2']) {

          // Screenshots
          case 'screens':
            new Submit_Screenshot();
            break;

          // Test Reports
          case 'tests':
            new Submit_Test();
            break;
        } // end switch item2
        break;

      // no addbox crap
      case '':
      default:
        switch (@$_GET['item2']) {

        // Details
        case 'details':
          default:
            new Item_Details();
            break;

          // Screenshots
          case 'screens':
            new Item_Screenshots();
            break;

          // Test Reports
          case 'tests':
            new Item_Tests();
            break;

          // Comments
          case 'forum':
            new Item_Comments();
            break;

          // Known Bugs
          case 'bugs':
            new Item_Bugs();
            break;

          // Tips & Tricks
          case 'tips':
            new Item_Tips();
            break;
        } // end switch item2
        break;
    } // end switch addbox
    break;

  // Search
  case 'search':
    new HTML_Search();
    break;

  // Submit
  case 'submit': 
    new HTML_Submit();
    break;

  // Help
  case 'help':
    new Help();
    break;

  default:
    // just show 404, if no request for 'get=' is given
    if (!isset($_GET['get'])) {
      echo '404';
    }
    break;

  // export data
  case 'dat': 
    switch (@$_GET['export']) {

      // Compatibility versions list for one item
      case 'grpitemlst': 
        new List_Item();
        break;

      // AppGroup - Search results
      case 'grplst': 
        new List_Group();
        break;

      // Vendor - Search results
      case 'vdrlst': 
        new List_Vendor();
        break;

      // Search results for the compatibility item submit page
      case 'compitemsubmit': 
        new List_AppSubmit();
        break;
    } // end switch export
    break;
} // end switch page

switch (@$_GET['get']) {

  // Suggestions
  case 'suggestions':
    new List_Suggestions();
    break;

} // end switch get
?>
