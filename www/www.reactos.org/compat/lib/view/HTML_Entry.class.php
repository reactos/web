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
              <th></th>
              <th>Version</th>
              <th>Revision</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>';
          
      $revision_type = Setting::getPreference('revision_type');
      if (!empty($revision_type)) {
        if ($revision_type == 'trunk') {
          $not = "";
        }
        else {
          $not = "NOT";
        }
      
        $stmt=CDBConnection::getInstance()->prepare("SELECT v.id, version, v.created, works, IF(o.name IS NULL, CONCAT('r',r.revision),o.name) AS rosversion FROM ".CDBT_VERSIONS." v JOIN ".CDBT_REPORTS." r ON r.version_id=v.id LEFT JOIN ".CDBT_VERTAGS." o ON o.revision=r.revision WHERE v.entry_id=:entry_id AND o.revision IS ".$not." NULL AND r.id=(SELECT id FROM ".CDBT_REPORTS." WHERE version_id=v.id ORDER BY created DESC LIMIT 1) ORDER BY version");
      }
      else {
        $stmt=CDBConnection::getInstance()->prepare("SELECT v.id, version, v.created, works, IF(o.name IS NULL, CONCAT('r',r.revision),o.name) AS rosversion FROM ".CDBT_VERSIONS." v JOIN ".CDBT_REPORTS." r ON r.version_id=v.id LEFT JOIN ".CDBT_VERTAGS." o ON o.revision=r.revision WHERE v.entry_id=:entry_id AND r.id=(SELECT id FROM ".CDBT_REPORTS." WHERE version_id=v.id ORDER BY created DESC LIMIT 1) ORDER BY version");
      }
      $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt->execute();
      $x=0;
      while ($version = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '
          <tr class="row'.($x%2+1).'">
            <td class="first '.StatusUtil::getClass($version['works']).'" title="'.StatusUtil::getTitle($version['works']).'">&nbsp;</td>
            <td><a href="?show=version&amp;id='.$version['id'].'">'.htmlspecialchars($version['version']).'</a></td>
            <td>'.htmlspecialchars($version['rosversion']).'</td>
            <td>'.$version['created'].'</td>
          </tr>';
          ++$x;
      }
      echo '
          </tbody>
        </table>';
        
      $this->showLegend();
    }
    else {
      echo 'Entry not found.';
    }
  
  } // end of member function body



} // end of HTML_Entry
?>
