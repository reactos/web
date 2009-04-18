<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2005-2006  Klemens Friedl <frik85@reactos.org>

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


class About extends HTML
{



  protected function body( )
  {
    global $RSDB_intern_index_php;

    echo '
      <h1><a href="'.$RSDB_intern_index_php.'?page=about">ReactOS Compatability Database</a> &gt; About the ReactOS Support Database</h1> 
      <h2>About the ReactOS Support Database</h2> 
      <p>The ReactOS Support Database  (application and driver compatibility, application packages, developer network and media files) is a free service of the ReactOS Foundation.</p>
      <p>The ReactOS Support Database is maintained by the ReactOS Web-Team.</p>
      <p>&nbsp;</p>
      <h3>Credits</h3>
      <p><strong>Klemens Friedl:</strong> The ReactOS Support Database has been written from scratch by Klemens Friedl (frik85).</p>';
  } // end of member function body



} // end of About
