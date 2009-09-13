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

class List_Query
{



  public function __construct( $query )
  {
    header("Content-Type: text/xml");
    $list = Listing::filterList();
    
    $query = explode(Listing::DEVIDE_FILTER, $query);

    echo '<ul>';
    foreach($query as $filter){
      $part = explode(Listing::DEVIDE_SETTING,$filter);
      $detail = Listing::inputByFilter($part[0]);
      
      echo '<li>'.@$list[$part[0]].' '.@$detail['type'][$part[1]].' '.($detail['input_type'] == 'text' ? '&quot;'.htmlspecialchars($part[2]).'&quot;' : @$detail['content'][$part[2]]).'</li>';
    }
    echo '</ul>';
  } // end of constructor


} // end of List_Query
?>
