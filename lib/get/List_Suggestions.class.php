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
      $stmt=CDBConnection::getInstance()->prepare("SELECT name, id, description, category_id FROM ".CDBT_ENTRIES." WHERE name LIKE :search ORDER BY name ASC");
        
    }
    $stmt->bindValue('search',@$_GET['search'].'%',PDO::PARAM_STR);
    $stmt->execute();

    // prepare for usage in loop
    $stmt_ver=CDBConnection::getInstance()->prepare("SELECT version FROM ".CDBT_VERSIONS." WHERE entry_id=:entry_id ORDER BY version DESC");
    $stmt_tag=CDBConnection::getInstance()->prepare("SELECT t.name FROM ".CDBT_TAGS." t JOIN ".CDBT_TAGGED." r ON r.tag_id=t.id WHERE r.entry_id=:entry_id ORDER BY name ASC");

    // build list of entries and their versions
    while ($entry=$stmt->fetch(PDO::FETCH_ASSOC)) {

      echo '<entry name="'.htmlspecialchars($entry['name']).'" description="'.htmlspecialchars($entry['description']).'" category="'.$entry['category_id'].'">';

      // versions
      $stmt_ver->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt_ver->execute();
      while ($version=$stmt_ver->fetch(PDO::FETCH_ASSOC)) {
        // version
        echo '<version>'.htmlspecialchars($version['version']).'</version>';
      }

      // tags
      $stmt_tag->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt_tag->execute();
      while ($tag=$stmt_tag->fetch(PDO::FETCH_ASSOC)) {
        // version
        echo '<tag>'.htmlspecialchars($tag['name']).'</tag>';
      }

      echo '</entry>';
    } // end while entry

    echo '</root>';
  } // end of constructor



} // end of List_Suggestions
?>