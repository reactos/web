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

class HTML_Submit extends HTML
{


  public function __construct( )
  {
    $this->register_js('submit.js');
  
    parent::__construct();
  }


  protected function build( )
  {
    if (isset($_POST['next']) && $_POST['next'] == 'entry') {
      $entry_id = Entry::getEntryId($_POST['type'], $_POST['title']);
      $version_id = Entry::getVersionId($entry_id, $_POST['version']);
      header('location: ?page=item&ver='.$version_id);
      exit;
    }
    elseif (isset($_POST['next']) && $_POST['next'] == 'bug') {
      echo 'Imagine a bugzilla here';
      exit;
    }
    else {
      $this->header();
      $this->navigation();
      if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'yes') {
        $this->submit();
      }
      $this->body();
      $this->footer();
    }
  }


  private function submit( )
  {
    // get used revision number
    if ($_POST['ver'] == 'R') {
      $revision = $_POST['rev'];
    }
    else {
      $revision = $_POST['ver'];
    }

    // try to insert a new entry
    if (isset($_POST['title']) && $_POST['title'] != '' && isset($_POST['tags']) && isset($_POST['cat']) && isset($_POST['description']) && isset($_POST['version']) && $_POST['version'] != '') {
      $ids = Entry::add($_POST['type'], $_POST['title'], $_POST['version'], $_POST['cat'], $_POST['description'], $_POST['tags']);

      // got no error
      if ($ids !== false) {
        $entry_id = $ids['entry'];
        $version_id = $ids['version'];
      }
    }
    
    if (!isset($entry_id)) {
      $entry_id = Entry::getEntryId($_POST['type'], $_POST['title']);
      if ($entry_id !== false) {
        $version_id = Entry::getVersionId($entry_id, $_POST['version']);
      }
    }

    // insert new report/comment
    if ($entry_id !== false && $version_id !== false) {
      if (isset($_POST['status']) && ($_POST['status'] == 'full' || $_POST['status'] == 'part' ||$_POST['status'] == 'not')) {
        if ($_POST['env'] == 'RH') {
          $env = 'RH';
          $env_ver = '';
        }
        else {
          $env = $_POST['vm'];
          $env_ver = $_POST['vmver'];
        }

        Entry::addReport($entry_id, $version_id, $revision, $env, $env_ver, $_POST['status']);
      }

      // insert new comment
      if (isset($_POST['comment']) && $_POST['comment'] != '') {
        Entry::addComment($entry_id, 'test of r'.$revision, $_POST['comment']);
      }
    }
  } // end of member function submit



  protected function body( )
  {
    $used_again = (isset($_POST['next']) && $_POST['next']=='again');
  
    echo '
      <form id="submit" action="?page=submit&amp;submit=yes" method="post" style="width: 700px;">
        <div>
          <h1 class="left">Step 1</h1><h1>&nbsp;Tested software</h1>
          <ul>
            <li style="float: left;">
              <label for="type">Type:</label><br />
              <select name="type" id="type">
                <option value="app" selected="selected">Application</option>
                <option value="dll">DLL-Library</option>
                <option value="drv">Driver</option>
                <option value="oth">Other</option>
              </select>
            </li>

            <li style="float: left;">
              <label for="title">Name:</label><br />
              <input type="text" name="title" id="title" onkeyup="'."suggestName(this.value);".'" />
              <div class="suggestion" id="suggestedNames" style="display:none;"></div>
            </li>

            <li style="float: left;">
              <label for="version">Version:</label><br />
              <input type="text" name="version" id="version" style="width: 50%;" />
              <div class="suggestion" id="suggestedVersions" style="display:none;"></div>
            </li>

            <li style="clear: both;float: left;">
              <label for="cat">Category:</label><br />
              <select name="cat" id="cat" style="width: 200px;">
                <option value="0">&nbsp</option>
                '.Category::showTreeAsOption().'
              </select>
            </li>
            <li style="float:left;">
              <label for="description">Short Description:</label><br />
              <input type="text" name="description" id="description" />
            </li>

            <li style="clear: both;">
              <label for="tags">Tags: (e.g. vendor)</label><br />
              <input type="text" name="tags" id="tags" /> (seperate them by <em>,</em>)
            </li>

          </ul>
          <br style="clear: both;"/>
        </div>
  
        <div>
          <h1 class="left">Step 2</h1><h1>&nbsp;Test summary</h1>
          <ul style="float:left;margin-right: 20px;">
            <li>
              <span class="label">Outcome:</span><br />
              <input type="radio" class="normal" name="status" id="works" value="full" onchange="'."javascript:document.getElementById('bugreport').style.display=(this.checked ? 'none' : 'block' );".'" />
              <label for="works" class="stable">Running Stable</label>
              
              <input type="radio" class="normal pworks" name="status" id="partworks" value="part" onchange="'."javascript:document.getElementById('bugreport').style.display=(this.checked ? 'none' : 'block' );".'" />
              <label for="partworks" class="unstable">Minor Problems</label>
              
              <input type="radio" class="normal crash" name="status" id="noworks" value="not" onchange="'."javascript:document.getElementById('bugreport').style.display=(this.checked ? 'block' : 'none' );".'" />
              <label for="noworks" class="crash">Crash</label>
              <br />
              <br />
            </li>
            <li style="float: left;">
              <label for="ver">Tested Version</label><br />
              <select name="ver" id="ver" onchange="'."javascript:document.getElementById('directRev').style.display=(this.value=='R' ? 'block' : 'none' );".'">
                <option value="R"'.(($used_again && $_POST['ver'] == 'R') ? ' selected="selected"' : '').'>Trunk</option>';

    $stmt=CDBConnection::getInstance()->prepare("SELECT revision, name FROM ".CDBT_VERTAGS." WHERE VISIBLE IS TRUE ORDER BY revision DESC");
    $stmt->execute();
    $x = 0;
    while ($version = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      ++$x;
      echo '
        <option value="'.$version['revision'].'"'.((($used_again && $_POST['ver'] == $version['revision']) || (!$used_again && $x===1)) ? ' selected="selected"' : '').'>'.$version['name'].'</option>';
    }
    echo '
              </select>
            </li>

            <li id="directRev" style="float:left;">
              <label for="rev">Revision:</label><br />
              <input type="text" name="rev" id="rev"'.(($used_again && $_POST['ver'] == 'R') ? ' value="'.htmlspecialchars($_POST['revision']).'"' : '').' />
            </li>
          </ul>
          <div style="float: left;margin-right: 10px;">
            <span class="label">Environment:</span><br />
            <input type="radio" class="normal" name="env" id="envvm" value="VM" checked="checked" onchange="'."javascript:document.getElementById('vmlist').style.display=(this.checked ? 'block' : 'none' );".'" />
            <label class="normal" for="envvm">Virtual Machine</label><br />

            <input type="radio" class="normal" name="env" id="envrh" value="RH" onchange="'."javascript:document.getElementById('vmlist').style.display=(this.checked ? 'none' : 'block' );".'" />
            <label class="normal" for="envrh">Real Hardware</label>
          </div>
          <div id="vmlist" style="list-style-type: none;float: left;">
            <label for="vm">Virtual Machine:</label><br />
            <select id="vm" name="vm">
              <option>&nbsp;</option>
              <option value="Bo">Bochs</option>
              <option value="qe">Qemu</option>
              <option value="vb">VirtualBox</option>
              <option value="vp">VirtualPC</option>
              <option value="vw">VMWare</option>
              <option value="ot">Other</option>
            </select>
            <br />
            <label for="vmver">VM Version:</label><br />
            <input type="text" name="vmver" id="vmver" />
          </div>
          <br style="clear: both;"/>
        </div>
  
        <div>
          <h1 class="left">Step 3</h1><h1>&nbsp;Test details</h1>
          <ul>
            <li>
              <label for="comment">Comment</label><br />
              <textarea rows="5" cols="70" name="comment" id="comment"></textarea>
            </li>
            <li>
              <span class="label">next action:</span><br />
              <input type="radio" class="normal" name="next" id="again" value="again" '.($used_again ? 'checked="checked"' : '').' />
              <label for="again" class="normal">Insert another entry/report</label>
              <br />
              <input type="radio" class="normal" name="next" id="more" value="more"  />
              <label for="more" class="normal">Add more information to that entry.</label>
              <br />
              <div id="bugreport">
                <input type="radio" class="normal" name="next" id="bug" value="bug"  />
                <label for="bug" class="normal">Fill a bug report</label>
                <br />
              </div>
              <input type="radio" class="normal" name="next" id="entry" value="entry" '.(!$used_again ? 'checked="checked"' : '').' />
              <label for="entry" class="normal">Jump to inserted entry/report</label>
            </li>
          </ul>
        </div>
        <div>
          <button type="submit">Submit report</button>
        </div>
        <hr style="color: #777;" />
      </form>
      <script type="text/javascript">
      //<!--'."
        document.getElementById('bugreport').style.display='none';
      //".'-->
      </script>';

    // hide revision field
    if (!$used_again || $_POST['ver'] != 'R') {
      echo '
          <script type="text/javascript">
          //<!--'."
            document.getElementById('directRev').style.display='none';
          //".'-->
          </script>';
    }

    // hide VM
    if ($used_again && $_POST['env'] == 'RH') {
      echo '
          <script type="text/javascript">
          //<!--'."
            document.getElementById('vmlist').style.display='none';
          //".'-->
          </script>';
    }
  } // end of member function body



} // end of HTML_Submit
?>
