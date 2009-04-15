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


class Breadcrumb
{



  const MODE_NONE    = 0; // no breadcrumb
  const MODE_INITIAL = 1; // show initial letter
  const MODE_TREE    = 2; // show hierarchical list
  const MODE_VENDOR  = 4; // show vendor
  
  const PARAM_UNKNOWN  = 0;
  const PARAM_CATEGORY = 1;
  const PARAM_ENTRY    = 2;
  const PARAM_VERSION  = 3;
  const PARAM_VENDOR   = 4;



  public function __construct( $mode = self::NONE, $param, $param_type = self::PARAM_UNKNOWN)
  {
    echo '
        <div style="clear: both;border: 2px solid gray;">
          <span style="float: left;">Browsing:&nbsp;</span>
          <ul style="list-style-type: none;display: inline;">';
  
    // needs entry
    if ($mode & self::MODE_INITIAL) {
      self::initial($param, $param_type);
    }
    
    // needs entry or category
    if ($mode & self::MODE_TREE) {
      self::tree($param, $param_type);
    }
    
    // needs vendor
    if ($mode & self::MODE_VENDOR) {
      self::vendor($param, $param_type);
    }

    // get version data
    if ($param > 0 && $param_type === self::PARAM_VERSION) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT comp_groupid, comp_id, comp_appversion, grpentr_name FROM rsdb_item_comp JOIN rsdb_groups ON grpentr_id=comp_group_id WHERE grpentr_visible = '1' AND comp_id = :item_id AND comp_visible='1'") ;
      $stmt->bindParam('item_id',$param,PDO::PARAM_INT);
      $stmt->execute();
      $version = $stmt->fetchOnce(PDO::FETCH_ASSOC);
      $version_id = $version['comp_id'];
      $version_name = $version['comp_appversion'];
      $entry_id = $version['comp_groupid'];
    }

