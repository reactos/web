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

class List_Suggestions
{



  public function __construct( )
  {
    header("Content-Type: Text/XML");
    echo '<root>';
    switch (@$_GET['for']) {
      case 'name':
      default:
      $stmt=CDBConnection::getInstance()->prepare("SELECT name, version FROM ".CDBT_ENTRIES." WHERE name LIKE :search ORDER BY name ASC, version DESC");
        
    }
    $stmt->bindValue('search',@$_GET['search'].'%',PDO::PARAM_STR);
    $stmt->execute();
    $oldname = null;
    
    // build list of entries and their versions
    while ($entry=$stmt->fetch(PDO::FETCH_ASSOC)) {
    
      // open / close entry
      if ($oldname === null || $oldname != $entry['name']) {
        if ($oldname !== null) {
          echo '</entry>';
        }
        echo '<entry name="'.htmlspecialchars($entry['name']).'">';
      }
      
      // version
      echo '<version>'.htmlspecialchars($entry['version']).'</version>';
      
      // update last entry name
      $oldname = $entry['name'];
    } // end while entry
    
    // close entry
    if ($oldname !== null) {
      echo '</entry>';
    }

    echo '</root>';
  } // end of constructor



} // end of List_Suggestions
?>