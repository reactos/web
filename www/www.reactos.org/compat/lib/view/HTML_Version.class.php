<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2009 Danny Gˆtte <dangerground@web.de>

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


class HTML_Version extends HTML
{

  const SIDE_TESTS       = 1;
  const SIDE_SCREENSHOTS = 2;
  const SIDE_STATS       = 3;

  const MAIN_TESTS       = 100;
  const MAIN_SCREENSHOTS = 101;
  const MAIN_COMMENTS    = 102;
  const MAIN_BUGS        = 103;
  
  private $side = null;
  private $main = null;
  private $entry_id = null;
  private $entry_type = null;


  public function __construct()
  {

    // get entry_id
    $stmt=CDBConnection::getInstance()->prepare("SELECT entry_id FROM ".CDBT_VERSIONS." WHERE id=:version_id");
    $stmt->bindParam('version_id',$_GET['id'],PDO::PARAM_INT);
    $stmt->execute();
    $this->entry_id = $stmt->fetchColumn();

    // get entry_type
    $stmt=CDBConnection::getInstance()->prepare("SELECT type FROM ".CDBT_ENTRIES." WHERE id=:entry_id");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $this->entry_type = $stmt->fetchColumn();

    // ajax only needs the content, no decoration around it
    if (isset($_GET['direct'])) {

      // side
      if (isset($_GET['side'])) {
        switch ($_GET['side']) {
          case 'screens':
            $this->side = self::SIDE_SCREENSHOTS;
            $this->sideScreenshots();
            break;
          case 'stats':
            $this->side = self::SIDE_STATS;
            $this->sideStats();
            break;
        }
      }

      // main
      if (isset($_GET['main'])) {
        switch ($_GET['main']) {
          case 'tests':
            $this->main = self::MAIN_TESTS;
            $this->mainTests();
            break;
          case 'bugs':
            $this->main = self::MAIN_BUGS;
            $this->mainBugs();
            break;
          case 'screens':
            $this->main = self::MAIN_SCREENSHOTS;
            $this->mainScreenshots();
            break;
          case 'comments':
            $this->main = self::MAIN_COMMENTS;
            $this->mainComments();
            break;
        }
      }
    }
    else {
      $this->register_js('compat.js');
      parent::__construct();
    }
  }



