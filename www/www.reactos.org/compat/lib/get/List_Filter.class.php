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

class List_Filter
{



  public function __construct( $part = null )
  {
    header("Content-Type: text/xml");
    switch ($part) {
      case 'new':
      default:
        $this->buildNew();
        break;
      case 'details':
        $this->buildDetails($_GET['type']);
          break;
    }
  } // end of constructor
  
  
  
  private function buildNew()
  {
    $list = Listing::filterList();
        
    echo '<root type="new">';
    foreach($list as $shortcut=>$name){
      echo '<filter shortcut="'.$shortcut.'">'.$name.'</filter>';
    }
    echo '</root>';
  } // end of member function buildNew
  
  
  
  private function buildDetails($type)
  {
    $list = Listing::inputByFilter($type);
        
    echo '<root type="details">';

    foreach ($list['type'] as $shortcut=>$name) {
      echo '<relation shortcut="'.$shortcut.'">'.htmlspecialchars($name).'</relation>';
    }

    if ($list['input_type'] == 'text') {
      echo '<content type="text" />';
    }
    else {
      echo '<content type="dropdown">';
      
      foreach ($list['content'] as $shortcut=>$name) {
        echo '<item shortcut="'.$shortcut.'">'.htmlspecialchars($name).'</item>';
      }

      echo '</content>';
    }
    echo '</root>';
  } // end of member function buildNew



} // end of List_Filter
?>