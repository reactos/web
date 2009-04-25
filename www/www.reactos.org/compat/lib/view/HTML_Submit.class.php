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
    $this->header();
    $this->navigation();
    if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'yes') {
      $this->submit();
    }
    $this->body();
    $this->footer();
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
    if (isset($_POST['cat']) && isset($_POST['description'])) {
      $entry_id = Entry::add($_POST['title'], $_POST['version'], $_POST['cat'], $_POST['description'], $_POST['tags'], (isset($_POST['iCheck']) && $_POST['iCheck'] == 'yes'));
    }

    // search entry
    else {
      $entry_id = Entry::getId($_POST['title'], $_POST['version']);
    }
    
    // insert new report/comment
    if ($entry_id !== false) {
      Entry::addReport($entry_id, $revision, ($_POST['status']=='yes'));

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
      <form action="?page=submit&amp;submit=yes" method="post">
        <fieldset>
          <legend>App Details</legend>
          <ul style="list-style-type: none;">
            <li style="float: left;">
              <label for="title">Application Name:</label><br />
              <input type="text" name="title" id="title" onkeyup="suggestName(this.value);" />
              <div id="suggestedNames" style="display:none;border: 1px solid red;"></div>
            </li>

            <li style="float: right;">
              <label for="version">Version:</label><br />
              <input type="text" name="version" id="version" />
              <div id="suggestedVersions" style="display:none;border: 1px solid red;"></div>
            </li>

            <li style="clear: both;">
              <fieldset>
                <legend>
                  <input type="checkbox" name="iCheck" id="iCheck" value="yes" onclick="toggleDetails();" />
                  <label for="iCheck">I don\'t want to modify the additional information</label>
                </legend>
                <ul style="list-style-type: none;">
                  <li>
                    <label for="cat">Category:</label><br />
                    <select name="cat" id="cat">
                      <option value="0">&nbsp</option>
                      '.Category::showTreeAsOption().'
                    </select>
                  </li>
                  <li>
                    <label for="description">Short Description:</label><br />
                    <input type="text" name="description" id="description" />
                  </li>

                  <li style="display:none;">
                    <label for="tags">Tags: (seperate them by <em>,</em>)</label><br />
                    <input type="text" name="tags" id="tags" />
                  </li>
                </ul>
            </li>

          </ul>
        </fieldset>
  
        <fieldset>
          <legend>Test</legend>
          <ul style="list-style-type: none;">
            <li>
              Status:<br />
              <input type="radio" name="status" id="noworks" value="no" />
              <label for="noworks" style="color: red;">Doesn\'t Work</label>
              <br />
              <input type="radio" name="status" id="doesn\'t work" value="yes" />
              <label for="works" style="color: green;">Works</label>
              <br />
              <br />
            </li>
            <li>
              <label for="ver">Tested Version</label><br />
              <select name="ver" id="ver">
                <option value="R"'.(($used_again && $_POST['ver'] == 'R') ? ' selected="selected"' : '').'>Use Revision</option>';

    $stmt=CDBConnection::getInstance()->prepare("SELECT revision, name FROM ".CDBT_VERSIONS." WHERE VISIBLE IS TRUE ORDER BY revision DESC");
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

            <li>
              <label for="rev">Tested Revision (only trunk revisions are allowed, please don\'t enter revisions of tags or branches)</label><br />
              <input type="text" name="rev" id="rev"'.(($used_again && $_POST['ver'] == 'R') ? ' value="'.htmlspecialchars($_POST['revision']).'"' : '').' />
            </li>
          </ul>
        </fieldset>
  
        <fieldset>
          <legend>Additional</legend>
          <ul style="list-style-type: none;">
            <li>
              <label for="comment">Comment</label><br />
              <textarea rows="6" cols="80" name="comment" id="comment"></textarea>
            </li>
            <li>
              next action:<br />
              <input type="radio" name="next" id="again" value="again" '.($used_again ? 'checked="checked"' : '').' />
              <label for="again">Insert another entry/report</label>
              <br />
              <input type="radio" name="next" id="entry" value="entry" '.(!$used_again ? 'checked="checked"' : '').' />
              <label for="entry">Jump to inserted entry/report</label>
            </li>
          </ul>
        </fieldset>
        <div>
          <button type="submit">Submit new Compatibility Report</button>
        </div>
      </form>';
  } // end of member function body



} // end of HTML_Submit
?>