  protected function body()
  {
    if (isset($_GET['view']) && $_GET['view'] == 'dev') {
      $this->side = self::SIDE_TESTS;
      $this->main = self::MAIN_TESTS;
    }
    elseif (isset($_GET['view']) && $_GET['view'] == 'screen') {
      $this->side = self::SIDE_STATS;
      $this->main = self::MAIN_SCREENSHOTS;
    }
    elseif(isset($_GET['view']) && $_GET['view'] == 'pref') {
      $this->side = $_GET['pside'];
      $this->main = $_GET['pmain'];
    }
    else {
      
      $vertab_prem = Setting::getPreference('vertab_prem');
      $vertab_pres = Setting::getPreference('vertab_pres');

      // default side
      switch ($vertab_pres) {
        case 'stats':
          $this->side = self::SIDE_STATS;
          break;
        default:
        case '':
          $this->side = self::SIDE_SCREENSHOTS;
          break;
      }

      // default main
      switch ($vertab_prem) {
        case 'screens':
          $this->main = self::MAIN_SCREENSHOTS;
          break;
        case 'tests':
          $this->main = self::MAIN_TESTS;
          break;
        case 'bugs':
          $this->main = self::MAIN_BUGS;
          break;
        default:
        case '':
          $this->main = self::MAIN_COMMENTS;
          break;
      }
    }
   
    echo '<h1>Compatability Database &gt; Entry Details</h1>';

    // check if entry exists
    if ($this->entry_id !== false)
    {
    
      echo '
        <div id="entryTop">
          <div id="entrySide">
        <ul class="entryNavigation">';
    
      if ($this->entry_type == 'App') {
        echo '
        <li id="entrySideScreenshots" '.($this->side == self::SIDE_SCREENSHOTS ? ' class="active"' : '').'><a href="'.$this->buildLink(null, self::SIDE_SCREENSHOTS).'"onclick="'."return ViewTabSide(".$_GET['id'].",'screens');".'">Screenshots</a></li>';
      }

      echo '
        <li id="entrySideStats"'.($this->side == self::SIDE_STATS ? ' class="active"' : '').'><a href="'.$this->buildLink(null, self::SIDE_STATS).'" onclick="'."return ViewTabSide(".$_GET['id'].",'stats');".'">Statistics</a></li>
      </ul>
        <div id="sideContent">';
        
      // top right
      switch ($this->side) {
        case self::SIDE_SCREENSHOTS:
        default:
          if ($this->entry_type == 'App') {
            $this->sideScreenshots();
            break;
          }
        case self::SIDE_STATS:
          $this->sideStats();
          break;
        case self::SIDE_TESTS:
          $this->sideTests();
          break;
      }
      echo '
        </div>';

      echo '</div>'; // end side
      
      $this->details();
      
      echo '
        </div>
        <ul class="entryNavigation">
          <li id="naviMainComments"'.($this->main == self::MAIN_COMMENTS ? ' class="active"' : '').'>
            <a href="'.$this->buildLink(self::MAIN_COMMENTS,null).'" onclick="'."return ViewTabMain(".$_GET['id'].",'comments');".'">Comments</a>
          </li>
          <li id="naviMainTests"'.($this->main == self::MAIN_TESTS ? ' class="active"' : '').'>
            <a href="'.$this->buildLink(self::MAIN_TESTS,null).'" onclick="'."return ViewTabMain(".$_GET['id'].",'tests');".'">Tests</a>
          </li>
          <li id="naviMainBugs"'.($this->main == self::MAIN_BUGS ? ' class="active"' : '').'>
            <a href="'.$this->buildLink(self::MAIN_BUGS,null).'" onclick="'."return ViewTabMain(".$_GET['id'].",'bugs');".'">Bugs</a>
          </li>';

      if ($this->entry_type == 'App') {
        echo '
          <li id="naviMainScreenshots"'.($this->main == self::MAIN_SCREENSHOTS ? ' class="active"' : '').'>
            <a href="'.$this->buildLink(self::MAIN_SCREENSHOTS,null).'"  onclick="'."return ViewTabMain(".$_GET['id'].",'screens');".'">Screenshots</a>
          </li>';
      }

      echo '
        </ul>
        <div id="entryMain">';

      // main information
      switch ($this->main) {
          
        // test reports
        case self::MAIN_TESTS:
          $this->mainTests();
          break;
          
        // bug reports from bugzilla
        case self::MAIN_BUGS:
          $this->mainBugs();
          break;
      
        // screenshots
        case self::MAIN_SCREENSHOTS:
          if ($this->entry_type == 'App') {
            $this->mainScreenshots();
            break;
          }
          
        // comments
        case self::MAIN_COMMENTS:
        default:
          $this->mainComments();
          break;
      }
    }

    // no entry found
    else
    {
      echo '<strong>Entry not found.</strong>';
    }
  } // end of member function body
  
  
  
  private function buildLink($main=null, $side=null)
  {
    return '?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pside='.($side !== null ? $side : $this->side).'&amp;pmain='.($main !== null ? $main : $this->main);
  }
  
  
  
