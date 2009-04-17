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


class Home extends HTML
{



  protected function body( )
  {
    global $RSDB_intern_link_db_sec;
    global $RSDB_intern_user_id;
    global $RSDB_intern_loginsystem_fullpath;
    global $RSDB_intern_link_item_comp;

    // get number of entries
    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_groups WHERE grpentr_visible = '1'");
    $stmt->execute();

    echo '

        <h1>Compatibility Database - Overview</h1>
        <img src="media/pictures/compatibility.jpg" alt="ReactOS Compatibility Database" style="float: right;"/>
        <p>The ReactOS Compatibility Database contains information about compatible software. Below the latest reports are listed</p>
        <p>There are <strong>'.$stmt->fetchColumn().'</strong> applications and drivers currently in the database.</p>
      
        <h2>Recent submissions</h2>
        <div style="margin:10px 10px 0 0; width:500px; border:1px solid #dfdfdf; padding:1em; background-color:#EAF0F8;">
          <table style="width:100%; border: none;" cellpadding="1" cellspacing="1">
            <tr style="background-color:#5984C3;color:white;">
              <th>Application</th>
              <th style="width:50px;">Works?</th>
              <th style="width:150px;text-align:center;">Last update</th>
            </tr>';

    //@MOVEME to css
    $cellcolor1='#E2E2E2';
    $cellcolor2='#EEEEEE';
    $cellcolorcounter=0;

    // show latest tests
    $stmt=CDBConnection::getInstance()->prepare("SELECT t.test_user_submit_timestamp, i.comp_id, i.comp_name FROM rsdb_item_comp_testresults t JOIN rsdb_item_comp i ON t.test_comp_id=i.comp_id WHERE t.test_visible = '1' ORDER BY t.test_id DESC LIMIT 10");
    $stmt->execute();
    while ($entry = $stmt->fetch(PDO::FETCH_ASSOC)) {
      ++$cellcolorcounter;

      echo '
        <tr style="background-color:'.($cellcolorcounter%2 ? $cellcolor1 : $cellcolor2).';">
          <td><a href="'.$RSDB_intern_link_item_comp.$entry['comp_id'].'&amp;item2=tests">'.$entry['comp_name'].'</a></td>
          <td>TBI</td>
          <td style="text-align: center;">'.$entry['test_user_submit_timestamp'].'</td>
        </tr>'; 
    }

    echo '
        </table>
      </div>
      <p>You can also <a href="'.$RSDB_intern_link_db_sec.'submit">Submit new Entries</a></p>';

    // print some login blah to guest users
    if ($RSDB_intern_user_id <= 0) {
      echo '<p style="font-size:2;">Some of the features of the ReactOS Compatibility Database require that you have a <a href="'.$RSDB_intern_loginsystem_fullpath.'?page=register">myReactOS account</a> and are <a href="'.$RSDB_intern_loginsystem_fullpath.'?page=login">logged in</a>.</p>';
    }
  } // end of member function body



} // end of Home
