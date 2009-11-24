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

  private $submit_error = false;
  private $submit_msg = null;


  public function __construct( )
  {
    global $RSDB_intern_user_id;


    $this->register_js('submit.js');
    $this->register_js('compat.js');

    // check if user is logged in
    $RSDB_intern_user_id = Subsystem::in(Login::REQUIRED, $_SERVER["REQUEST_URI"]);

    // was a new entry submitted
    if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'yes') {
      $this->submit_error = !$this->submit();
    }

    // check next action for adding new entry
    if ($this->submit_error && isset($_POST['next']) && $_POST['next'] == 'entry') {
      $entry_id = Entry::getEntryId($_POST['cat'], $_POST['title']);
      $version_id = Entry::getVersionId($entry_id, $_POST['version']);
      if ($entry_id !== false && $version_id !== false) {
        header('location: ?show=version&id='.$version_id);
      }
    }

    // checking next action for adding bug report
    elseif ($this->submit_error && isset($_POST['next']) && $_POST['next'] == 'bug') {
      $entry_id = Entry::getEntryId($_POST['cat'], $_POST['title']);
      $version_id = Entry::getVersionId($entry_id, $_POST['version']);
      if ($entry_id !== false && $version_id !== false) {
        header('location: http://www.reactos.org/wiki/File_Bugs');
      }
    }

    parent::__construct();
  }


  private function submit( )
  {
    // get used revision number
    if ($_POST['ver'] == 'R') {
      // for trunk revisions
      $revision = $_POST['rev'];
    }
    else {
      // for available release versions
      $revision = $_POST['ver'];
    }

    // check if revision is valid number
    if (!preg_match('/^[1-9][0-9]*$/',$revision)) {
      $this->submit_msg = 'No valid Revision. A valid revision only consists of digits.';
      return false;
    }

    // try to insert/update a new entry
    if (empty($_POST['title'])) {
      $this->submit_msg = 'You need to enter a valid name.';
      return false;
    }

    if (empty($_POST['version'])) {
      $this->submit_msg = 'You need to enter a valid version name.';
      return false;
    }
    
    if (empty($_POST['cat'])) {
      $this->submit_msg = 'You need to enter a valid category.';
      return false;
    }

    $ids = Entry::add($_POST['title'], $_POST['version'], $_POST['cat'], $_POST['description']);

    // got no error
    if ($ids !== false) {
      $entry_id = $ids['entry'];
      $version_id = $ids['version'];
    }

    // we need an entry and version id
    if (empty($entry_id)) {
      $entry_id = Entry::getEntryId($_POST['cat'], $_POST['title']);
    }
    if (empty($version_id)) {
      $version_id = Entry::getVersionId($entry_id, $_POST['version']);
    }

    // check if we have an existing entry now
    if ($entry_id === false) {
      $this->submit_msg = 'No entry was found/could be added.';
      return false;
    }
    if ($version_id === false) {
      $this->submit_msg = 'No entry version was found/could be added.';
      return false;
    }

    // add tags
    if (!empty($_POST['tags'])) {
      $tags = explode(',', $_POST['tags']);
      foreach ($tags as $tag) {
        Entry::addOrAssignTag($entry_id, trim($tag));
      }
    }

    // insert new comment
    if (isset($_POST['comment']) && $_POST['comment'] != '') {
      $comment_id = Entry::addComment($entry_id, 'test of r'.$revision, $_POST['comment']);
    }
    else {
      $comment_id = 0;
    }

    // new report
    if (isset($_POST['status']) && ($_POST['status'] == 'full' || $_POST['status'] == 'part' ||$_POST['status'] == 'crash' ||$_POST['status'] == 'not')) {
      if ($_POST['env'] == 'RH') {
        $env = 'RH';
        $env_ver = $_POST['vmver'];
      }
      else {
        $env = $_POST['vm'];
        $env_ver = $_POST['vmver'];
      }

      Entry::addReport($entry_id, $version_id, $comment_id, $revision, $env, $env_ver, $_POST['status']);
    }

    $this->submit_msg = 'Submit was successful.';
    return true;
  } // end of member function submit



  protected function body( )
  {
    $used_again = (isset($_POST['next']) && $_POST['next']=='again');


    // preselect entry (usually for new test report) step 1
    if (isset($_GET['version']) && $_GET['version'] > 0) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT e.id, e.name, v.version, e.category_id, e.description, '' AS outcome FROM ".CDBT_ENTRIES." e JOIN ".CDBT_VERSIONS." v ON v.entry_id=e.id  WHERE v.id=:version_id");
      $stmt->bindParam('version_id',$_GET['version'],PDO::PARAM_INT);
      $stmt->execute();
      $entry = $stmt->fetchOnce(PDO::FETCH_ASSOC);
      
      // get tags
      if ($entry !== false) {
        $entry['tags'] = '';
        $stmt=CDBConnection::getInstance()->prepare("SELECT name FROM ".CDBT_TAGS." t JOIN ".CDBT_TAGGED." r ON t.id=r.tag_id WHERE r.entry_id=:entry_id");
        $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
        $stmt->execute();
        while ($tag = $stmt->fetch(PDO::FETCH_ASSOC)) {
          if ($entry['tags'] != '') $entry['tags'] .= ',';
          $entry['tags'] .= $tag['name'];
        }
      }
    }

    // no preselection, provide standard values
    if (empty($entry)) {
      $entry = array(
        'name' => '',
        'version' => '',
        'category_id' => null,
        'description' => '',
        'tags' => '',
        'outcome' => '');
    }

    if ($this->submit_error) {
      $used_again = true;
      $entry = array(
        'name' => $_POST['title'],
        'version' => $_POST['version'],
        'category_id' => $_POST['cat'],
        'description' => $_POST['description'],
        'tags' => $_POST['tags'],
        'outcome' => (isset($_POST['status']) ? $_POST['status'] : ''));
    }

    // set error fields
    $error_title = empty($_POST['title']) && $this->submit_error;
    $error_version = empty($_POST['version']) && $this->submit_error;
    $error_cat = empty($_POST['cat']) && $this->submit_error;
    $error_release = !empty($_POST['status']) && empty($_POST['ver']) && $this->submit_error;
    $error_trunk = !empty($_POST['status']) && empty($_POST['rev']) && isset($_POST['ver']) && $_POST['ver'] === 'R' && $this->submit_error;

    // preferences
    $revision_type = Setting::getPreference('revision_type');

    // get reusable values
    if ($used_again) {
      $tested_version = $_POST['ver'];
      $tested_vm = $_POST['vm'];
      $tested_env = $_POST['env'];
      $tested_env_details = $_POST['vmver'];
      $tested_rev = $_POST['rev'];
    }
    
    // form is not reused, for get preferences as standard values
    else {
      if ($revision_type == 'trunk') {
        $tested_version = 'R';
      }
      else {
        $tested_version = '';
      }
  
      $tested_vm = Setting::getPreference('environment');
      $tested_env = (Setting::getPreference('environment') != 'RH' ? 'VM' : 'RH');
      $tested_env_details = Setting::getPreference('environment_details');
      $tested_rev = '';
    }

    echo '
      <form id="submit" action="?show=submit&amp;submit=yes" method="post" style="width: 700px;">';

    // print message if 
    if ($this->submit_msg !== null) {
      echo '<div class="'.($this->submit_error ? 'error' : 'success').'">'.htmlspecialchars($this->submit_msg).'</div>';
    }

    echo '
        <div style="padding-bottom:10px;">
          <h1 class="left">Step 1</h1><h1>&nbsp;Tested subject</h1>
          <ul>

            <li style="float: left;">
              <label for="title"'.($error_title ? ' class="error"' : '').'>Name:</label><br />
              <input type="text" name="title" id="title" onkeyup="'."suggestName(this.value);".'" maxlength="100" value="'.htmlspecialchars($entry['name']).'"/>
              <div class="suggestion" id="suggestedNames" style="display:none;"></div>
            </li>
            <li style="float: left;">
              <label for="version"'.($error_version ? ' class="error"' : '').'>Version:</label><br />
              <input type="text" name="version" id="version" style="width: 75%;" maxlength="100" value="'.htmlspecialchars($entry['version']).'" />
              <div class="suggestion" id="suggestedVersions" style="display:none;"></div>
            </li>
            <li style="float: left;">
              <label for="cat"'.($error_cat ? ' class="error"' : '').'>Category:</label><br />
              <select name="cat" id="cat" style="width: 200px;">
                <option value="0">&nbsp;</option>
                '.Category::showTreeAsOption($entry['category_id']).'
              </select>
            </li>

            <li style="clear: both;float:left;">
              <label for="description">Short Description:</label><br />
              <input type="text" style="width:350px;" name="description" id="description" value="'.htmlspecialchars($entry['description']).'" />
            </li>
            <li style="float: left;">
              <label for="tags">Tags: (e.g. vendor)</label><br />
              <input type="text" name="tags" id="tags" value="'.htmlspecialchars($entry['tags']).'" /> (seperate them by <em>,</em>)
            </li>

          </ul>
          <br style="clear: both;"/>
        </div>
  
        <div>
          <h1 class="left">Step 2</h1><h1>&nbsp;Test summary</h1>
          <ul style="float:left;margin-right: 20px;">
            <li>
              <label for="status">Outcome:</label><br />
              <select name="status" id="status">
                <option></option>
                <option class="stable" value="full"'.($entry['outcome']=='full' ? ' selected="selected"':'').' title="runs correctly without major problems">Running stable</option>
                <option class="unstable" value="part"'.($entry['outcome']=='part' ? ' selected="selected"':'').'>Running with problems</option>
                <option class="nonwork" value="not"'.($entry['outcome']=='not' ? ' selected="selected"':'').' title="doesn\'t start or has no effect">Not working</option>
                <option class="crash" value="crash"'.($entry['outcome']=='crash' ? ' selected="selected"':'').' title="Prevents ReactOS from working or initiates a BSOD">Crash</option>
              </select>
              <br />
              <br />
            </li>
            <li style="float: left;"'.($error_release ? ' class="error"' : '').'>
              <label for="ver">Tested Version</label><br />
              <select name="ver" id="ver" style="width:150px;" onchange="'."javascript:document.getElementById('directRev').style.display=(this.value=='R' ? 'block' : 'none' );".'">';

    if ($revision_type != 'release') {
      echo '
        <option value="R"'.(($tested_version == 'R') ? ' selected="selected"' : '').'>Trunk</option>';
    }

    //
    if ($revision_type != 'trunk') {

      $stmt=CDBConnection::getInstance()->prepare("SELECT revision, name FROM ".CDBT_VERTAGS." WHERE VISIBLE IS TRUE ORDER BY revision DESC");
      $stmt->execute();
      $x = 0;
      while ($version = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        ++$x;
        echo '
          <option value="'.$version['revision'].'"'.((($tested_version == $version['revision']) || (!$used_again && $x===1)) ? ' selected="selected"' : '').'>'.$version['name'].'</option>';
      }
    }
    echo '
              </select>
            </li>

            <li id="directRev" style="float:left;display:'.($tested_version == 'R' ? 'block' : 'none').';">
              <label for="rev"'.($error_trunk ? ' class="error"' : '').'>Revision:</label><br />
              <input type="text" name="rev" id="rev" maxlength="6" value="'.$tested_rev.'" />
            </li>
          </ul>
          <div style="float: left;margin-right: 10px;">
            <span class="label">Environment:</span><br />
            <input type="radio" class="normal" name="env" id="envvm" value="VM"'.(($tested_env=='VM') ? ' checked="checked"' : '').' onchange="'."javascript:document.getElementById('vmselect').style.display=(this.checked ? 'block' : 'none' );javascript:document.getElementById('vmverlabel').innerHTML='Version/Specs:';".'" />
            <label class="normal" for="envvm">Virtual Machine</label><br />

            <input type="radio" class="normal" name="env" id="envrh" value="RH"'.(($tested_env=='RH') ? ' checked="checked"' : '').' onchange="'."javascript:document.getElementById('vmselect').style.display=(this.checked ? 'none' : 'block' );javascript:document.getElementById('vmverlabel').innerHTML='Specs:';".'" />
            <label class="normal" for="envrh">Real Hardware</label>
          </div>
          <div id="vmlist" style="list-style-type: none;float: left;">
            <div id="vmselect">
              <label for="vm">Virtual Machine:</label><br />
              <select id="vm" name="vm">
                <option value="ot"'.(($tested_vm=='ot') ? ' selected="selected"' : '').'>Other</option>
                <option value="Bo"'.(($tested_vm=='Bo') ? ' selected="selected"' : '').'>Bochs</option>
                <option value="qe"'.(($tested_vm=='qe') ? ' selected="selected"' : '').'>Qemu</option>
                <option value="vb"'.(($tested_vm=='vb') ? ' selected="selected"' : '').'>VirtualBox</option>
                <option value="vp"'.(($tested_vm=='vp') ? ' selected="selected"' : '').'>VirtualPC</option>
                <option value="vw"'.(($tested_vm=='vw') ? ' selected="selected"' : '').'>VMWare</option>
              </select>
            </div>
            <br />
            <label for="vmver" id="vmverlabel">Version/Specs:</label><br />
            <input type="text" name="vmver" id="vmver" maxlength="100" style="width: 150px;" value="'.$tested_env_details.'" />
          </div>
          <br style="clear: both;"/>
        </div>
  
        <div>
          <h1 class="left">Step 3</h1><h1>&nbsp;Test details</h1>
          <ul>
            <li>
              <label for="comment">Comment</label><br />
              <textarea rows="5" cols="70" name="comment" id="comment">'.((isset($_POST['comment']) && !used_again) ? $_POST['comment'] : '').'</textarea>
            </li>
            <li>
              <span class="label">Next action:</span><br />
              <input type="radio" class="normal" name="next" id="again" value="again" '.($used_again && !($entry['outcome'] == 'part' || $entry['outcome'] == 'not') ? 'checked="checked"' : '').' />
              <label for="again" class="normal">Insert another entry/report</label>
              <br />
              <div id="bugreport">
                <input type="radio" class="normal" name="next" id="bug" value="bug" '.(($entry['outcome'] == 'part' || $entry['outcome'] == 'not') ? 'checked="checked"' : '').'  />
                <label for="bug" class="normal">Fill a bug report</label>
                <br />
              </div>
              <input type="radio" class="normal" name="next" id="entry" value="entry" '.(!$used_again && !($entry['outcome'] == 'part' || $entry['outcome'] == 'not') ? 'checked="checked"' : '').' />
              <label for="entry" class="normal">Jump to inserted entry/report</label>
            </li>
          </ul>
        </div>
        <div>
          <button type="submit">Submit report</button>
        </div>
        <hr style="color: #777;" />
      </form>';
      
    if ($entry['outcome'] != 'part' && $entry['outcome'] != 'crash' && $entry['outcome'] != 'not') {
      echo '
        <script type="text/javascript">
        //<!--'."
          document.getElementById('bugreport').style.display='none';
        //".'-->
        </script>';
    }

    // hide revision field
    if ($tested_version != 'R') {
      echo '
          <script type="text/javascript">
          //<!--'."
            document.getElementById('directRev').style.display='none';
          //".'-->
          </script>';
    }

    // hide VM
    if ($tested_env == 'RH') {
      echo '
          <script type="text/javascript">
          //<!--'."
            document.getElementById('vmselect').style.display='none';
            document.getElementById('vmverlabel').innerHTML='Specs:';
          //".'-->
          </script>';
    }
  } // end of member function body



} // end of HTML_Submit
?>
