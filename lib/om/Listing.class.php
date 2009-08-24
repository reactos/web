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


class Listing
{

  const DEVIDE_FILTER = '|';
  const DEVIDE_SETTING = '_';

  private $select = ''; // sql select
  private $from = ''; // sql from
  private $where = ''; // sql where
  private $showColumn = array(); // displayed columns
  private $params = array(); // params for pdo



  public function construct($filter)
  {
    if ($filter == '') {
      return false;
    }
    elseif (!strstr($filter, DEVIDE_SETTING)) {
      return false;
    }
  
    $filters = explode(DEVIDE_FILTER,$filter);
    foreach ($filters as $filter) {
      $part = explode(DEVIDE_SETTING,$filter);

      $this->where .= ' AND ';

      // filter types
      switch ($part[0]) {

        // name
        case 'n':

          // starts with:
          if ($part['1']=='s') {
            $this->where .= " e.name LIKE :starts_with ";
            $this->params[] = array('starts_with',$part[2].'%',PDO::PARAM_STR);
          }

          // contains
          elseif ($part['1']=='h') {
            $this->where .= " e.name LIKE :contains ";
            $this->params[] = array('contains','%'.$part[2].'%',PDO::PARAM_STR);
          }

          // ends with
          elseif ($part['1']=='e') {
            $this->where .= " e.name LIKE :ends_with ";
            $this->params[] = array('ends_with','%'.$part[2],PDO::PARAM_STR);
          }
          break;

        // tagged with
        case 't':
          $this->where .= " t.name = :tagname ";
          $this->from .= " JOIN ".CDBT_TAGGED." tr ON tr.entry_id=e.id ";
          $this->from .= " JOIN ".CDBT_TAGS." t ON t.id=tr.tag_id ";
          $this->params[] = array('tagname',$part[2],PDO::PARAM_STR);
          break;

        // show additional columns
        case 'a':
          switch ($part[2]) {
            case 'category';
            $this->select .= " (SELECT name FROM ".CDBT_CATEGORIES." WHERE id=e.category_id) AS category";
            $this->showColumn[] = array('field'=>'category','description'=>'Category');
          }
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
  } // end of constructor



  public function select()
  {
    return $this->select;
  }



  public function from()
  {
    return $this->from;
  }



  public function where()
  {
    return $this->where;
  }



  public function params()
  {
    return $this->params;
  }



  public function showColumn()
  {
    return $this->showColumn;
  }
  
  static public function filterList()
  {
    $list = array();
    $list[] = array('n'=>'name');
    $list[] = array('t'=>'tagged with');
    $list[] = array('c'=>'category');
    $list[] = array('a'=>'additional column');
    return $list;
  } // end of member function filterList
  
  static public function inputByFilter($filterType)
  {
    // prepare output array
    $input = array(
      'type'=>'', // field 2/3
      'input_type'=>'', // how does field 3 looks like (text / dropdown)
      'content'=>null); // field 3/3
 
    //
    switch ($filterType) {

      case 'n':
        $input['type']['s'] = 'starts with';
        $input['type']['h'] = 'contains';
        $input['type']['e'] = 'ends with';
        $input['input_type'] = 'text';
        $input['content'] = '';
        break;

      case 't':
        $input['type']['eq'] = '=';
        $input['input_type'] = 'text';
        $input['content'] = '';
        break;

      case 'a':
        $input['type'][] = array('eq'=>'=');
        $input['input_type'] = 'dropdown';
        $input['content'] = array();
        $input['content']['category'] = 'Category';
        $input['content']['creation'] = 'Creation';
        $input['content']['name'] = 'Name';
        $input['content']['status'] = 'Status';
        $input['content']['tests'] = 'Test count';
        $input['content']['screenshots'] = 'Screenshot count';
        $input['content']['type'] = 'Software type';
        break;

      case 'c':
        $input['type'][] = array('is'=>'=');
        $input['type'][] = array('not'=>'!=');
        $input['input_type'] = 'dropdown';
        $input['content'] = array();

        $stmt = CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_CATEGORIES."");
        $stmt->execute();
        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $input['content'][$category['id']] = $category['name'];
        }
        break;
    } // end switch
    
    return $input;
  }
  
} // end Listing
?>

