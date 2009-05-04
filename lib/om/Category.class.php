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
  public static 	function showTreeAsOption($category_id = 0, $level = 0)
  {
    $output = '';

    $categories=self::getChilds($category_id);
    if (count($categories) > 0) {
      foreach($categories as $category) {
        $output .= '
          <option value="'.$category['id'].'">'.str_repeat('&nbsp;&nbsp;&nbsp;',$level).htmlspecialchars($category['name']).'</option>';
        $output .= self::showTreeAsOption($category['id'],$level+1);
      }
    }

    return $output;
  } // end of member function showTree



  /**
   * @FILLME
   *
   * @access private
   */
  private static function getChilds($category_id)
  {
    $stmt=CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_CATEGORIES." WHERE parent = :cat_path AND visible IS TRUE ORDER BY name ASC");
    $stmt->bindParam('cat_path',$category_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }




} // end of Category
?>
