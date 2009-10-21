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


class HTML_List extends HTML
{

  private $where = '';
  private $from = '';
  private $order = '';
  private $params = array();
  private $select = '';
  private $showColumn = array();
  
  private $filter = '';
  private $query = false;


  public function __construct($filter='')
  {
    global $RSDB_intern_user_id;
    
    $this->query = ($filter!='');
    
    // check preferences and apply additional filter
    if ($RSDB_intern_user_id > 0) {
      $value = Setting::getPreference('revision_type');
      
      // get preferences for revision type
      if (!empty($value)) {
        $filter .= Listing::DEVIDE_FILTER.'p'.Listing::DEVIDE_SETTING.'is'.Listing::DEVIDE_SETTING.$value;
      }
      
      // save queries
      if (!empty($_POST['savename'])) {
        Setting::setQuery($_POST['savename'],$this->filter);
      }
    }
  
    $this->filter = $filter;
    $this->register_js('compat.js');
    // just display the query if there is one
    if ($this->query != '') {

      // evaluate filters
      $this->listing = new Listing($filter);
      
      // apply to current settings
      $this->where = $this->listing->where();
      $this->from = $this->listing->from();
      $this->order = $this->listing->order();
      $this->select = $this->listing->select();
      $this->params = $this->listing->params();
      $this->showColumn = $this->listing->showColumn();
    }
    parent::__construct();
  }


  protected function body ()
  {
    $limit = 30;
    
    if (isset($_GET['offset'])) {
      $offset = intval($_GET['offset']);
    }
    else {
      $offset = 0;
    }
      
    ob_start();
    if (isset($_GET['letter'])) {
      $this->naviLetter($_GET['letter']);
      $browse = 'name';
    }
    elseif (isset($_GET['cat'])) {
      $this->naviCategory($_GET['cat']);
      $browse = 'category';
    }
    elseif (isset($_GET['type'])) {
      $this->naviCategory(0,$_GET['type']);
      $browse = 'category';
    }
    elseif (isset($_GET['tag']) && $_GET['tag'] == '*') {
      $this->naviTags();
      $browse = 'tag';
    }

    elseif (isset($_GET['filter'])) {
      $this->naviCustom();
      $browse = 'custom query';
    }
    elseif (isset($_POST['searchbar']))
      $browse = 'search for: '.htmlspecialchars($_POST['searchbar']);
    else {
      $browse = 'unknown setting';
    }
    $output = ob_get_contents();
    ob_end_clean();

    echo '
      <h1>Compatability Database &gt; Browse by '.$browse.'</h1>'.
      $output;

    if (!isset($_GET['tag']) || $_GET['tag'] != '*') {
      
      $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(DISTINCT e.id) FROM ".CDBT_ENTRIES." e JOIN ".CDBT_REPORTS." r ON r.entry_id=e.id ".$this->from." WHERE e.visible IS TRUE AND r.id=(SELECT id FROM ".CDBT_REPORTS." WHERE entry_id=e.id ORDER BY checked DESC, created DESC LIMIT 1) ".$this->where);
      foreach ($this->params as $param) {
        $stmt->bindValue($param[0],$param[1],$param[2]);
      }
      $stmt->execute();
      $entries_count = $stmt->fetchColumn();

      if ($entries_count > 0 && $this->query) {
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
        $stmt=CDBConnection::getInstance()->prepare("SELECT DISTINCT e.id, e.name, r.works ".$this->select." FROM ".CDBT_ENTRIES." e JOIN ".CDBT_REPORTS." r ON r.entry_id=e.id ".$this->from." WHERE e.visible IS TRUE AND r.id=(SELECT id FROM ".CDBT_REPORTS." WHERE entry_id=e.id ORDER BY created DESC LIMIT 1) ".$this->where.(!empty($this->order) ? ' ORDER BY '.$this->order : '')." LIMIT :limit OFFSET :offset");
        foreach ($this->params as $param) {
          $stmt->bindValue($param[0],$param[1],$param[2]);
        }
        $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
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

        if ($entries_count > $limit) {
          echo '<div>Navigation:';
          $to = ceil($entries_count/(float)$limit);
          for ($i=1; $i <= $to ; ++$i) {
            if ($offset==($i-1)*$limit) {
              echo '<strong>['.$i.']</strong>';
            }
            else {
              echo '<a href="';
              
              if (isset($_GET['letter'])) {
                echo '?show=list&amp;letter='.$_GET['letter'];
              }
              elseif (isset($_GET['cat'])) {
                echo '?show=list&amp;cat='.$_GET['cat'];
              }
              elseif (isset($_GET['tag'])) {
                echo '?show=list&amp;tag='.$_GET['tag'];
              }
              elseif (isset($_GET['by'])) {
                echo '?show=search&amp;by='.$_GET['by'];
              }
              else {
                echo '?show=list&amp;filter='.$this->filter;
              }
              
              echo '&amp;offset='.(($i-1)*$limit).'">'.$i.'</a>';
            }
          }
          echo '</div>';
        }
      }
      else {
        echo 'No entries found.';
      }
    }
  } // end of member function body