  private function mainComments()
  {
    global $RSDB_intern_loginsystem_fullpath;
    global $RSDB_intern_user_id;
  
    if ($this->entry_id > 0 && isset($_POST['comment_content']) && strlen(trim($_POST['comment_content'])) > 0 && $RSDB_intern_user_id > 0) {
      Entry::addComment($this->entry_id, '',$_POST['comment_content'],$_POST['reply']);
    }
    elseif (isset($_GET['deleteComment']) && $_GET['deleteComment'] > 0 && Setting::hasRight('delete_comments')) {
      if (Entry::deleteComment($_GET['deleteComment'])) {
        echo 'Comment was deleted successful<br />';
      }
      else {
        echo 'Problem while deleting comment<br />';
      }
    }
  
      
    if ($RSDB_intern_user_id > 0) {
      echo '
        <form action="" method="post">
          <fieldset>
            <input type="hidden" name="reply" id="reply" value="'.(isset($_GET['replyComment']) ? $_GET['replyComment'] : '').'" />
            <label for="comment_content">'.(isset($_GET['replyComment']) ? 'Answer to highlighted comment:' : 'New comment').'</label><br />
            <textarea name="comment_content" id="comment_content" rows="6" cols="80"></textarea><br />
            <button type="submit">Submit</button>
          </fieldset>
        </form>';
    }
    else {
      echo 'To add comments, you need to login with your RosCMS account.';
    }

    $stmt=CDBConnection::getInstance()->prepare("SELECT c.id, c.title, c.content, c.parent, c.created, c.user_id, r.works, IF(o.revision IS NULL,CONCAT('r',r.revision),o.name) AS rosversion FROM ".CDBT_COMMENTS." c LEFT JOIN ".CDBT_REPORTS." r ON r.comment_id=c.id LEFT JOIN ".CDBT_VERTAGS." o ON o.revision=r.revision WHERE c.entry_id=:entry_id ORDER BY c.created DESC");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $comments=$stmt->fetchAll(PDO::FETCH_ASSOC);
      
    if (count($comments) > 0) {
      foreach ($comments as $comment) {
        echo '
          <div style="background-color: white;margin: 10px 3px 3px 3px; border: 1px solid lightgray;padding:10px;'.(isset($_GET['replyComment']) && $_GET['replyComment'] == $comment['id'] ? 'background-color:lightblue;' : '').'">
          <a id="comm'.$comment['id'].'"></a>';
          
        if (!empty($comment['works'])) {
          echo '
            <h3>
              <div style="width:1.5em;float:left;margin-right:1em;" class="'.($comment['works'] == 'full' ? 'stable' : ($comment['works'] == 'part' ? 'unstable' : 'crash')).'">&nbsp;</div>
              '.$comment['rosversion'].'
            </h3>';
        }
        elseif ($comment['parent'] > 0) {
          echo '
            <h3>
              In reply <a href="#comm'.$comment['parent'].'">to</a>
            </h3>';
        }
        
        echo nl2br(htmlspecialchars($comment['content'])).'
            <br />
            <div style="color: gray;margin-top: 1em;">by <strong>'.Subsystem::getUserName($comment['user_id']).'</strong> on '.$comment['created'];
        
        if ($RSDB_intern_user_id > 0) {
          echo ' <a href="'.$this->buildLink(self::MAIN_COMMENTS, null).'&amp;replyComment='.$comment['id'].'">reply</a>';
        }
        if (Setting::hasRight('delete_comments')) {
          echo ' <a style="float:right;" onclick="'."return confirm('are you sure?');".'" href="'.$this->buildLink(self::MAIN_COMMENTS, null).'&amp;deleteComment='.$comment['id'].'">delete</a>';
        }
        echo '
            </div>
          </div>';
      }
    }
    else {
      echo 'There are no comments submitted yet.';
    }

  } // end of member function mainComments



  private function mainScreenshots()
  {
    // hide from non app entries
    if ($this->entry_type == 'App') {
      global $RSDB_intern_user_id;
      global $CDB_upload_path_web;

      if (isset($_GET['scrid']) && $_GET['scrid'] > 0) {
        $stmt=CDBConnection::getInstance()->prepare("SELECT user_id, created, file, description FROM ".CDBT_ATTACHMENTS." WHERE type = 'picture' AND id=:screenshot_id AND visible IS TRUE LIMIT 1");
        $stmt->bindParam('screenshot_id',$_GET['scrid'],PDO::PARAM_INT);
        $stmt->execute();
        $screenshot = $stmt->fetchOnce(PDO::FETCH_ASSOC);

        echo '
          <span>Screenshot:</span><br />
          <img src="'.$CDB_upload_path_web.$screenshot['file'].'" alt="screenshot" /><br />
          <span>Description:</span>
          <div>'.$screenshot['description'].'</div><br />
          <span>Submitted on:</span>'.$screenshot['created'].'<br />
          <span>Submitted by:'.CUser::getName($screenshot['user_id']).'</span>';
      }
      else {
        if ($this->entry_id > 0 && isset($_FILES['shot']) && $RSDB_intern_user_id > 0) {
          Entry::addScreenshot($this->entry_id, 'shot');
        }
      
        $stmt=CDBConnection::getInstance()->prepare("SELECT id, file, description FROM ".CDBT_ATTACHMENTS." WHERE type = 'picture' AND entry_id=:entry_id AND visible IS TRUE LIMIT 20 OFFSET 0");
        $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
        $stmt->execute();
        $screenshots = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
          
        if ($RSDB_intern_user_id > 0) {
          echo '
            <form action="" method="post" enctype="multipart/form-data">
              <fieldset>
                <label for="shot">screenshot(jpg,png)</label>
                <input type="file" name="shot" id="shot" />
                <br />
                <label for="description">description</label>
                <input type="text" name="description" id="description" />
                <br />
                <button type="submit">Upload</button>
              </fieldset>
            </form>
            <hr />';
        }
        else {
          echo 'To add screenshots, you need to login with your RosCMS account.<hr />';
        }

        if (count($screenshots) > 0) {
          foreach ($screenshots as $screenshot) {
          echo '
            <div class="screenshot">
              <a href="'.$this->buildLink(self::MAIN_SCREENSHOTS, null).'&amp;scrid='.$screenshot['id'].'">
                <img src="'.$CDB_upload_path_web.'th/'.$screenshot['file'].'" alt="screenshot" title="'.htmlspecialchars($screenshot['description']).'" />
              </a>
            </div>';
          }
        }
      }
    }
  } // end of member function mainScreenshots



