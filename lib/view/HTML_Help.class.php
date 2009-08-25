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


class HTML_Help extends HTML
{



  protected function body( )
  {
    global $RSDB_intern_link_db_sec;
    global $RSDB_intern_index_php;

    echo '
      <h1><a href="'.$RSDB_intern_link_db_sec.'home">Compatibility</a> &gt; Help &amp; FAQ</h1> 

      <p>&nbsp;</p>
      <h2><a name="faq"></a>FAQ</h2>
      <p>This FAQ answers questions related to the usage of the Compatibility Database. </p>

        <p><strong>Q: What is the Compatibility Database? </strong></p>
        <p><strong>A: </strong> The Compatibility Database is a repository for  application and driver compatibility information with ReactOS. In particular it provides the following information: </p>
        <ul>
          <li>Whether a given application works at all with ReactOS.</li>
          <li>If it is partially working, then which areas of the application have problems.</li>
          <li>How to install and get that application working best. </li>
        </ul>
          <p><strong>Q: What is ReactOS? </strong></p>
          <p><strong>A: </strong>More information can be found at the <a href="http://www.reactos.org/?page=about_whatisreactos">What is ReactOS?</a> and at the <a href="http://www.reactos.org/?page=about_userfaq">User FAQ</a> pages.    </p>
          <p><strong>Q: What are the benefits of this Compatibility Database? </strong></p>
          <p><strong>A: </strong> The Compatibility Database benefits both ReactOS developers and users. It lets ReactOS developers know which applications regressed. And it lets ReactOS user know  if their application will work in ReactOS.</p>
          <p><strong>Q: How does a new application get added to the database? </strong></p>
          <p><strong>A: </strong> Every registered user can submit new applications or driver, version information, test reports, etc. </p>
          <p><strong>Q: How can I submit Screenshots? </strong></p>
          <p><strong>A: </strong> Click on the &quot;submit screenshot&quot; (or similar) link on the related page. </p>
          <p><strong>Q: How can I submit How-to\'s? </strong></p>
          <p><strong>A: </strong>Please use the comment function to add those info. </p>
          <p><strong>Q: Why isn\'t my favorite Windows application in the database? </strong></p>
          <p><strong>A: </strong>Probably because no one has submitted it to the database yet. We\'d love it if you would <a href="'.$RSDB_intern_link_db_sec.'submit">submit the application to the database</a>.  </p>
          <p> <strong>Q: If I don\'t see a Windows application in the database, does that mean that it won\'t run in ReactOS? </strong></p>
          <p> <strong>A:</strong> Not necessarily. Many applications work perfectly in ReactOS without any modification whatsoever. However, we may simply not be aware of them. So, just because an application isn\'t in our database doesn\'t mean that your application won\'t run. We\'d love it if you would <a href="'.$RSDB_intern_link_db_sec.'submit">submit the application to the database</a>. </p>
          <p> <strong>Q: If I don\'t see my favorite application here, what\'s the easiest way to find out if it will run in ReactOS or not? </strong></p>
        <p> <strong>A:</strong> <a href="http://www.reactos.org/?page=download">Download ReactOS</a> and find out. That is by far the fastest, easiest way to answer this question. Regardless of whether the answer is "yes" or "no", we\'d love it if you would <a href="'.$RSDB_intern_link_db_sec.'submit">submit the application to the database</a>. </p>
';
  } // end of member function body



} // end of Help