  private function naviLetter( $letter )
  {
    echo '<div id="letternavi"><h2>Letter Navigation</h2>';
    for ($i=ord('a'); $i <= ord('z') ; ++$i) {
      if (isset($letter) && chr($i)==$letter) {
        echo '<strong>['.strtoupper(chr($i)).']</strong>';
      }
      else {
        echo '<a href="?show=list&amp;letter='.chr($i).'">'.strtoupper(chr($i)).'</a>';
      }
    }
    echo '</div>';
  }



  private function naviCategory( $category_id=0,$type=null )
  {
    $types = array(
    'App'=>'Applications',
    'DLL'=>'Dynamic Link Libraries',
    'Drv'=>'Drivers',
    'Oth'=>'Other');

    // show root
    echo '
      <ul id="breadcrumb">';


    if ($category_id > 0) {
      
      // show current path
      $stmt=CDBConnection::getInstance()->prepare("SELECT name, id, parent,type FROM ".CDBT_CATEGORIES." WHERE id=:cat_id AND visible IS TRUE");
      $stmt->bindParam('cat_id',$category_id,PDO::PARAM_INT);
      $stmt->execute();
  
      // get output in reversed order
      $output = '';
      while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output = '
          <li>&rarr; <a href="?show=list&amp;cat='.$category['id'].'">'.htmlspecialchars($category['name']).'</a></li>'.$output;
  
        if ($category['parent'] > 0) {
          $stmt->bindParam('cat_id',$category['parent'],PDO::PARAM_INT);
          $stmt->execute();
        }
        $cat_type = $category['type'];
      } // end while

      echo '
        <li><a href="?show=list&amp;type='.$cat_type.'">'.htmlspecialchars($types[$cat_type]).'</a></li>'.$output;
    }
    elseif (!empty($type)) {
      echo '
        <li><a href="?show=list&amp;type='.$type.'">'.htmlspecialchars($types[$type]).'</a></li>';
    }
    else {
      echo '
        <li></li>';
    }

    echo '
      </ul>
      <br style="clear: both;" />';

