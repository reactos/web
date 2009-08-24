<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2009 Danny Götte <dangerground@web.de>

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


class HTML_Entry extends HTML
{

  protected function body()
  {
    if (isset($_GET['id'])) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_ENTRIES." WHERE id=:entry_id");
      $stmt->bindParam('entry_id',$_GET['id'],PDO::PARAM_INT);
      $stmt->execute();
      $entry=$stmt->fetchOnce(PDO::FETCH_ASSOC);
    }
    
    if (isset($entry) && $entry !== false) {
      echo '
        <h2>'.htmlspecialchars($entry['name']).'</h2>
        <table class="rtable" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>Version</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>';
      
      $stmt=CDBConnection::getInstance()->prepare("SELECT id, version, created FROM ".CDBT_VERSIONS." WHERE entry_id=:entry_id ORDER BY version");
      $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt->execute();
      $x=0;
      while ($version = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '
          <tr class="row'.($x%2+1).'">
            <td><a href="?show=version&amp;id='.$version['id'].'">'.htmlspecialchars($version['version']).'</a></td>
            <td>'.$version['created'].'</td>
          </tr>';
          ++$x;
      }
      echo '
          </tbody>
        </table>';
    }
    else {
      echo 'Entry not found.';
    }
  
  } // end of member function body



} // end of HTML_Entry
?>
