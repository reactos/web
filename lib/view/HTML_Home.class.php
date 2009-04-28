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

    echo '

        <h1>Compatibility Database - Overview</h1>
        <img src="media/pictures/compatibility.jpg" alt="ReactOS Compatibility Database" style="float: right;"/>
        <p>The ReactOS Compatibility Database contains information about compatible software. Below the latest reports are listed</p>
        <p>There are <strong>'.$stmt->fetchColumn().'</strong> applications and drivers currently in the database.</p>
      
        <h2>Recent submissions</h2>
        <div class="tablebg">
          <table class="rtable" cellpadding="1" cellspacing="1">
            <thead>
              <tr>
                <th>Application</th>
                <th style="width:50px;">Works?</th>
                <th style="width:100px;text-align:center;">Last update</th>
              </tr>
            </thead>
            <tbody>';

    // show latest tests
    $stmt=CDBConnection::getInstance()->prepare("SELECT e.name, r.created, r.works, e.id FROM ".CDBT_REPORTS." r JOIN ".CDBT_ENTRIES." e ON e.id=r.entry_id JOIN ".CDBT_VERSIONS." v ON v.revision=r.revision ORDER BY v.revision DESC, r.created DESC LIMIT 10");
    $stmt->execute();
    $x=0;
    while ($entry = $stmt->fetch(PDO::FETCH_ASSOC)) {
      ++$x;

      echo '
        <tr class="row'.($x%2+1).'">
          <td><a href="'.$RSDB_intern_link_item_comp.$entry['id'].'">'.$entry['name'].'</a></td>
          <td>'.($entry['works']?'yep':'doesn\'t').'</td>
          <td style="text-align: center;">'.$entry['created'].'</td>
        </tr>'; 
    }

    echo '
          </tbody>
        </table>
      </div>
      <p>You can also <a href="'.$RSDB_intern_link_db_sec.'submit">Submit new Entries</a></p>';

    // print some login blah to guest users
    if ($RSDB_intern_user_id <= 0) {
      echo '<p style="font-size:2;">Some of the features of the ReactOS Compatibility Database require that you have a <a href="'.$RSDB_intern_loginsystem_fullpath.'?page=register">myReactOS account</a> and are <a href="'.$RSDB_intern_loginsystem_fullpath.'?page=login">logged in</a>.</p>';
    }
  } // end of member function body



} // end of HTML_Home
