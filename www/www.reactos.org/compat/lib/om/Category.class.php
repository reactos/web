<?php
    /*
    CompatDB - ReactOS Compatability Database
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


/**
 * class Category
 * 
 */
class Category
{



  /**
   * @FILLME
   *
   * @access public
   */
  public static function showTreeAsOption($selected = 0, $category_id = 0,$with_types = false)
  {
    $output = '';
    
    $types = array(
      'App'=>'Applications',
/*      'DLL'=>'Dynamic Link Libraries',*/
      'Drv'=>'Drivers'/*,
      'Oth'=>'Other'*/);
  
    $output = '';

    foreach ($types as $shortcut=>$name) {
      $output .= '<optgroup id="grp'.$shortcut.'" label="'.$name.'">';
      $output .= self::showSubTree($selected, 0, $shortcut);
      $output .= '</optgroup>';
    }

    return $output;
  } // end of member function showTree



  /**
   * @FILLME
   *
   * @access public
   */
  public static function showSubTree($selected = 0, $category_id = 0, $type = null)
  {
    static $level = -1;
    ++$level;
  
    $output = '';

    $categories=self::getChilds($category_id, $type);
    if (count($categories) > 0) {
      foreach($categories as $category) {
      
        $output .= '
          <option value="'.$category['id'].'"'.($selected == $category['id'] ? ' selected="selected"' : '').'>'.str_repeat('&nbsp;&rang;&nbsp;',$level).htmlspecialchars($category['name']).'</option>';
        $output .= self::showSubTree($selected,$category['id']);
      }
    }
    
    --$level;

    return $output;
  } // end of member function showTree



  /**
   * @FILLME
   *
   * @access private
   */
  private static function getChilds($category_id,$type=null)
  {
    if ($type !== null) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_CATEGORIES." WHERE parent IS NULL AND type = :type AND visible IS TRUE ORDER BY name ASC");
      $stmt->bindParam('type',$type,PDO::PARAM_STR);
    }
    else {
      $stmt=CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_CATEGORIES." WHERE parent = :cat_path AND visible IS TRUE ORDER BY type ASC, name ASC");
      $stmt->bindParam('cat_path',$category_id,PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }



  /**
   * @FILLME
   *
   * @access private
   */
  public static function getAllChildsAsList($category_id,$self=false,$type=null)
  {
    $list = '';

    if ($self === true && $type===null) {
      $list .= $category_id;
    }

    $childs = self::getChilds($category_id,$type);
    foreach ($childs as $child) {

      if ($list !== '') $list .= ',';
      $list .= $child['id'];

      $plus = self::getAllChildsAsList($child['id']);
      if ($list !== '' && $plus != '') $list .= ',';
      $list .= $plus; 
    }
    
    return $list;
  }




} // end of Category
?>
