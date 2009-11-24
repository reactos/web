<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2009       Danny Götte <dangerground@web.de>

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

/**
 * @package html
 */
class StatusUtil
{


  public static function getClass($status) {
    switch ($status) {
      case 'full': return 'stable'; break;
      case 'part': return 'unstable'; break;
      case 'not':  return 'nonwork'; break;
      default:     return 'crash'; break;
    }
  }
  
  
  public static function getTitle($status) {
  
    switch ($status) {
      case 'full': return 'runs correctly without major problems'; break;
      case 'part': return 'works with minor issues, not preventing its use'; break;
      case 'not':  return 'doesn\'t start or has issues preventing its use'; break;
      default:     return 'either the software or ROS itself crash or become unresponsive'; break;
    }
  }
} // end of HTML
?>