    // get entry data
    elseif ($param > 0 && $param_type === self::PARAM_ENTRY) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT grpentr_id, grpentr_category, grpentr_name FROM rsdb_groups WHERE grpentr_visible = '1' AND grpentr_id = :group_id") ;
      $stmt->bindParam('group_id',$param,PDO::PARAM_INT);
      $stmt->execute();
      $group = $stmt->fetchOnce(PDO::FETCH_ASSOC);
      $entry_id = $group['grpentr_id'];
      $entry_name = $group['grpentr_name'];
    }

    // show entry, if selected
    if (isset($entry_id)) {
      echo '
            <li style="float: left;padding-left: 10px;">&rarr; <a href="'.$entry_id.'">'.htmlspecialchars($entry_name).'</a></li>';
    }

    // show entry, if selected
    if (isset($version_id)) {
      echo '
            <li style="float: left;padding-left: 10px;"> [<a href="'.$version_id.'">'.htmlspecialchars($version_name).'</a>] </li>';
    }

      echo '
          </ul>
          <br style="clear: both;"/>
        </div>';
  } // end of constructor



  private function tree( $param, $param_type )
  {
    global $RSDB_intern_link_category_cat;
  
    $description = 'Root directory of the tree.';

    // check if category exists and is visible
    if ($param > 0 && $param_type === self::PARAM_CATEGORY) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT cat_id FROM rsdb_categories WHERE cat_id = :cat_id AND cat_visible = '1'");
      $stmt->bindParam('cat_id',$param,PDO::PARAM_INT);
      $stmt->execute();
      $category_id = $stmt->fetchColumn();

      if ($category_id === false) {
        echo 'Unknown Category';
        return;
      }
    }

    // check if entry exists and is visible
    elseif ($param > 0 && $param_type === self::PARAM_ENTRY) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT grpentr_id, grpentr_category, grpentr_name FROM rsdb_groups WHERE grpentr_visible = '1' AND grpentr_id = :group_id") ;
      $stmt->bindParam('group_id',$param,PDO::PARAM_INT);
      $stmt->execute();
      $category_id = $stmt->fetchOnce(PDO::FETCH_ASSOC);

      if ($group === false) {
        echo 'Unknown Group';
        return;
      }
    }

    // check if entry version exists and is visible
    elseif ($param > 0 && $param_type === self::PARAM_VERSION) {
      //@TODO
    }

    // show root
    echo '
      <li style="float: left;"><a href="'.$RSDB_intern_link_category_cat.'0">Root</a></li>';

    if (isset($category_id) && $category_id === false) {
      echo '<li>&rarr; Unknown Category</li>';
      return;
    }

    // show current path
    $stmt=CDBConnection::getInstance()->prepare("SELECT cat_name, cat_id, cat_path FROM rsdb_categories WHERE cat_id=:cat_id");
    $stmt->bindParam('cat_id',$category_id,PDO::PARAM_INT);
    $stmt->execute();

    // get output in reversed order
    $output = '';
    while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $output = '
        <li style="float: left;padding-left: 10px;">&rarr; <a href="'.$RSDB_intern_link_category_cat.$category['cat_id'].'">'.htmlspecialchars($category['cat_name']).'</a></li>'.$output;

      if ($category['cat_path'] > 0) {
        $stmt->bindParam('cat_id',$category['cat_path'],PDO::PARAM_INT);
        $stmt->execute();
      }
    } // end while

    echo $output;
  } // end of member function tree



  private static function vendor( $param, $param_type )
  {

    if ($param > 0 && $param_type === self::PARAM_ENTRY) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT grpentr_vendor, grpentr_name FROM rsdb_groups WHERE grpentr_visible = '1' AND grpentr_id = :group_id") ;
      $stmt->bindParam('group_id',$param,PDO::PARAM_INT);
      $stmt->execute();
      $vendor_id = $stmt->fetchColumn();

      if ($vendor_id === false) {
        echo 'Unknown Group';
        return;
      }
    }

    // check if entry version exists and is visible
    elseif ($param > 0 && $param_type === self::PARAM_VERSION) {
      //@TODO
    }

    // no valid params 
    else {
      echo 'Unknown parameter';
      return;
    }

    if ($vendor_id) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT vendor_name FROM rsdb_item_vendor WHERE vendor_id = :vendor_id ORDER BY vendor_name ASC");
      $stmt->bindParam('vendor_id',$_GET['vendor'],PDO::PARAM_STR);
      $stmt->execute();
      $vendor_name = $stmt->fetchColumn();
      if ($vendor === false) {
        echo 'Unknown Vendor';
        return;
      }
    }
    else {
      echo 'Can\'t find Vendor';
    }

    echo '<li>'.$vendor_name.'</li>';
  } // end of member function vendor



  private static function initial( $param, $param_type )
  {
    global $RSDB_intern_link_db_sec;

    // get entry by version
    if ($param > 0 && $param_type === self::PARAM_VERSION) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT comp_groupid FROM rsdb_item_comp WHERE comp_visible = '1' AND comp_id = :item_id") ;
      $stmt->bindParam('item_id',$_GET['item'],PDO::PARAM_INT);
      $stmt->execute();
      $group_id = $stmt->fetchColumn();
      
      if ($group_id === false) {
        echo 'Unknown Item';
        return;
      }
      $group_id = $result_itempid['comp_groupid'];
    }

    // get first letter by entry
    elseif ($param > 0 && $param_type === self::PARAM_ENTRY) {
      $group_id = $param;
    }

    // we need an entry to get the first char
    if (isset($group_id)) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT UPPER(SUBSTRING(LTRIM(grpentr_name), 1, 1)) AS letter, grpentr_name FROM rsdb_groups WHERE grpentr_visible = '1' AND grpentr_id = :group_id");
      $stmt->bindParam('group_id',$group_id,PDO::PARAM_INT);
      $stmt->execute();
      $group = $stmt->fetchOnce(PDO::FETCH_ASSOC);
      $letter = $group['letter'];
    }
    else {
      echo 'Unknown Entry';
      return;
    }

    // number
    if ($letter > 0) {
      echo '
        <li style="float: left;"><a href="'.$RSDB_intern_link_db_sec.'name&amp;letter='.strtolower($letter).'">#</a></li>';
    }

    // letter
    elseif ($letter != '') {
      echo '
        <li style="float: left;"><a href="'.$RSDB_intern_link_db_sec.'name&amp;letter='.strtolower($letter).'">'.$letter.'</a></li>';
    }

    // Unknown letter
    else {
      echo '
        <li style="float: left;">Unknown</li>';
    }
  } // end of member function initial



} // end of Breadcrumb