    if (empty($type)) {
      $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_CATEGORIES." p WHERE parent=:category_id");
      $stmt->bindParam('category_id',$category_id,PDO::PARAM_INT);
    }
    else {
      $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_CATEGORIES." p WHERE parent IS NULL and type=:type");
      $stmt->bindParam('type',$type,PDO::PARAM_STR);
    }
    $stmt->execute();

    if ($stmt->fetchColumn() > 0 || empty($type)) {
    
      echo '
        <div style="margin-bottom: 3em;clear:both;">
          <h2>Category Navigation</h2>
          <table class="rtable" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Subcategories</th>
                <th>Entries</th>
              </tr>
            </thead>
            <tbody>';

      // show types
      if ($category_id == 0 && empty($type)) {

        $x=0;
        foreach ($types as $shortcut=>$name) {
          ++$x;
        
          // subcategories count
          $stmt_sub = CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_CATEGORIES." WHERE type = :shortcut");
          $stmt_sub->bindParam('shortcut',$shortcut,PDO::PARAM_STR);
          $stmt_sub->execute();
          $subcategories = $stmt_sub->fetchColumn();

          // entries count
          $sub_list = Category::getAllChildsAsList(0, true, $shortcut);
          if (!empty($sub_list)) {
          
            $revision_type = Setting::getPreference('revision_type');
            if (!empty($revision_type)) {
              if ($revision_type == 'trunk') {
                $not = '';
              }
              else {
                $not = 'NOT';
              }

              $stmt_entr = CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ENTRIES." e WHERE id IN(SELECT r.entry_id FROM ".CDBT_REPORTS." r LEFT JOIN ".CDBT_VERTAGS." o ON o.revision=r.revision WHERE o.revision IS ".$not." NULL AND e.id=r.entry_id) AND category_id IN (".$sub_list.")");
            
            }
            else {
              $stmt_entr = CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ENTRIES." WHERE category_id IN (".$sub_list.")");
            }
            $stmt_entr->execute();
            $entries = $stmt_entr->fetchColumn();
          }
          else {
            $entries = 0;
          }
  
          echo '
            <tr class="row'.($x%2+1).'">
              <td><a href="?show=list&amp;type='.$shortcut.'">'.$name.'</a></td>
              <td>'.$subcategories.'</td>
              <td>'.$entries.'</td>
            </tr>';
        } // end foreach
      }

      // show categories
      else {

        if ($category_id > 0) {
          $stmt=CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_CATEGORIES." p WHERE parent=:category_id ORDER BY name ASC");
          $stmt->bindParam('category_id',$category_id,PDO::PARAM_INT);
        }
        else {
          $stmt=CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_CATEGORIES." p WHERE parent IS NULL AND type=:type ORDER BY name ASC");
          $stmt->bindParam('type',$type,PDO::PARAM_STR);
        }
        $stmt->execute();
        $x=0;
        while ($category=$stmt->fetch(PDO::FETCH_ASSOC)) {
          ++$x;

          $sub_list = Category::getAllChildsAsList($category['id'], false);
          if (!empty($sub_list)) {
            // subcategories count
            $stmt_sub = CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_CATEGORIES." WHERE id IN (".$sub_list.")");
            $stmt_sub->execute();
            $subcategories = $stmt_sub->fetchColumn();
          }
          else {
            $subcategories = 0;
          }

          $sub_list = Category::getAllChildsAsList($category['id'], true);
            // entries count
            $stmt_entr = CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ENTRIES." WHERE category_id IN (".$sub_list.")");
            $stmt_entr->execute();
            $entries = $stmt_entr->fetchColumn();

          echo '
            <tr class="row'.($x%2+1).'">
              <td><a href="?show=list&amp;cat='.$category['id'].'">'.$category['name'].'</a></td>
              <td>'.$subcategories.'</td>
              <td>'.$entries.'</td>
            </tr>';
        } // end while
      }

      echo '
            </tbody>
          </table>
        </div>';
    }
  }




  private function naviTags( )
  {
    $stmt=CDBConnection::getInstance()->prepare("SELECT MAX((SELECT COUNT(*) FROM ".CDBT_TAGGED." WHERE tag_id=t.id)) AS max FROM ".CDBT_TAGS." t");
    $stmt->execute();
    $max = $stmt->fetchColumn();

    echo '
      <h2>Navigate by Tag</h2>
      <div style="margin-bottom: 3em;text-align:left;">';
    
    $stmt=CDBConnection::getInstance()->prepare("SELECT id, name, (SELECT COUNT(*) FROM ".CDBT_TAGGED." WHERE tag_id=t.id) AS count FROM ".CDBT_TAGS." t ORDER BY name ASC");
    $stmt->execute();
    while ($tag=$stmt->fetch(PDO::FETCH_ASSOC)) {

      echo '<a style="margin-right: 20px; font-size: '.(((int)$tag['count']/(float)$max*2.0)+0.9).'em;" href="?show=list&amp;tag='.rawurlencode($tag['name']).'">'.htmlspecialchars($tag['name']).'</a>';
    }
    echo '
      </div>';
  }




  private function naviCustom( )
  {
    global $RSDB_intern_user_id;

    $filters = explode(Listing::DEVIDE_FILTER, $this->filter);
  
    $list = Listing::filterList();
    
    $i=0; // sequence number

    echo '
      <form id="query" action="?show=list&amp;filter=custom" method="post">
        <fieldset>
          <legend>Custom Query</legend>
          <ul id="customfilters">';
    foreach ($filters as $filter) {
      reset($list);
      ++$i;
    
      $part = explode(Listing::DEVIDE_SETTING,$filter);
      if ($part[0] == '') $part[0] = key($list);
      
      $details = Listing::inputByFilter($part[0]);
        
        
      echo '
        <li id="fr'.$i.'">
          <em>'.($i > 1 ? 'and' : '&nbsp;&nbsp;&nbsp;').'</em>
        <select id="ft'.$i.'" name="ft'.$i.'" onchange="CsFilterDetails(this.value,\'fd'.$i.'\');">';

      // list types
      foreach ($list as $shortcut=>$name) {
        echo '<option value="'.$shortcut.'"'.($part[0]==$shortcut ? ' selected="selected"':'').'>'.htmlspecialchars($name).'</option>';
      }
      echo '
        </select>
        <span id="fd'.$i.'">
          <select id="fe'.$i.'" name="fe'.$i.'">';

      // list equation
      foreach ($details['type'] as $shortcut=>$name) {
        echo '<option value="'.$shortcut.'"'.($part[1]==$shortcut ? ' selected="selected"':'').'>'.htmlspecialchars($name).'</option>';
      }
      echo '</select> ';

      // text
      if ($details['input_type'] == 'text') {
        echo '<input type="text" id="fc'.$i.'" name="fc'.$i.'" value="'.htmlspecialchars(@$part[2]).'" />';
      }
      // dropdown
      else {
        echo '<select id="fc'.$i.'" name="fc'.$i.'">';
        foreach ($details['content'] as $shortcut=>$name) {
          echo '<option value="'.$shortcut.'"'.($part[2]==$shortcut ? ' selected="selected"':'').'>'.htmlspecialchars($name).'</option>';
        }
        echo '</select>';
      }

      echo '
          </span>'.($i > 1 ? '
          <a href="#" onclick="'."CsDeleteFilter('fr".$i."');".'">&mdash;</a>' : '').'
        </li>';
    }
    echo '
            <li style="display:none;">
              <input type="hidden" name="sequ_num" id="sequ_num" value="'.($i>1?$i:1).'" />
              <input type="hidden" name="savename" id="savename" value="" />
            </li>
          </ul>
          <ul>
            <li><button onclick="CsNewFilter();return false; ">add</button></li>
          </ul>'.($RSDB_intern_user_id > 0 ?'
          <button type="submit" onclick="'."CsSaveQuery();".'">Save</button>' : '').'
          <button type="submit" onclick="'."document.forms['query'].submit();".'">execute</button>
        </fieldset>
      </form>';
  }
  
  
  
  public static function formToFilter()
  {
    if (isset($_POST['sequ_num']) && $_POST['sequ_num'] > 0) {
      $filter = null;

      for ($i=0; $i <= $_POST['sequ_num']; ++$i) {
        if (isset($_POST['ft'.$i]) && isset($_POST['fe'.$i]) && isset($_POST['fc'.$i])) {
          if ($filter !== null) {
            $filter .= Listing::DEVIDE_FILTER;
          }
          $filter .= $_POST['ft'.$i].Listing::DEVIDE_SETTING.$_POST['fe'.$i].Listing::DEVIDE_SETTING.$_POST['fc'.$i];
        }
      }

      return $filter;
    }
    
    return false;
  } // end of member function formToFilter
  
  
  public static function formatWorkingStatus($status)
  {
    if ($status == null) return '';
    return '<div class="'.($status == 'full' ? 'stable' : ($status == 'part' ? 'unstable' : 'crash')).'">&nbsp;</div>';
  }
  
  
  public static function formatType($type)
  {
    switch ($type) {
      case 'App':
        return 'Application';
        break;
      case 'DLL':
        return 'DLL';
        break;
      case 'Drv':
        return 'Driver';
        break;
      case 'Oth':
        return 'Other';
        break;
    }
  }
  
} // end HTML_List
?>

