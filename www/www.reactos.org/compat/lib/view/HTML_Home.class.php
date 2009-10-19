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

    echo '
        <h1>Compatibility Database - Overview</h1>
        <p>The ReactOS Compatibility Database contains information about compatible software. Below the latest reports are listed</p>
        <p>There are <strong>'.$entries.'</strong> applications and drivers currently in the database.</p>
      
        <div style="margin-top: 20px;">
          <a style="margin: 20px 10px 10px 10px;" href="?show=submit">
            <img style="border: none;" src="images/button_submit.jpg" alt="Submit new entry" />
          </a>
        </div>
        ';
    $frontpage = Setting::getPreference('frontpage');
    $revision_type = Setting::getPreference('revision_type');


    // standard
    if (empty($frontpage)) {

    
      // get latest reactos version
      $stmt=CDBConnection::getInstance()->prepare("SELECT revision, name FROM ".CDBT_VERTAGS." t WHERE visible IS TRUE AND 5<(SELECT COUNT(*) FROM ".CDBT_REPORTS." WHERE revision=t.revision) ORDER BY revision DESC LIMIT 1");
      $stmt->execute();
      $latest_version = $stmt->fetchOnce();
    
      echo '
        <h2 style="margin-bottom: 0px;">Recent submissions</h2><small style="display: block;margin: 0px 0px 15px 5px;"> for '.$latest_version['name'].'</small>';

      if (!empty($revision_type)) {
        $filter = 'a_is_user|a_is_datediff|o_desc_report';
      }
      else {
        $filter = 'a_is_user|a_is_datediff|r_eq_'.$latest_version['revision'].'|o_desc_report';
      }


    }
    // custom query
    else {
      $filter = $frontpage;
    }

    if (!empty($revision_type)) {
      $filter .= Listing::DEVIDE_FILTER.'p'.Listing::DEVIDE_SETTING.'is'.Listing::DEVIDE_SETTING.$revision_type;
    }
      // evaluate filters
      $this->listing = new Listing($filter);
      
      // apply to current settings
      $this->where = $this->listing->where();
      $this->from = $this->listing->from();
      $this->select = $this->listing->select();
      $this->order = $this->listing->order();
      $this->params = $this->listing->params();
      $this->showColumn = $this->listing->showColumn();
      
      $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ENTRIES." e JOIN ".CDBT_REPORTS." r ON r.entry_id=e.id ".$this->from." WHERE e.visible IS TRUE AND r.id=(SELECT id FROM ".CDBT_REPORTS." WHERE entry_id=e.id ORDER BY created DESC LIMIT 1) ".$this->where);
      foreach ($this->params as $param) {
        $stmt->bindValue($param[0],$param[1],$param[2]);
      }
      $stmt->execute();
      $entries_count = $stmt->fetchColumn();

      if ($entries_count > 0) {
        echo '
          <h2>Entries</h2>
          <table class="rtable" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>&nbsp;</th>
                <th>Name</th>';
        if (count($this->showColumn) > 0) {
          foreach ($this->showColumn as $column) {
            echo '<th>'.$column['description'].'</th>';
          }
        }
        echo '
              </tr>
            </thead>
            <tbody>';

        reset($this->params);
        $stmt=CDBConnection::getInstance()->prepare("SELECT e.id, e.name, r.works ".$this->select." FROM ".CDBT_ENTRIES." e JOIN ".CDBT_REPORTS." r ON r.entry_id=e.id ".$this->from." WHERE e.visible IS TRUE AND r.id=(SELECT id FROM ".CDBT_REPORTS." WHERE entry_id=e.id ORDER BY created DESC LIMIT 1) ".$this->where.(!empty($this->order) ? ' ORDER BY '.$this->order : '')." LIMIT 15");
        foreach ($this->params as $param) {
          $stmt->bindValue($param[0],$param[1],$param[2]);
        }
        $stmt->execute();
        $x=0;
        while ($entry=$stmt->fetch(PDO::FETCH_ASSOC)) {
          ++$x;

          $stmt_ver=CDBConnection::getInstance()->prepare("SELECT id, version FROM ".CDBT_VERSIONS." WHERE entry_id=:entry_id ORDER BY version DESC");
          $stmt_ver->bindParam('entry_id',$entry['id'],PDO::PARAM_STR);
          $stmt_ver->execute();
          $versions = $stmt_ver->fetchAll(PDO::FETCH_ASSOC);
          
          // display entry only if it has also at least one version information
          if (count($versions) > 0) {
            echo '
              <tr onmouseover="highlightTableRow(this);" class="row'.($x%2+1).'">
                <th class="first"><div class="'.($entry['works'] == 'full' ? 'stable' : ($entry['works'] == 'part' ? 'unstable' : 'crash')).'">&nbsp;</div></th>
                <td>';

            // just one version stored
            if (count($versions) == 1) {
              echo '
                  <a href="?show=version&amp;id='.$versions[0]['id'].'">'.htmlspecialchars($entry['name']).'</a> <small style="color: gray;">'.$versions[0]['version'].'</small>';
            }

            // show all app version
            else {
              echo '
                <a href="?show=entry&amp;id='.$entry['id'].'">'.htmlspecialchars($entry['name']).'</a> <small style="color: gray;">(several versions)</small>';

            }

            echo '
                </td>';
            if (count($this->showColumn) > 0) {
              foreach ($this->showColumn as $column) {
                if (isset($column['format'])) {
                  echo '<td>'.call_user_func($column['format'],$entry[$column['field']]).'</td>';
                }
                else {
                  echo '<td>'.htmlspecialchars($entry[$column['field']]).'</td>';
                }
              }
            }
            echo '
              </tr>';
          }
        }

        echo '
            </tbody>
          </table>';
      }
      else {
        echo 'No entries found.';
      }

    echo '
      
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
