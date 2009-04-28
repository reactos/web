<?php
    /*
    RosCMS - ReactOS Content Management System
    Copyright (C) 2009 Danny Götte <gvg@reactos.org>

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
 * class Entry
 * 
 */
class Entry
{



  /**
   * @FILLME
   *
   * @access public
   */
  public static function add( $title, $version, $category, $description, $tags, $update = false )
  {
    // search for existing entry
    $entry_id = self::getId($title, $version);

    // insert new entry
    if ($entry_id === false) {

      // check category type
      if (!ctype_digit((string)$category) || $category == 0) {
        echo 'Error: Unknown Categorie';
        return false;
      }

      // insert
      $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_ENTRIES." (name, version, category_id, description, created, modified, visible) VALUES (:name, :version, :category, :description, NOW(), NOW(), TRUE)");
      $stmt->bindParam('name',$title,PDO::PARAM_STR);
      $stmt->bindParam('version',$version,PDO::PARAM_STR);
      $stmt->bindParam('category',$category,PDO::PARAM_INT);
      $stmt->bindParam('description',$description,PDO::PARAM_STR);
      if(!$stmt->execute()) {
        return false;
      }

      $entry_id = self::getId($title, $version);
    }

    // update entry
    elseif ($update) {
      $stmt=CDBConnection::getInstance()->prepare("UPDATE ".CDBT_ENTRIES." SET category=:category, description=:description, modified=NOW() WHERE id=:entry_id");
      $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_STR);
      $stmt->bindParam('category',$category,PDO::PARAM_INT);
      $stmt->bindParam('description',$description,PDO::PARAM_STR);
      if(!$stmt->execute()) {
        return false;
      }
    }

    return $entry_id;
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function addReport( $entry_id, $revision, $status = false )
  {
    global $RSDB_intern_user_id;

    // check if entry exists
    if ($entry_id === false) {
      echo 'Error: Unknown entry';
      return false;
    }

    // insert
    $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_REPORTS." (entry_id, user_id, revision, works, created, visible, disabled) VALUES (:entry_id, :user_id, :revision, :status, NOW(), TRUE, FALSE)");
    $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_INT);
    $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_INT);
    $stmt->bindParam('revision',$revision,PDO::PARAM_INT);
    $stmt->bindParam('status',$status,PDO::PARAM_BOOL);
    return $stmt->execute();
  } // end of member function addReport



  /**
   * @FILLME
   *
   * @access public
   */
  public static function addComment( $entry_id, $title, $content )
  {
    global $RSDB_intern_user_id;

    // check if entry exists
    if ($entry_id === false) {
      echo 'Error: Unknown entry';
      return false;
    }

    // insert
    $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_COMMENTS." (entry_id, user_id, parent, title, content, created, visible) VALUES (:entry_id, :user_id, NULL, :title, :content, NOW(), TRUE)");
    $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_INT);
    $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_INT);
    $stmt->bindParam('title',$title,PDO::PARAM_STR);
    $stmt->bindParam('status',$content,PDO::PARAM_STR);
    return $stmt->execute();
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function getId( $title, $version )
  {
    // search for existing entry
    $stmt=CDBConnection::getInstance()->prepare("SELECT id FROM ".CDBT_ENTRIES." WHERE name LIKE :name AND version LIKE :version LIMIT 1");
    $stmt->bindParam('name',$title,PDO::PARAM_STR);
    $stmt->bindParam('version',$version,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
  } // end of member function add



} // end of Entry
?>
