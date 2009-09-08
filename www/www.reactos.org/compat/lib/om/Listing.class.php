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
  private $order = ''; // sql order by
  private $showColumn = array(); // displayed columns
  private $params = array(); // params for pdo



  private function addAnd()
  {
    $this->where .= ' AND ';
  }



  public function __construct($filter)
  {
    if ($filter == '') {
      return false;
    }
    elseif (!strstr($filter, self::DEVIDE_SETTING)) {
      return false;
    }

    $vertags = false;
    $category = false;
    $tags = false;
    
    // name
    $n_s = false;
    $n_h = false;
    $n_e = false;
    
    // type
    $f = false;
    
    $t = 0;
    
    $p = false;
  
    $filters = explode(self::DEVIDE_FILTER,$filter);
    foreach ($filters as $filter) {
      $part = explode(self::DEVIDE_SETTING,$filter);

      // just add for specific types

      // filter types
      switch ($part[0]) {

        // name
        case 'n':

          // starts with:
          if ($part[1]=='s' && !$n_s) {
            $this->addAnd();
            $this->where .= " e.name LIKE :starts_with ";
            $this->params[] = array('starts_with',$part[2].'%',PDO::PARAM_STR);
            $n_s = true;
          }

          // contains
          elseif ($part[1]=='h' && !$n_h) {
            $this->addAnd();
            $this->where .= " e.name LIKE :contains ";
            $this->params[] = array('contains','%'.$part[2].'%',PDO::PARAM_STR);
            $n_h = true;
          }

          // ends with
          elseif ($part[1]=='e' && !$n_e) {
            $this->addAnd();
            $this->where .= " e.name LIKE :ends_with ";
            $this->params[] = array('ends_with','%'.$part[2],PDO::PARAM_STR);
            $n_e = true;
          }
          break;

        // entry type
        case 'f':

          if (!$f) {
            $this->addAnd();
            
            // is
            if ($part[1]=='eq') {
              $this->where .= " e.type = :type ";
            }

            // is not
            elseif (!$f_ne) {
              $this->where .= " e.type != :type ";
            }
            $this->params[] = array('type',$part[2],PDO::PARAM_STR);
          }
          break;

        // tagged with
        case 't':
          ++$t;
          
          $this->addAnd();
          $this->where .= " t".$t.".name = :tagname".$t." ";
          $this->params[] = array('tagname'.$t,$part[2],PDO::PARAM_STR);
          $this->from .= " JOIN ".CDBT_TAGGED." tr".$t." ON tr".$t.".entry_id=e.id ";
          $this->from .= " JOIN ".CDBT_TAGS." t".$t." ON t".$t.".id=tr".$t.".tag_id ";
          break;

        // show additional columns
        case 'a':
          switch ($part[2]) {
            case 'type';
              $this->select .= ", e.type";
              $this->showColumn[] = array('field'=>'type','description'=>'Type','format'=>'HTML_List::formatType');
              break;
            case 'category';
              $this->select .= ", cs.name category";
              $this->showColumn[] = array('field'=>'category','description'=>'Category');
              $category = true;
              break;
            case 'rosversion';
              $this->select .= ", IF(vt.name IS NULL, CONCAT('r',r.revision),vt.name) AS rosversion";
              $this->showColumn[] = array('field'=>'rosversion','description'=>'Revision');
              $vertags = true;
              break;
            case 'datediff';
              $this->select .= ", r.created AS diff";
              $this->showColumn[] = array('field'=>'diff','description'=>'Report age','format'=>'CDate::getAge');
              break;
              /*
            case 'laststatus';
              $this->select .= ", r.works AS status";
              $this->showColumn[] = array('field'=>'status','description'=>'','format'=>'HTML_List::formatWorkingStatus');
              break;*/
            case 'name';
              $this->select .= ", e.name";
              $this->showColumn[] = array('field'=>'name','description'=>'Entry');
              break;
            case 'modified';
              $this->select .= ", e.modified";
              $this->showColumn[] = array('field'=>'modified','description'=>'Last Modified');
              break;
            case 'creation';
              $this->select .= ", e.created";
              $this->showColumn[] = array('field'=>'created','description'=>'Creation');
              break;
            case 'user';
              $this->select .= ", r.user_id";
              $this->showColumn[] = array('field'=>'user_id','description'=>'User','format'=>'CUser::getName');
              break;
            case 'counttests';
              $this->select .= ", (SELECT COUNT(*) FROM ".CDBT_REPORTS." WHERE entry_id=e.id) AS tests";
              $this->showColumn[] = array('field'=>'tests','description'=>'Tests');
              break;
            case 'countscreenshots';
              $this->select .= ", (SELECT COUNT(*) FROM ".CDBT_ATTACHMENTS." WHERE type='picture' AND entry_id=e.id) AS screenshots";
              $this->showColumn[] = array('field'=>'screenshots','description'=>'Screenshots');
              break;
            case 'countversions';
              $this->select .= ", (SELECT COUNT(*) FROM ".CDBT_VERSIONS." WHERE entry_id=e.id) AS versions";
              $this->showColumn[] = array('field'=>'versions','description'=>'Versions');
              break;
            case 'description';
              $this->select .= ", e.description";
              $this->showColumn[] = array('field'=>'description','description'=>'Description');
              break;
          }
          break;

        // category
        case 'c':
          $this->addAnd();
          
          if ($part[1] == 'is') {
            $this->where .= " e.category_id = :category ";
            $this->params[] = array('category',$part[2],PDO::PARAM_STR);
          }
          elseif ($part[1] == 'sub') {
            $subs = Category::getAllChildsAsList($part[2]);
            if ($subs == '') {
              $this->where .= " FALSE ";
            }
            else {
              $this->where .= " e.category_id IN(".$subs.") ";
            }
          }
          elseif ($part[1] == 'nosub') {
            $subs = Category::getAllChildsAsList($part[2]);
            if ($subs == '') {
              $this->where .= " TRUE ";
            }
            else {
              $this->where .= " e.category_id NOT IN(".$subs.") ";
            }
          }
          else {
            $this->where .= " e.category_id != :category ";
            $this->params[] = array('category',$part[2],PDO::PARAM_STR);
          }
          break;

        // checked reports
        case 'v':
        
          $this->addAnd();
            
          if ($part[1] == 'is') {
            $this->where .= " r.checked IS TRUE";
          }
          else {
            $this->where .= " r.checked IS FALSE ";
          }
          break;

        // only show release / trunk versions
        case 'p':
        
          if (!$p) {
            $this->addAnd();
          
            if ($part[2] == 'release') {
              $this->where .= " vt.id IS NOT NULL ";
              $vertags = true;
            }
            elseif ($part[2] == 'trunk') {
              $this->where .= " vt.id IS NULL ";
              $vertags = true;
            }
          }
          break;

        // releases
        case 'e':
        // show specific revisions only
        case 'r':
        
            $this->addAnd();
            
          switch ($part[1]) {

            // >
            case 'gt':
              $op = '>';
              break;

            // >=
            case 'ge':
              $op = '>=';
              break;

            // ==
            default:
            case 'eq':
              $op = '=';
              break;

            // <=
            case 'le':
              $op = '<=';
              break;

            // <
            case 'lt':
              $op = '<';
              break;

            // !=
            case 'ne':
              $op = '!=';
              break;
          } // end switch part 1

          $this->where .= " r.revision ".$op." :revision";
          $this->params[] = array('revision',$part[2],PDO::PARAM_STR);
          break;

        // order by
        case 'o':

          // direction
          if ($part[1] == 'desc') {
            $dir = 'DESC';
          }
          else {
            $dir = 'ASC';
          }
        
          // by
          switch ($part[2]) {
            case 'creation':
              $by = 'e.created';
              break;
            case 'modified':
              $by = 'e.modified';
              break;
            case 'works':
              $by = 'r.works';
              break;
            default:
            case 'name':
              $by = 'e.name';
              break;
          }
          
          if ($this->order != '') $this->order .= ', ';
          $this->order .= $by.' '.$dir;
          break;
      } // end switch
    } // end foreach
    
    if ($vertags) {
      $this->from .= " LEFT JOIN ".CDBT_VERTAGS." vt ON vt.revision=r.revision";
    }
    if ($category) {
      $this->from .= " LEFT JOIN ".CDBT_CATEGORIES." cs ON e.category_id=cs.id ";
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



  public function order()
  {
    return $this->order;
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
    $list = array(
      'n' => 'Name',
      'c' => 'Category',
      'f' => 'Type',
      'p' => 'Revision Type',
      'r' => 'Revision',
      'e' => 'Release',
      'v' => 'Reports',
      't' => 'Tagged with',
      'a' => 'Column',
      'o' => 'Order');
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

      case 'f':
        $input['type']['eq'] = '=';
        $input['type']['ne'] = '!=';
        $input['input_type'] = 'dropdown';
        $input['content'] = array(
          'App'=>'Application',
          'DLL'=>'DLL',
          'Drv'=>'Driver',
          'Oth'=>'Other');
        break;

      case 't':
        $input['type']['eq'] = '=';
        $input['input_type'] = 'text';
        $input['content'] = '';
        break;

      case 'a':
        $input['type']['eq'] = 'add';
        $input['input_type'] = 'dropdown';
        $input['content'] = array();
        $input['content']['category'] = 'Category';
        $input['content']['creation'] = 'Creation';
        $input['content']['description'] = 'Description';
        $input['content']['modified'] = 'Last Modification';
        $input['content']['user'] = 'Reporting User';
        $input['content']['rosversion'] = 'Revision';
        $input['content']['countscreenshots'] = 'Screenshot count';
        $input['content']['counttests'] = 'Test count';
        $input['content']['type'] = 'Type';
        $input['content']['countversions'] = 'Versions count';
        $input['content']['datediff'] = 'Last Report Age';
        break;

      case 'c':
        $input['type']['is'] = '=';
        $input['type']['not'] = '!=';
        $input['type']['sub'] = 'in subcategories';
        $input['type']['nosub'] = 'not in subcategories';
        $input['input_type'] = 'dropdown';
        $input['content'] = array();

        $stmt = CDBConnection::getInstance()->prepare("SELECT id, name FROM ".CDBT_CATEGORIES." WHERE visible IS TRUE ORDER BY name ASC");
        $stmt->execute();
        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $input['content'][$category['id']] = $category['name'];
        }
        break;

      case 'v':
        $input['type']['is'] = 'is';
        $input['type']['isnot'] = 'is not';
        $input['input_type'] = 'dropdown';
        $input['content'] = array();
        $input['content']['checked'] = 'Checked';
        $input['content']['unchecked'] = 'Unchecked';
        break;

      case 'p':
        $input['type']['is'] = '=';
        $input['input_type'] = 'dropdown';
        $input['content'] = array();
        $input['content']['release'] = 'Release versions';
        $input['content']['trunk'] = 'Trunk revisions';
        break;

      case 'r':
        $input['type']['eq'] = '=';
        $input['type']['ne'] = '!=';
        $input['type']['lt'] = '<';
        $input['type']['le'] = '<=';
        $input['type']['gt'] = '>';
        $input['type']['ge'] = '>=';
        $input['input_type'] = 'text';
        $input['content'] = '';
        break;

      case 'e':
        $input['type']['eq'] = '=';
        $input['type']['ne'] = '!=';
        $input['type']['lt'] = '<';
        $input['type']['le'] = '<=';
        $input['type']['gt'] = '>';
        $input['type']['ge'] = '>=';
        $input['input_type'] = 'dropdown';
        $input['content'] = array();

        $stmt = CDBConnection::getInstance()->prepare("SELECT revision, name FROM ".CDBT_VERTAGS." WHERE visible IS TRUE ORDER BY revision DESC");
        $stmt->execute();
        while ($release = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $input['content'][$release['revision']] = $release['name'];
        }
        break;

      case 'o':
        $input['type']['asc'] = 'Ascending';
        $input['type']['desc'] = 'Descending';
        $input['input_type'] = 'dropdown';
        $input['content'] = array();
        $input['content']['name'] = 'Name';
        $input['content']['creation'] = 'Creation';
        $input['content']['modified'] = 'Last Modification';
        $input['content']['works'] = 'Latest working status';
        break;
    } // end switch
    
    return $input;
  }
  
} // end Listing
?>

