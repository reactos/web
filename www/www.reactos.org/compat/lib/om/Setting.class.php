<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2009  Danny Götte <dangerground@web.de>

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


class Setting
{

  
  
  
  private static function read($type, $name, $user_id=null)
  {
    global $RSDB_intern_user_id;
    
    // guests don't have settings
    if ($user_id === null) {
      $user_id = $RSDB_intern_user_id;
    }
    
    if ($user_id <= 0) {
      return false;
    }
    
    // do we already have a frontpage setting?
    $stmt=CDBConnection::getInstance()->prepare("SELECT value FROM ".CDBT_SETTINGS." WHERE type=:type AND name=:name AND user_id=:user_id");
    $stmt->bindParam('user_id',$user_id,PDO::PARAM_INT);
    $stmt->bindParam('type',$type,PDO::PARAM_INT);
    $stmt->bindParam('name',$name,PDO::PARAM_INT);
    if ($stmt->execute()) {
      return $stmt->fetchColumn();
    }
    return false;
  } // end of member function writePreference
  
  
  
  private static function write($type, $name, $value, $user_id=null)
  {
    global $RSDB_intern_user_id;
    
    // guests don't have settings
    if ($user_id === null) {
      $user_id = $RSDB_intern_user_id;
    }
    
    if ($user_id <= 0) {
      return false;
    }

    // do we already have a setting?
    $stmt=CDBConnection::getInstance()->prepare("SELECT id FROM ".CDBT_SETTINGS." WHERE type=:type AND name=:name AND user_id=:user_id");
    $stmt->bindParam('user_id',$user_id,PDO::PARAM_INT);
    $stmt->bindParam('type',$type,PDO::PARAM_INT);
    $stmt->bindParam('name',$name,PDO::PARAM_INT);
    $stmt->execute();
    $setting_id = $stmt->fetchColumn();
    if ($setting_id !== false) {

      // update setting
      $stmt=CDBConnection::getInstance()->prepare("UPDATE ".CDBT_SETTINGS." SET value=:value, modified=NOW() WHERE id=:setting_id");
      $stmt->bindParam('value',$value,PDO::PARAM_STR);
      $stmt->bindParam('setting_id',$setting_id,PDO::PARAM_INT);
      return $stmt->execute();
    }
    else {

      // insert new setting
      $stmt=CDBCOnnection::getInstance()->prepare("INSERT INTO ".CDBT_SETTINGS." (id, type, name, user_id, value, created, modified) VALUES (NULL,:type,:name,:user_id,:value, NOW(), NOW())");
      $stmt->bindParam('name',$name,PDO::PARAM_STR);
      $stmt->bindParam('type',$type,PDO::PARAM_INT);
      $stmt->bindParam('value',$value,PDO::PARAM_STR);
      $stmt->bindParam('user_id',$user_id,PDO::PARAM_INT);
      return $stmt->execute();
    }
  } // end of member function writePreference

  
  
  
  public static function getQuery($name)
  {
    return self::read('query', $name);
  } // end of member function writePreference
  
  
  
  public static function setQuery($name, $value)
  {
    return self::write('query', $name, $value);
  } // end of member function writePreference

  
  
  
  public static function getPreference($name)
  {
    return self::read('preference', $name);
  } // end of member function writePreference
  
  
  
  public static function setPreference($name, $value)
  {
    return self::write('preference', $name, $value);
  } // end of member function writePreference
  
  
  
  
  
  public static function hasRight($name, $user_id=null)
  {
    return (self::read('right', $name, $user_id) === 'true');
  } // end of member function writePreference
  
  
  public static function setRight($user_id, $name, $value)
  {
    if (self::hasRight('grant')) {
      return self::write('right', $name, $value?'true':'false', $user_id);
    }
    
    return false;
  } // end of member function writePreference
  
} // end Setting
?>

