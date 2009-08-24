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
  private $sel = null;
  private $entry_id = null;



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
      $this->side = self::SIDE_SCREENSHOTS;
      $this->main = self::MAIN_COMMENTS;
    }

    // get entry_id
    $stmt=CDBConnection::getInstance()->prepare("SELECT entry_id FROM ".CDBT_VERSIONS." WHERE id=:version_id");
    $stmt->bindParam('version_id',$_GET['id'],PDO::PARAM_INT);
    $stmt->execute();
    $this->entry_id = $stmt->fetchColumn();
   
    echo '<h1>Compatability Database &gt; Entry Details</h1>';

    // check if entry exists
    if ($this->entry_id !== false)
    {
    
      echo '<div id="entryTop">';

      echo '<div id="entrySide">';
      
      $this->tabSideNavigation();

      // top right
      switch ($this->side) {
        case self::SIDE_STATS:
          $this->sideStats();
          break;
        case self::SIDE_TESTS:
          $this->sideTests();
          break;
        case self::SIDE_SCREENSHOTS:
        default:
          $this->sideScreenshots();
          break;
      }

      echo '</div>'; // end side
      
      $this->details();
      
      echo '</div>'; // end top

      // navigation
      $this->tabNavigation();

      // main information
      switch ($this->main) {
      
        // screenshots
        case self::MAIN_SCREENSHOTS:
          $this->mainScreenshots();
          break;
          
        // test reports
        case self::MAIN_TESTS:
          $this->mainTests();
          break;
          
        // bug reports from bugzilla
        case self::MAIN_BUGS:
          $this->mainBugs();
          break;
          
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
  
  
  
  private function mainComments()
  {
    global $RSDB_intern_loginsystem_fullpath;
    global $RSDB_intern_user_id;
  
    if ($this->entry_id > 0 && isset($_POST['comment_content']) && strlen(trim($_POST['comment_content'])) > 0 && $RSDB_intern_user_id > 0) {
      Entry::addComment($this->entry_id, '',$_POST['comment_content']);
    }
  
    echo '
      <div id="entryMain">';
      
    if ($RSDB_intern_user_id > 0) {
      echo '
        <form action="" method="post">
          <fieldset>
            <label for="comment_content">Commment/Answer to ...:</label><br />
            <textarea name="comment_content" id="comment_content" rows="6" cols="80"></textarea><br />
            <button type="submit">Submit</button>
          </fieldset>
        </form>';
    }
    else {
      echo 'To add comments, you need to login with your RosCMS account.<hr />';
    }

    $stmt=CDBConnection::getInstance()->prepare("SELECT title, content, created, user_id FROM ".CDBT_COMMENTS." WHERE entry_id=:entry_id AND parent IS NULL ORDER BY created DESC");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $comments=$stmt->fetchAll(PDO::FETCH_ASSOC);
      
    if (count($comments) > 0) {
      foreach ($comments as $comment) {
        echo '
          <div style="background-color: white;margin: 10px 3px 3px 3px; border: 1px solid lightgray;padding:3px;">
            <div style="border-bottom: 1px solid gray;">
              <!--<h3>'.htmlspecialchars($comment['title']).'</h3>-->
              <span>by <a href="'.$RSDB_intern_loginsystem_fullpath.'?page=search&user_id='.$comment['user_id'].'">'.Subsystem::getUserName($comment['user_id']).'</a> on '.$comment['created'].'</span>
            </div>
            '.nl2br(htmlspecialchars($comment['content'])).'
          </div>';
      }
    }
    else {
      echo 'There are no comments submitted yet.';
    }

    echo '</div>';
  } // end of member function mainComments



  private function mainScreenshots()
  {
    global $RSDB_intern_user_id;
    global $CDB_upload_path_web;

      echo '
        <div id="entryMain">';

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
            <a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pside='.$this->side.'&amp;pmain='.self::MAIN_SCREENSHOTS.'&amp;scrid='.$screenshot['id'].'">
              <img src="'.$CDB_upload_path_web.'th/'.$screenshot['file'].'" alt="screenshot" title="'.htmlspecialchars($screenshot['description']).'" />
            </a>
          </div>';
        }
      }
    }

    echo '
      </div>';
  } // end of member function mainScreenshots



  private function mainTests()
  {
    $stmt=CDBConnection::getInstance()->prepare("SELECT user_id, t.revision, works, environment, environment_version, created, v.name AS releasename FROM ".CDBT_REPORTS." t LEFT JOIN ".CDBT_VERTAGS." v ON v.revision=t.revision WHERE entry_id = :entry_id AND t.visible IS TRUE AND t.disabled IS FALSE ORDER BY revision DESC");
    $stmt->bindParam('entry_id', $this->entry_id, PDO::PARAM_INT);
    $stmt->execute();
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    echo '<div id="entryMain">';

      if (count($tests) > 0) {
        echo '
          <table class="rtable" cellspacing="0" cellpadding="0">
            <thead>
              <th>&nbsp;</th>
              <th>User</th>
              <th>Date</th>
              <th>Revision</th>
              <th>Environment</th>
            </thead>';

        $x=0;
        foreach ($tests as $test) {
          echo '
            <tr class="row'.($x%2+1).'" id="tr'.$x.'">
              <td class="first '.($test['works'] == 'full' ? 'stable' : ($test['works'] == 'part' ? 'unstable' : 'crash')).'">&nbsp;</td>
              <td>'.CUser::getName($test['user_id']).'</td>
              <td>'.$test['created'].'</td>
              <td>'.($test['releasename'] != '' ? $test['releasename'] : $test['revision']).'</td>
              <td>';
          
          // is there a environment
          if ($test['environment'] != 'unkn') {
            echo $test['environment'];
            
            if ($test['environment_version'] != '') {
              echo '('.$test['environment_version'].')';
            }
          }
          echo '</td>
            </tr>';
            
          $x++;
        }
        echo '</table>';
      }
      else {
        echo 'There are no tests submitted yet.';
      }
    
    echo '
        <a href="?show=submit">Submit Test</a>
      </div>';
  } // end of member function mainScreenshots



  private function mainBugs()
  {
    $stmt=CDBConnection::getInstance()->prepare("SELECT name FROM ".CDBT_ENTRIES." WHERE id=:entry_id");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $entry_name=$stmt->fetchColumn();
  
  
    $stmt=CDBConnection::getInstance()->prepare("SELECT DISTINCT bug_id, short_desc FROM bugs.bugs WHERE short_desc LIKE :entry_name AND bug_status NOT IN('RESOLVED', 'CLOSED')");
    $stmt->bindValue('entry_name', '%'.$entry_name.'%', PDO::PARAM_STR);
    $stmt->execute();
    $bugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    echo '<div id="entryMain">';

      if (count($bugs) > 0) {
        echo '<ul id="buglist">';
        foreach ($bugs as $bug) {
          echo '
            <li><a href="http://www.reactos.org/bugzilla/show_bug.cgi?id='.$bug['bug_id'].'" class="bugNumber">#'.$bug['bug_id'].'</a>'.htmlspecialchars($bug['short_desc']).'</li>';
        }
        echo '</ul>';
      }
      else {
        echo 'There are no bugs submitted yet.';
      }
    
    echo '
        <a href="#">Submit Bug</a>
      </div>';
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

      $stmt=CDBConnection::getInstance()->prepare("SELECT r.revision, v.name FROM ".CDBT_REPORTS." r LEFT JOIN ".CDBT_VERTAGS." v ON r.revision=v.revision WHERE r.entry_id=:entry_id AND works IS TRUE ORDER BY v.revision DESC");
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



  private function tabNavigation()
  {
    echo '
      <ul class="entryNavigation">
        <li'.($this->main == self::MAIN_COMMENTS ? ' class="active"><span>Comments</span>' : '><a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pside='.$this->side.'&amp;pmain='.self::MAIN_COMMENTS.'">Comments</a>').'</li>
        <li'.($this->main == self::MAIN_TESTS ? ' class="active"><span>Tests</span>' : '><a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pside='.$this->side.'&amp;pmain='.self::MAIN_TESTS.'">Tests</a>').'</li>
        <li'.($this->main == self::MAIN_BUGS ? ' class="active"><span>Bugs</span>' : '><a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pside='.$this->side.'&amp;pmain='.self::MAIN_BUGS.'">Bugs</a>').'</li>
        <li'.($this->main == self::MAIN_SCREENSHOTS ? ' class="active"><span>Screenshots</span>' : '><a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pside='.$this->side.'&amp;pmain='.self::MAIN_SCREENSHOTS.'">Screenshots</a>').'</li>
      </ul>';
  } // end of member function screenshotShort
  
  
  
  private function tabSideNavigation()
  {
    echo '
      <ul class="entryNavigation">
        <li'.($this->side == self::SIDE_SCREENSHOTS ? ' class="active"><span>Screenshots</span>' : '><a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pmain='.$this->main.'&amp;pside='.self::SIDE_SCREENSHOTS.'">Screenshots</a>').'</li>
        <li'.($this->side == self::SIDE_STATS ? ' class="active"><span>Statistics</span>' : '><a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pmain='.$this->main.'&amp;pside='.self::SIDE_STATS.'">Statistics</a>').'</li>
      </ul>';
      
    //         <li'.($this->side == self::SIDE_TESTS ? ' class="active"><span>Tests</span>' : '><a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pmain='.$this->main.'&amp;pside='.self::SIDE_TESTS.'">Tests</a>').'</li>
  } // end of member function screenshotShort



  private function sideScreenshots()
  {
    global $CDB_upload_path_web;
  
    $stmt=CDBConnection::getInstance()->prepare("SELECT id, file, description FROM ".CDBT_ATTACHMENTS." WHERE type = 'picture' AND entry_id=:entry_id AND visible IS TRUE ORDER BY created DESC LIMIT 3");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $screenshots = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    echo '
      <div id="sideContent">';
    if (count($screenshots) > 0) {
      foreach ($screenshots as $screenshot) {
        echo '
        <div class="screenshot">
          <a href="?show=version&amp;id='.$_GET['id'].'&amp;view=pref&amp;pside='.$this->side.'&amp;pmain='.self::MAIN_SCREENSHOTS.'&amp;scrid='.$screenshot['id'].'">
            <img src="'.$CDB_upload_path_web.'th/'.$screenshot['file'].'" alt="screenshot" title="'.htmlspecialchars($screenshot['description']).'" />
          </a>
        </div>';
      } // end foreach
    }
    
    echo '
      </div>';
  } // end of member function sideScreenshots



  private function sideTests()
  {
    echo '<div id="sideContent">';
    if (isset($reports) && count($reports) > 0) {
      echo '
        <div>
          <ul>';
      foreach($reports as $report) {
        echo '<li>'.($report['works'] ? 'works' : 'doesn\'t').' &mdash; r'.$report['revision'].'</li>';
      }
      echo '
          </ul>
        </div>';
    }
    echo '</div>';
  } // end of member function sideTests



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

    // bugs
    $stmt=CDBConnection::getInstance()->prepare("SELECT name FROM ".CDBT_ENTRIES." WHERE id=:entry_id");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $entry_name=$stmt->fetchColumn();

    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM bugs.bugs WHERE short_desc LIKE :entry_name AND bug_status NOT IN('RESOLVED', 'CLOSED')");
    $stmt->bindValue('entry_name', '%'.$entry_name.'%', PDO::PARAM_STR);
    $stmt->execute();
    $stat['Related bugs'] = $stmt->fetchColumn();

    // screenshots
    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ATTACHMENTS." WHERE entry_id=:entry_id AND type = 'picture' AND visible IS TRUE");
    $stmt->bindParam('entry_id',$this->entry_id,PDO::PARAM_INT);
    $stmt->execute();
    $stat['Screenshots'] = $stmt->fetchColumn();

    echo '
      <div id="sideContent" class="statistics">
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
        </ul>
      </div>';
  } // end of member function sideTests



} // end of HTML_Version
?>