  private function mainTests()
  {
    if (isset($_GET['deleteReport']) && $_GET['deleteReport'] > 0 && Setting::hasRight('delete_tests')) {
      if (Entry::deleteReport($_GET['deleteReport'])) {
        echo 'Test report was deleted successful.<br />';
      }
      else {
        echo 'Problem while deleting test report.<br />';
      }
    }
  
  
    $revision_type = Setting::getPreference('revision_type');
    if (!empty($revision_type)) {
      if ($revision_type == 'trunk') {
        $not = "";
      }
      else {
        $not = "NOT";
      }
      
      $stmt=CDBConnection::getInstance()->prepare("SELECT t.id, user_id, t.revision, works, t.comment_id, environment, environment_version, created, v.name AS releasename FROM ".CDBT_REPORTS." t LEFT JOIN ".CDBT_VERTAGS." v ON v.revision=t.revision WHERE version_id = :version_id AND v.revision IS ".$not." NULL AND t.visible IS TRUE AND t.disabled IS FALSE ORDER BY t.revision DESC, created DESC");
    }
    else {
      $stmt=CDBConnection::getInstance()->prepare("SELECT t.id, user_id, t.revision, works,t.comment_id, environment, environment_version, created, v.name AS releasename FROM ".CDBT_REPORTS." t LEFT JOIN ".CDBT_VERTAGS." v ON v.revision=t.revision WHERE version_id = :version_id AND t.visible IS TRUE AND t.disabled IS FALSE ORDER BY t.revision DESC, created DESC");
    }
    $stmt->bindParam('version_id', $_GET['id'],PDO::PARAM_INT);
    $stmt->execute();
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($tests) > 0) {
        echo '
          <table class="rtable" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>&nbsp;</th>
                <th>Revision</th>
                <th>&nbsp;</th>
                <th>Environment</th>
                <th>User</th>
                <th>Date</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>';

        $x=0;
        foreach ($tests as $test) {
          echo '
            <tr class="row'.($x%2+1).'" onmouseover="highlightTableRow(this);">
              <td class="first '.($test['works'] == 'full' ? 'stable' : ($test['works'] == 'part' ? 'unstable' : 'crash')).'">&nbsp;</td>
              <td>'.($test['releasename'] != '' ? $test['releasename'] : $test['revision']).'</td>
              <td>';
            if ($test['comment_id'] > 0) {
              echo '<a href="'.$this->buildLink(self::MAIN_COMMENTS, null).'#comm'.$test['comment_id'].'">see comment</a>';
            }
            echo '</td>
              <td>';
          
          // is there a environment
          if ($test['environment'] != 'unkn') {
            switch ($test['environment']) {
              case 'RH':
                echo 'Real hardware';
                break;
              case 'vb':
                echo 'VirtualBox';
                break;
              case 'Bo':
                echo 'Bochs';
                break;
              case 'vp':
                echo 'VirtualPC';
                break;
              case 'vw':
                echo 'VMWare';
                break;
              case 'qe':
                echo 'QEMU';
                break;
              case 'ot':
                echo 'Other VM';
                break;
              default:
              case 'unkn':
                echo 'Unknown';
                break;
            } // end switch
            
            if ($test['environment_version'] != '') {
              echo ' ('.$test['environment_version'].')';
            }
          }
          echo '
              </td>
              <td>'.CUser::getName($test['user_id']).'</td>
              <td>'.$test['created'].'</td>
              <td>'.(Setting::hasRight('delete_tests') ? '<a href="'.$this->buildLink(null, null).'&amp;deleteReport='.$test['id'].'">delete</a>' : '').'</td>
            </tr>';
            
          $x++;
        } // end foreach
        
        echo '
            </tbody>
          </table>';
      }
      else {
        echo 'There are no tests submitted yet.';
      }
    
