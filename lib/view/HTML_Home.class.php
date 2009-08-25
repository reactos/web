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


class HTML_Home extends HTML
{



  protected function body( )
  {
    global $RSDB_intern_link_db_sec;
    global $RSDB_intern_user_id;
    global $RSDB_intern_loginsystem_fullpath;
    global $RSDB_intern_link_item_comp;

    // get number of entries
    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ENTRIES." WHERE visible IS TRUE");
    $stmt->execute();
    $entries = $stmt->fetchColumn();

    // get latest reactos version
    $stmt=CDBConnection::getInstance()->prepare("SELECT revision, name FROM ".CDBT_VERTAGS." t WHERE visible IS TRUE AND 5<(SELECT COUNT(*) FROM ".CDBT_REPORTS." WHERE revision=t.revision) ORDER BY revision DESC LIMIT 1");
    $stmt->execute();
    $latest_version = $stmt->fetchOnce();

    echo '
        <h1>Compatibility Database - Overview</h1>
        <p>The ReactOS Compatibility Database contains information about compatible software. Below the latest reports are listed</p>
        <p>There are <strong>'.$entries.'</strong> applications and drivers currently in the database.</p>
      
        <div style="margin-top: 20px;">
          <a style="margin: 20px 10px 10px 10px;" href="?show=submit">
            <img style="border: none;" src="images/button_submit.jpg" alt="Submit new entry" />
          </a>
        </div>
      
        <h2 style="margin-bottom: 0px;">Recent submissions</h2><small style="display: block;margin: 0px 0px 15px 5px;"> for '.$latest_version['name'].'</small>
        <table class="rtable" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th></th>
              <th>Application</th>
              <th>User</th>
              <th style="width:100px;text-align:center;">Last update</th>
            </tr>
          </thead>
          <tbody>';

    // get recent entries
    $stmt=CDBConnection::getInstance()->prepare("SELECT e.name, r.created, r.works, e.id, user_id, (SELECT v.id FROM ".CDBT_VERSIONS." v WHERE v.entry_id=e.id ORDER BY created DESC LIMIT 1) AS version_id, (SELECT v.version FROM ".CDBT_VERSIONS." v WHERE v.entry_id=e.id ORDER BY created DESC LIMIT 1) AS version FROM ".CDBT_REPORTS." r JOIN ".CDBT_ENTRIES." e ON e.id=r.entry_id WHERE r.revision = :revision ORDER BY r.created DESC LIMIT 15");
    $stmt->bindParam('revision',$latest_version['revision'],PDO::PARAM_INT);
    $stmt->execute();
    $x=0;
    while ($entry = $stmt->fetch(PDO::FETCH_ASSOC)) {
      ++$x;

      echo '
        <tr class="row'.($x%2+1).'">
          <td class="first '.($entry['works'] == 'full' ? 'stable' : ($entry['works'] == 'part' ? 'unstable' : 'crash')).'">&nbsp;</td>
          <td><a href="?show=version&amp;id='.$entry['version_id'].'">'.htmlentities($entry['name']).'</a> '.htmlentities($entry['version']).'</td>
          <td>'.CUser::getName($entry['user_id']).'</td>
          <td style="text-align: center;white-space:nowrap;">'.$entry['created'].'</td>
        </tr>'; 
    }

    echo '
        </tbody>
      </table>
      
      <h2 style="margin: 20px 0px 5px 0px;font-size: 1.5em;">Legend</h2>
      <div style="clear: both;margin-bottom: 10px;">
        <div class="stable" style="float: left;width: 1.5em;margin-left: 10px;">&nbsp;</div> <span style="float: left; margin: 0px 2em 0px 3px;">works stable</span>
        <div class="unstable" style="float: left;width: 1.5em;">&nbsp;</div> <span style="float: left; margin: 0px 2em 0px 3px;">works unstable</span>
        <div class="crash" style="float: left;width: 1.5em;">&nbsp;</div> <span style="float: left; margin: 0px 2em 0px 3px;">Crashes sometimes</span>
      </div>';

    // print some login blah to guest users
    if ($RSDB_intern_user_id <= 0) {
      echo '
        <div style="margin-top: 30px;">
          <p style="clear: both;">
            Some of the features of the ReactOS Compatibility Database require that you have a <a href="'.$RSDB_intern_loginsystem_fullpath.'?page=register">myReactOS account</a> and are <a href="'.$RSDB_intern_loginsystem_fullpath.'?page=login">logged in</a>.
          </p>
        </div>';
    }
  } // end of member function body



} // end of HTML_Home
