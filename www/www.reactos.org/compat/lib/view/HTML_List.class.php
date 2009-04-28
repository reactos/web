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
  private $params = array();


  public function __construct($filter='')
  {
    $this->buildQuery($filter);
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
    
    if (isset($_GET['letter']) && $_GET['letter'] != 'all') {
      $letter = $_GET['letter'];
    }
  
    echo '
      <h1>Compatability Database &gt; browse by name</h1>';
    
      echo '<div>Letters:';
      for ($i=ord('a'); $i <= ord('z') ; ++$i) {
        if (isset($letter) && chr($i)==$letter) {
          echo '<strong>['.chr($i).']</strong>';
        }
        else {
          echo '<a href="?page=list&amp;letter='.chr($i).'">'.strtoupper(chr($i)).'</a>';
        }
      }
      echo '</div>';

    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_ENTRIES." e ".$this->from." WHERE e.visible IS TRUE ".$this->where);
    foreach ($this->params as $param) {
      $stmt->bindValue($param[0],$param[1],$param[2]);
    }
    $stmt->execute();
    $entries_count = $stmt->fetchColumn();
    
    if ($entries_count > $limit) {
      echo '<div>Navigation:';
      $to = ceil($entries_count/(float)$limit);
      for ($i=1; $i <= $to ; ++$i) {
        if ($offset==($i-1)*$limit) {
          echo '<strong>['.$i.']</strong>';
        }
        else {
          echo '<a href="?page=list'.(isset($letter) ? '&amp;letter='.$letter:'').'&amp;offset='.(($i-1)*$limit).'">'.$i.'</a>';
        }
      }
      echo '</div>';
    }

    echo '
      <table class="rtable">
        <thead>
          <tr>
            <th>Application</th>
            <th>Works?</th>
            <th>Last modified</th>
          </tr>
        </thead>
        <tbody>';

    reset($this->params);
    $stmt=CDBConnection::getInstance()->prepare("SELECT e.id, e.name, e.modified FROM ".CDBT_ENTRIES." e ".$this->from." WHERE e.visible IS TRUE ".$this->where." ORDER BY e.name ASC LIMIT :limit OFFSET :offset");
    foreach ($this->params as $param) {
      $stmt->bindValue($param[0],$param[1],$param[2]);
    }
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $x=0;
    while ($entry=$stmt->fetch(PDO::FETCH_ASSOC)) {
      ++$x;

      echo '
        <tr class="row'.($x%2+1).'">
          <td><a href="?page=item&amp;item='.$entry['id'].'">'.htmlspecialchars($entry['name']).'</a></td>
          <td>???</td>
          <td>'.$entry['modified'].'</td>
        </tr>';
    }

    echo '
        </tbody>
      </table>';
  } // end of member function body



  private function buildQuery ($filter)
  {
    $filters = explode('|',$filter);
    foreach ($filters as $filter) {
      $part = explode('_',$filter);

      $this->where .= ' AND ';

      switch ($part[0]) {
        
        // starts with:
        case 's':
          $this->where .= " e.name LIKE :starts_with ";
          $this->params[] = array('starts_with',$part[2].'%',PDO::PARAM_STR);
          break;

        // contains
        case 'h':
          $this->where .= " e.name LIKE :contains ";
          $this->params[] = array('contains','%'.$part[2].'%',PDO::PARAM_STR);
          break;

        // ends with
        case 'e':
          $this->where .= " e.name LIKE :ends_with ";
          $this->params[] = array('ends_with','%'.$part[2],PDO::PARAM_STR);
          break;

        // category
        case 'c':
          if ($part[1] == 'is') {
            $this->where .= " e.category_id = :category ";
          }
          else {
            $this->where .= " e.category_id != :category ";
          }
          $this->from .= " JOIN ".CDBT_CATEGORIES." c ON c.id=e.category_id ";
          $this->params[] = array('category',$part[2],PDO::PARAM_STR);
          break;
      }
    }
  } // end of member function buildQuery
  
} // end HTML_List
?>

