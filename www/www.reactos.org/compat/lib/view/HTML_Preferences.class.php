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


class HTML_Preferences extends HTML
{


  public function __construct( )
  {
    global $RSDB_intern_user_id;

    // check if user is logged in
    $RSDB_intern_user_id = Subsystem::in(Login::REQUIRED, $_SERVER["REQUEST_URI"]);

    // write back settings
    if (isset($_POST)) {
    
      // for frontpage
      if (isset($_POST['frontpage'])) {
        Setting::setPreference('frontpage',$_POST['frontpage']);
      }

      // for displayed revision
      if (isset($_POST['revision'])) {
        Setting::setPreference('revision_type',$_POST['revision']);
      }

      // for notification
      if (isset($_POST['notification'])) {
        Setting::setPreference('notification_type',$_POST['notification']);
      }

      // for standard queries
      if (isset($_POST['standard_queries'])) {
        Setting::setPreference('standard queries',$_POST['standard_queries']);
      }
    } // end of write actions
  
    parent::__construct();
  }



  protected function body()
  {
    global $RSDB_intern_user_id;

    $frontpage = Setting::getPreference('frontpage');
    $revision = Setting::getPreference('revision_type');
    $notification = Setting::getPreference('notification_type');
    $standard_queries = Setting::getPreference('standard queries');

    echo '
      <h1>Compatability Database &gt; Preferences</h1>
      <form id="preferences" action="?show=preferences" method="post">
        <fieldset>
          <ul>
            <li>
              <label for="frontpage">Frontpage:</label>
              <select id="frontpage" name="frontpage">
                <option value=""'.(empty($frontpage) ? ' selected="selected"':'').'>Reports for latest Release Version</option>';
    $stmt=CDBConnection::getInstance()->prepare("SELECT value, name FROM ".CDBT_SETTINGS." WHERE type = 'query' AND user_id=:user_id ORDER BY name ASC");
    $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_INT);
    $stmt->execute();
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($settings) > 0) {
      echo '<optgroup label="own queries">';
      foreach ($settings as $setting) {
        echo '<option value="'.htmlspecialchars($setting['value']).'"'.($frontpage == $setting['value'] ? ' selected="selected"':'').'>'.htmlspecialchars($setting['name']).'</option>';
      }
      echo '</optgroup>';
    }
    
    echo '
              </select>
            </li>
            <li>
              <label for="revision">Shown revisions: (applies to standard filters)</label>
              <select id="revision" name="revision">
                <option value=""'.(empty($revision) ? ' selected="selected"':'').'>don\'t care</option>
                <option value="release"'.($revision == 'release' ? ' selected="selected"':'').'>just release versions</option>
                <option value="trunk"'.($revision == 'trunk' ? ' selected="selected"':'').'>only trunk revisions</option>
              </select>
            </li>
            <li>
              <label for="standard_queries">Show browse by in navigation: </label>
              <select id="standard_queries" name="standard_queries">
                <option value=""'.(empty($standard_queries) ? ' selected="selected"':'').'>Yes</option>
                <option value="false"'.($standard_queries == 'false' ? ' selected="selected"':'').'>No</option>
              </select>
            </li><!--
            <li>
              <label for="notification">Notification: </label>
              <select id="notification" name="notification">
                <option value=""'.(empty($notification) ? ' selected="selected"':'').'>none</option>
                <option value="mail"'.($notification == 'mail' ? ' selected="selected"':'').'>by email</option>
              </select>
            </li>-->
            <li>
              <button type="submit">Update preferences</button>
            </li>
          </ul>
        </fieldset>
      </form>';
  
  } // end of member function body



} // end of HTML_Preferences
?>