    echo '
        <a href="?show=submit&amp;version='.rawurlencode($_GET['id']).'">Submit Test</a>';
  } // end of member function mainScreenshots



  private function mainBugs()
  {
    global $RSDB_intern_user_id;
    
    // link bugs
    if (isset($_POST['bug']) && ctype_digit($_POST['bug']) && $RSDB_intern_user_id > 0) {
    
      // check if already exists
      $stmt=CDBConnection::getInstance()->prepare("SELECT 1 FROM ".CDBT_BUGS." WHERE version_id=:entry_id AND bug_id=:bug_id");
      $stmt->bindParam('entry_id',$_GET['id'],PDO::PARAM_INT);
      $stmt->bindParam('bug_id',$_POST['bug'],PDO::PARAM_STR);

      // insert new entry
      if ($stmt->execute() && $stmt->fetchColumn() === false) {
        $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_BUGS." (version_id, entry_id, bug_id) VALUES (:version_id, :entry_id, :bug_id)");
        $stmt->bindParam('version_id',$_GET['id'],PDO::PARAM_INT);
        $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
        $stmt->bindParam('bug_id',$_POST['bug'],PDO::PARAM_STR);
        $stmt->execute();
      }
    }
  
    // we need entry name to search in bugzilla
    $stmt=CDBConnection::getInstance()->prepare("SELECT name FROM ".CDBT_ENTRIES." WHERE id=:entry_id");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $entry_name=$stmt->fetchColumn();
    
    // and we also use linked bug numbers
    $stmt=CDBConnection::getInstance()->prepare("SELECT DISTINCT bug_id, short_desc, bug_status FROM bugs.bugs WHERE short_desc LIKE :entry_name OR bug_id IN(SELECT bug_id FROM ".CDBT_BUGS." WHERE entry_id=:entry_id) ORDER BY bug_id DESC");
    $stmt->bindValue('entry_name', '%'.$entry_name.'%', PDO::PARAM_STR);
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $bugs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // show input to link bugs
    if (isset($_REQUEST['link']) && $RSDB_intern_user_id > 0) {
      echo '
        <form action="" method="post">
          <fieldset>
            <label for="bug">#</label>
            <input type="text" name="bug" id="bug" />
            <button type="submit">Link to this entry</button>
          </fieldset>
        </form>';
    }

      if (count($bugs) > 0) {
        echo '<ul id="buglist">';
        foreach ($bugs as $bug) {
          echo '
            <li'.(($bug['bug_status'] == 'RESOLVED' || $bug['bug_status'] == 'CLOSED') ? ' style="text-decoration: line-through;"' : '').'><a href="http://www.reactos.org/bugzilla/show_bug.cgi?id='.$bug['bug_id'].'" class="bugNumber">#'.$bug['bug_id'].'</a>'.htmlspecialchars($bug['short_desc']).'</li>';
        }
        echo '</ul>';
      }
      else {
        echo 'There are no bugs submitted yet.';
      }
    
    echo '
      <br />
        <a href="http://www.reactos.org/wiki/File_Bugs">Submit new Bug</a> | 
        '.($RSDB_intern_user_id > 0 ? '<a href="'.$this->buildLink(self::MAIN_BUGS, null).'&amp;link=true">Link to existing bug</a>' : '');
  } // end of member function mainScreenshots
  
  
  
  private function details()
  {

    // entry info
    $stmt=CDBConnection::getInstance()->prepare("SELECT e.id, e.name, e.description, c.name AS category, e.category_id FROM ".CDBT_ENTRIES." e LEFT JOIN ".CDBT_CATEGORIES." c ON c.id=e.category_id WHERE e.id=:entry_id");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $entry = $stmt->fetchOnce(PDO::FETCH_ASSOC);

    // version info
    $stmt=CDBConnection::getInstance()->prepare("SELECT version, entry_id FROM ".CDBT_VERSIONS." WHERE id=:version_id");
    $stmt->bindParam('version_id',$_GET['id'],PDO::PARAM_INT);
    $stmt->execute();
    $version = $stmt->fetchOnce(PDO::FETCH_ASSOC);

    $revision_type = Setting::getPreference('revision_type');
  
    if (!empty($revision_type)) {
      if ($revision_type == 'trunk') {
        $not = '';
      }
      else {
        $not = 'NOT';
      }
    
      $stmt=CDBConnection::getInstance()->prepare("SELECT r.revision, v.name FROM ".CDBT_REPORTS." r LEFT JOIN ".CDBT_VERTAGS." v ON r.revision=v.revision WHERE r.entry_id=:entry_id AND v.revision IS ".$not." NULL AND works IS TRUE ORDER BY v.revision DESC");
    }
    else {
      $stmt=CDBConnection::getInstance()->prepare("SELECT r.revision, v.name FROM ".CDBT_REPORTS." r LEFT JOIN ".CDBT_VERTAGS." v ON r.revision=v.revision WHERE r.entry_id=:entry_id AND works IS TRUE ORDER BY v.revision DESC");
    }
    $stmt->bindParam('entry_id',$entry['id'],PDO::PARAM_INT);
    $stmt->execute();
    $report = $stmt->fetchOnce(PDO::FETCH_ASSOC);

    echo '
      <h2>'.htmlspecialchars($entry['name']).' '.htmlspecialchars($version['version']).'</h2>
      <div id="entryDetails">
        <ul>
          <li>
            <span class="key">Name:</span>
            <a class="value" href="?show=entry&amp;id='.$entry['id'].'">'.htmlspecialchars($entry['name']).'</a>
          </li>
          <li>
            <span class="key">Version:</span>
            <span class="value">'.htmlspecialchars($version['version']).'</span>
          </li>
          <li>
            <span class="key">Category:</span>
            <a class="value" href="?show=list&amp;cat='.$entry['category_id'].'">'.htmlspecialchars($entry['category']).'</a>
          </li>
          <li>
            <span class="key">Works in:</span>
            <span class="value">'.(($report['name']) ? htmlspecialchars($report['name']) : (($report['revision'] > 0) ? 'r'.$report['revision'].' (trunk)' : 'no working version known')).'</span>
          </li>
          <li>
            <span class="key">Description:</span>
            <div class="value">'.htmlspecialchars($entry['description']).'</div>
          </li>
        </ul>
      </div>';

  } // end of member function details



  private function sideScreenshots()
  {
    // hide from non app entries
    if ($this->entry_type == 'App') {
      global $CDB_upload_path_web;
    
      $stmt=CDBConnection::getInstance()->prepare("SELECT id, file, description FROM ".CDBT_ATTACHMENTS." WHERE type = 'picture' AND entry_id=:entry_id AND visible IS TRUE ORDER BY created DESC LIMIT 3");
      $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
      $stmt->execute();
      $screenshots = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
      if (count($screenshots) > 0) {
        foreach ($screenshots as $screenshot) {
          echo '
          <div class="screenshot">
            <a href="'.$this->buildLink(self::MAIN_SCREENSHOTS, null).'&amp;scrid='.$screenshot['id'].'">
              <img src="'.$CDB_upload_path_web.'th/'.$screenshot['file'].'" alt="screenshot" title="'.htmlspecialchars($screenshot['description']).'" />
            </a>
          </div>';
        } // end foreach
      }
      else {
        echo 'No screenshots uploaded yet.<br />
          <br />
          <a href='.$this->buildLink(self::MAIN_SCREENSHOTS, null).'">Submit new screenshot</a>';
      }
    }
  } // end of member function sideScreenshots




  private function sideStats()
  {
    $stat = array();
  
    // comments
    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_COMMENTS." WHERE entry_id=:entry_id AND visible IS TRUE");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $stat['Comments'] = $stmt->fetchColumn();

    // tests
    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_REPORTS." WHERE entry_id=:entry_id AND visible IS TRUE AND disabled IS FALSE");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $stat['Tests'] = $stmt->fetchColumn();

    // bugs part1, getting entry name
    $stmt=CDBConnection::getInstance()->prepare("SELECT name FROM ".CDBT_ENTRIES." WHERE id=:entry_id");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $entry_name=$stmt->fetchColumn();

    // bugs part2, getting a number
    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM bugs.bugs WHERE short_desc LIKE :entry_name OR bug_id IN(SELECT bug_id FROM ".CDBT_BUGS." WHERE entry_id=:entry_id)");
    $stmt->bindValue('entry_name', '%'.$entry_name.'%', PDO::PARAM_STR);
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    @$stmt->execute();
    $stat['Related bugs'] = $stmt->fetchColumn();

    if ($this->entry_type == 'App') {
      // screenshots
      $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ATTACHMENTS." WHERE entry_id=:entry_id AND type = 'picture' AND visible IS TRUE");
      $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
      $stmt->execute();
      $stat['Screenshots'] = $stmt->fetchColumn();
    }

    echo '
        <ul>';

    // output stats
    foreach($stat as $key => $val) {
      echo '
        <li>
          <span class="key">'.$key.':</span>
          <span class="value">'.$val.'</span>
        </li>';
    }
    echo '
        </ul>';
  } // end of member function sideTests



} // end of HTML_Version
?>
