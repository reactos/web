<?php
    /*
    CompatDB - ReactOS Compatability Database
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


/**
 * class CLog
 * 
 */
class CLog
{



  /**
   * @FILLME
   *
   * @access public
   */
  public static 	function add($level, $category, $laction, $title, $desc, $baduser) {
		global $RSDB_intern_user_id;
	
		$RSDB_referrer="";
		$RSDB_usragent="";
		$RSDB_ipaddr="";
		if (array_key_exists('HTTP_REFERER', $_SERVER)) $RSDB_referrer=htmlspecialchars($_SERVER['HTTP_REFERER']);
		if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) $RSDB_usragent=htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
		if (array_key_exists('REMOTE_ADDR', $_SERVER)) $RSDB_ipaddr=htmlspecialchars($_SERVER['REMOTE_ADDR']);
	
	
    $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_LOGS." (id, creation, user_id, log_description) VALUES (NULL, NOW(), :user_id, :description)");
    $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_STR);
    $stmt->bindValue('description',$title."\n\n".$desc,PDO::PARAM_STR);
    $stmt->execute();

	} // end of member function add



} // end of CLog
?>
