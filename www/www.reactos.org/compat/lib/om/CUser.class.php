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

class CUser
{



  // Get the user name from the RosCMS user table
  public static function getName($user_id) { 

    require_once(ROSCMS_PATH.'lib/RosCMS_Autoloader.class.php');
    $name = Subsystem::getUserName($user_id);
    if ($name !== false) {
      return $name;
    }
    return '';
  } // end of member function getName


  // Get the user id from the RosCMS user table
  public static function getByName($user_name) { 

    require_once(ROSCMS_PATH.'lib/RosCMS_Autoloader.class.php');
    return Subsystem::searchUserByName($user_name);
  } // end of member function getName



  // Check if the user is an developer, admin or super admin
  public static function isAdmin($user_id) { 

    //@IMPLEMENT Usergroup check
    return false;
  } // end of member function isAdmin



  public static function isModerator($user_id) { // Check if the user is an RSDB Moderator

    //@IMPLEMENT Usergroup check
    return false;
  } // end of member function isModerator



} // end of class CUser
?>
