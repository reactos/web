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
  public static function add( $type, $name, $version, $category, $description )
  {
    // search for existing entry
    $entry = self::get($type, $name);

    // insert new entry
    if ($entry === false) {

      // check category type
      if (!ctype_digit((string)$category) || $category == 0) {
        echo 'Error: Invalid category';
        return false;
      }
      
      // check type
      if ($type != 'app' && $type != 'dll' && $type != 'drv' && $type != 'oth') {
        echo 'Error: Invalid type';
        return false;
      }

      // insert
      $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_ENTRIES." (type, name, category_id, description, created, modified, visible) VALUES (:type, :name, :category, :description, NOW(), NOW(), TRUE)");
      $stmt->bindParam('type',$type,PDO::PARAM_STR);
      $stmt->bindParam('name',$name,PDO::PARAM_STR);
      $stmt->bindParam('category',$category,PDO::PARAM_INT);
      $stmt->bindParam('description',$description,PDO::PARAM_STR);
      if(!$stmt->execute()) {
        return false;
      }

      $entry = self::get($type, $name);
    }

    // update entry
    elseif ($category != $entry['category_id'] || $description != $entry['description']) {
    
      $stmt=CDBConnection::getInstance()->prepare("UPDATE ".CDBT_ENTRIES." SET category_id=:category, description=:description, modified=NOW() WHERE id=:entry_id");
      $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt->bindParam('category',$category,PDO::PARAM_INT);
      $stmt->bindParam('description',$description,PDO::PARAM_STR);
      if(!$stmt->execute()) {
        return false;
      }
    }

    // insert version
    $ver = self::getVersionId($entry['id'], $version);
    if ($ver === false) {
      $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_VERSIONS." (entry_id, version, created) VALUES (:entry_id, :version, NOW())");
      $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt->bindParam('version',$version,PDO::PARAM_STR);
      if(!$stmt->execute()) {
        return false;
      }
    }

    return array('entry'=>$entry['id'],'version'=>self::getVersionId($entry['id'],$version));
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function addReport( $entry_id, $version_id, $comment_id, $revision, $env, $env_version, $status = 'not' )
  {
    global $RSDB_intern_user_id;

    // check if entry exists
    if ($entry_id === false || $version_id === false) {
      echo 'Error: Unknown entry';
      return false;
    }

    // insert
    $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_REPORTS." (id, entry_id, version_id, comment_id, user_id, revision, environment, environment_version, works, checked, created, visible, disabled) VALUES (NULL, :entry_id, :version_id, :comment_id, :user_id, :revision, :env, :env_ver, :status, :checked, NOW(), TRUE, FALSE)");
    $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_INT);
    $stmt->bindParam('version_id',$version_id,PDO::PARAM_INT);
    $stmt->bindParam('comment_id',$comment_id,PDO::PARAM_INT);
    $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_INT);
    $stmt->bindParam('revision',$revision,PDO::PARAM_INT);
    $stmt->bindParam('env',$env,PDO::PARAM_STR);
    $stmt->bindParam('env_ver',$env_version,PDO::PARAM_STR);
    $stmt->bindParam('status',$status,PDO::PARAM_STR);
    $stmt->bindParam('checked',hasRight('checked_tests'),PDO::PARAM_BOOL);
    return $stmt->execute();
  } // end of member function addReport



  /**
   * @FILLME
   *
   * @access public
   */
  public static function deleteReport( $test_id )
  {
    $stmt=CDBConnection::getInstance()->prepare("DELETE FROM ".CDBT_REPORTS." WHERE id=:test_id");
    $stmt->bindParam('test_id',$test_id,PDO::PARAM_INT);
    return $stmt->execute();
  } // end of member function addReport



  /**
   * @FILLME
   *
   * @access public
   */
  public static function addComment( $entry_id, $title, $content , $reply=null)
  {
    global $RSDB_intern_user_id;

    // check if entry exists
    if ($entry_id === false) {
      echo 'Error: Unknown entry';
      return false;
    }

    // insert
    $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_COMMENTS." (entry_id, user_id, parent, title, content, created, visible) VALUES (:entry_id, :user_id, :parent, :title, :content, NOW(), TRUE)");
    $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_INT);
    $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_INT);
    if (empty($reply)) {
      $stmt->bindValue('parent',null,PDO::PARAM_NULL);
    }
    else {
      $stmt->bindParam('parent',$reply,PDO::PARAM_INT);
    }
    $stmt->bindParam('title',$title,PDO::PARAM_STR);
    $stmt->bindParam('content',$content,PDO::PARAM_STR);
    
    //@ last_insert_id
    if ($stmt->execute()) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT id FROM ".CDBT_COMMENTS." WHERE entry_id=:entry_id AND user_id=:user_id ORDER BY created DESC LIMIT 1");
      $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_INT);
      $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchColumn();
    }
    
    return false;
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function deleteComment( $comment_id)
  {
    $stmt=CDBConnection::getInstance()->prepare(" DELETE FROM ".CDBT_COMMENTS." WHERE id=:comment_id");
    $stmt->bindParam('comment_id',$comment_id,PDO::PARAM_INT);
    return $stmt->execute();
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function addScreenshot( $entry_id, $ptr )
  {
    global $RSDB_intern_user_id;
    global $CDB_upload_path_fs;

    // check if entry exists
    if ($entry_id === false) {
      echo 'Error: Unknown entry';
      return false;
    }
    
    $filename = date('Y-m-d-H-i-s').'_'.$RSDB_intern_user_id.'_'.rawurlencode(htmlspecialchars($_FILES[$ptr]['name']));
    
    if (move_uploaded_file($_FILES[$ptr]['tmp_name'], $CDB_upload_path_fs.$filename)) {
    
      Image::thumb($_FILES[$ptr]['type'], $CDB_upload_path_fs.$filename, $CDB_upload_path_fs.'th/'.$filename, 120, "reactos.org");

      // insert
      $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_ATTACHMENTS." (id, entry_id, user_id, file, type, description, created, visible) VALUES (NULL, :entry_id, :user_id, :file, 'picture', :description, NOW(), TRUE)");
      $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_INT);
      $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_INT);
      $stmt->bindParam('file',$filename,PDO::PARAM_STR);
      $stmt->bindParam('description',$_POST['description'],PDO::PARAM_STR);
      return $stmt->execute();
    }
    else {
      echo 'Problem while uploading file.<br /><pre>';
      var_dump($_FILES);
      echo '</pre>';
    }

    return false;
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function get( $type, $name )
  {
    // search for existing entry
    $stmt=CDBConnection::getInstance()->prepare("SELECT id, type, name, description, category_id FROM ".CDBT_ENTRIES." WHERE name LIKE :name AND type = :type LIMIT 1");
    $stmt->bindParam('name',$name,PDO::PARAM_STR);
    $stmt->bindParam('type',$type,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchOnce(PDO::FETCH_ASSOC);
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function getEntryId( $type, $name )
  {
    // search for existing entry
    $entry = self::get($type, $name);
    if ($entry !== false) {
      return $entry['id'];
    }
    return false;
  } // end of member function add



  /**
   * @FILLME
   *
   * @access public
   */
  public static function getVersionId( $entry_id, $version)
  {
    // search for existing entry
    // search for existing entry
    $stmt=CDBConnection::getInstance()->prepare("SELECT id FROM ".CDBT_VERSIONS." WHERE entry_id = :entry_id AND version = :version ORDER BY created DESC LIMIT 1");
    $stmt->bindParam('entry_id',$entry_id,PDO::PARAM_INT);
    $stmt->bindParam('version',$version,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
  } // end of member function add



} // end of Entry
?>
