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

  const MODE_NORMAL = 1;
  const MODE_DEV    = 2;

  protected function body()
  {
    $mode = self::MODE_NORMAL;

    // version info
    $stmt=CDBConnection::getInstance()->prepare("SELECT version, entry_id FROM ".CDBT_VERSIONS." WHERE id=:version_id");
    $stmt->bindParam('version_id',$_GET['ver'],PDO::PARAM_INT);
    $stmt->execute();
    $version = $stmt->fetchOnce(PDO::FETCH_ASSOC);

    // entry info
    $stmt=CDBConnection::getInstance()->prepare("SELECT e.id, e.name, e.description, c.name AS category, e.category_id FROM ".CDBT_ENTRIES." e LEFT JOIN ".CDBT_CATEGORIES." c ON c.id=e.category_id WHERE e.id=:entry_id");
    $stmt->bindParam('entry_id',$version['entry_id'],PDO::PARAM_INT);
    $stmt->execute();
    $entry = $stmt->fetchOnce(PDO::FETCH_ASSOC);

    // tagged versions
    if ($mode == self::MODE_NORMAL) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT r.revision, v.name FROM ".CDBT_REPORTS." r LEFT JOIN ".CDBT_VERTAGS." v ON r.revision=v.revision WHERE r.entry_id=:entry_id AND works IS TRUE ORDER BY v.revision DESC");
      $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt->execute();
      $report = $stmt->fetchOnce(PDO::FETCH_ASSOC);
    }

    // untagged revisions
    elseif ($mode == self::MODE_DEV) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT r.works, r.revision FROM ".CDBT_REPORTS." r LEFT JOIN ".CDBT_VERTAGS." v ON r.revision=v.revision WHERE r.entry_id=:entry_id AND v.revision IS NULL ORDER BY r.revision DESC");
      $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
      $stmt->execute();
      $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    echo '
      <h1>Compatability Database &gt; Entry Details</h1>
    
      <div>
        <h2>Details</h2>
        <table style="width: 600px;">
          <tr>
            <th style="width:100px;">Name</th>
            <td style="width:200px;"><a href="">'.htmlspecialchars($entry['name']).'</a></td>
            <th style="width:100px;">Version</th>
            <td style="width:200px;">'.htmlspecialchars($version['version']).'</td>
          </tr>
          <tr>
            <th style="width:100px;">Category</th>
            <td style="width:200px;" colspan="3"><a href="">'.htmlspecialchars($entry['category']).'</a></td>
          </tr>
          <tr>
            <th style="width:100px;">Description</th>
            <td style="width:200px;" colspan="3">'.htmlspecialchars($entry['description']).'</td>
          </tr>';
    if ($mode == self::MODE_NORMAL) {
      echo '
          <tr>
            <th style="width:100px;">Works in</th>
            <td style="width:200px;" colspan="3">'.(($report['name']) ? htmlspecialchars($report['name']) : (($report['revision'] > 0) ? 'r'.$report['revision'].' (trunk)' : 'no working version known')).'</td>
          </tr>';
    }
    echo '
        </table>
      </div>';
    
    if (isset($reports) && count($reports) > 0) {
      echo '
        <div>
          <h2>Tests</h2>
          <ul>';
      foreach($reports as $report) {
        echo '<li>'.($report['works'] ? 'works' : 'doesn\'t').' &mdash; r'.$report['revision'].'</li>';
      }
      echo '
          </ul>
        </div>';
    }


    $stmt=CDBConnection::getInstance()->prepare("SELECT title, content, created, user_id FROM ".CDBT_COMMENTS." WHERE entry_id=:entry_id AND parent IS NULL ORDER BY created DESC");
    $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_STR);
    $stmt->execute();
    $comments=$stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($comments) > 0) {
      echo '
        <div>
          <h2>Comments</h2>';

      foreach ($comments as $comment) {
        echo '
          <div>
            <div>
              <h3>'.htmlspecialchars($comment['title']).'</h3>
              <span>by '.Subsystem::getUserName($comment['user_id']).' on '.$comment['created'].'</span>
            </div>
            '.nl2br(htmlspecialchars($comment['content'])).'
          </div>';
      }

      echo '</div>';
    }
  } // end of member function body


} // end of HTML_Entry
?>
