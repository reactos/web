<?php
/**
 * See README for installation and usage
 */

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

if ( !defined( 'MEDIAWIKI' ) and !defined('BUGZILLAREPORTS')  ) {
	die('This file is a MediaWiki extension, it is not a valid entry point' );
}
if ( !method_exists('ParserOutput','addHeadItem') ) {
	die('Sorry, but your MediaWiki version is too old for BugzillaReports, please upgrade to the latest MediaWiki version.' );  
}
$wgBugzillaReportsIncludes = dirname(__FILE__) . '/';

#
# Set up autoloading
#
$wgAutoloadClasses['BMWExtension']=
	$wgBugzillaReportsIncludes."BMWExtension.php";
$wgAutoloadClasses['BSQLQuery']=
	$wgBugzillaReportsIncludes."BSQLQuery.php";
$wgAutoloadClasses['BugzillaQuery']=
	$wgBugzillaReportsIncludes."BugzillaQuery.php";
$wgAutoloadClasses['BMysqlConnector']=
	$wgBugzillaReportsIncludes."BMysqlConnector.php";
$wgAutoloadClasses['BPGConnector']=
	$wgBugzillaReportsIncludes."BPGConnector.php";
$wgAutoloadClasses['BugzillaReport']=
	$wgBugzillaReportsIncludes."BugzillaReport.php";
$wgAutoloadClasses['BugzillaQueryRenderer']=
	$wgBugzillaReportsIncludes."BugzillaQueryRenderer.php";

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'BugzillaReports',
        'version' => '1.1',
        'url' => 'http://www.mediawiki.org/wiki/Extension:Bugzilla_Reports',
        'author' => '[http://bemoko.com/bemoko/i/page/ian-homer Ian Homer]',
        'description' => 'Provide bugzilla reports'
);

$wgExtensionFunctions[] = 'efBugzillaReportsSetup';
$wgExtensionMessagesFiles['BugzillaReports'] = $wgBugzillaReportsIncludes.
	'/BugzillaReports.i18n.php';

$wgHooks['LanguageGetMagic'][]       = 'efBugzillaReportsMagic';

$bzScriptPath = $wgScriptPath . '/extensions/BugzillaReports';

/**
 * Register the function hook
 */
function efBugzillaReportsSetup() {
	global $wgParser;
	$wgParser->setFunctionHook( 'bugzilla', 'efBugzillaReportsRender' );
}
 
/**
 * Register the magic word
 */
function efBugzillaReportsMagic( &$magicWords, $langCode ) {
	$magicWords['bugzilla'] = array( 0, 'bugzilla' );
	return true;
}
 
/**
 * Call to render the bugzilla report
 */
function efBugzillaReportsRender( &$parser) {
	$bugzillaReport = new BugzillaReport( $parser );
	$args = func_get_args();
	array_shift( $args );
	return $bugzillaReport->render($args);
}
?>
