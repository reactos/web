<?php
#
# This script is a demonstration of how you can use the Bugzilla Reports 
# module outside of MediaWiki.  Although the standard usage is within 
# MediaWiki and this does give great control of integrating your reports 
# with your content, you may wish to include these reports within any other
# kind of PHP application.  Well here you go ... a quick example for you and
# then the World's your oyster ...
#

/**
 * Copyright (C) 2008 - Ian Homer & bemoko
 *
 * This program is free software; you can redistribute it and/or modify it 
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) 
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for    
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along 
 * with this program; if not, see <http://www.gnu.org/licenses>.
 */

require_once("init.php");

#
# Uncomment the following and set your configuration parameters to enable 
# standalone reports outside of MediaWiki and in your PHP application of your
# choice
#
#define('BUGZILLAREPORTS',1);
#$bzScriptPath="";
#$wgBugzillaReports = array(
#	'host'		=> "localhost",
#	'database'	=> "bugs",
#	'user'		=> "bugs",
#	'password'	=> "password",
#	'bzserver'  => "http://myserver",
#	'maxrows'	=> "300"
#);
if ( !defined('BUGZILLAREPORTS')  ) {
	die('This Bugzilla Reports script has not been enabled' );
}

$parser=new BParser();
$bugzillaReport = new BugzillaReport( $parser );
$bugzillaReport->setRawHTML(true);

#
# See http://www.mediawiki.org/wiki/Extension:Bugzilla_Reports#Usage for
# documentation on parameters available
#

$out=$bugzillaReport->render(array("priority=P1,P2","lastcomment=1"));
?>
<html>
  <head>
	<?=$parser->mOutput->head?>
  </head>
  <body>
	<?=$out?>
  </body>
</html>
