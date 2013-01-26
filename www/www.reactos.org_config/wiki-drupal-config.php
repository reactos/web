<?php
######################################################################
# User authentication via Drupal using AuthDrupal
# AuthDrupal v 0.7, 2010-03-01

// disable registration and sign-in from the wiki front page
$wgGroupPermissions['*']['edit'] = false; // MediaWiki 1.5+ Settings
$wgGroupPermissions['*']['createaccount'] = false; // MediaWiki 1.5+ Settings

$wgCookieDomain = '';
$GLOBALS['wgCookieSecure'] = false;
//
// Replace this key string with something non-trivial to prevent
// user login spoofing. Make it hardto guess, as if it is a password.
// 
// YOU MUST CHANGE THIS to something unique to your site and it must
// match this setting in Mediawiki.module
$wgAuthDrupal_security_key = $GLOBALS['wgAuthDrupal_security_key']= '';

// is Drupal in a different database than Mediawiki?
$wgAuthDrupal_UseExtDatabase = true;

//NOTE: You only need the next four settings if you set $wgAuthDrupal_UseExtDatabase to true.
$wgAuthDrupal_MySQL_Host     = "localhost";      // Drupal MySQL Host Name.
$wgAuthDrupal_MySQL_Username = '';        // Drupal MySQL Username.
$wgAuthDrupal_MySQL_Password = '';    // Drupal MySQL Password.
$wgAuthDrupal_MySQL_Database = '';           // Drupal MySQL Database Name.

$wgAuthDrupal_TablePrefix      = "";
$wgAuthDrupal_UserTable     = 'users';        // name of drupal user table without prefix; normally 'users'
$wgAuthDrupal_RolesTable     	= 'role';       // Name of your Drupal user table. (normally 'role')
$wgAuthDrupal_UsersRolesTable	= 'users_roles'; // Name of your Drupal user table. (normally 'users_roles')


// $wgAuthDrupal_GetRealNames :
// Drupal's default user table schema does not include a field for real names
// If you use Drupal's profile.module and add fields profile_first_name and
// profile_last_name, the Auth Module can copy the names into the user's
// wiki profile
$wgAuthDrupal_GetRealNames = false;

// $wgAuthDrupal_PropagateRoles :
// Set this to true if you want Drupal user roles to be turned into Mediawiki
// group membership. If you want ALL roles to be turned into groups, leave
// $wgAuthDrupal_Roles empty. You can limit the roles that should be propagated 
// by setting $wgAuthDrupal_Roles to an array containing names of roles to be
// propagated, like $wgAuthDrupal_Roles = array( 'staff', 'member' );
$wgAuthDrupal_PropagateRoles = false;
$wgAuthDrupal_Roles = null;  // null means propagate all roles

// You probably do not need to change these
// $wgAuthDrupal_RealNames_fields_table; // set if different than 'profile_fields'
// $wgAuthDrupal_RealNames_values_table; // set if different than 'profile_values'

// $wgAuthDrupal_RealNames_first_name_field; // set if different than 'profile_first_name'
// $wgAuthDrupal_RealNames_last_name_field;  // set if different than 'profile_last_name'

// set to false to retain wiki's own login/logout
$wgAuthDrupal_ReplaceLogin = true;

// if ReplaceLogin is true, set these URLs to appropriate targets:
$wgAuthDrupal_LoginURL = '/user/login';
$wgAuthDrupal_LogoutURL = '/user/logout';

// Do you want status messages in your Drupal watchdog log?
$wgAuthDrupal_LogMessages = false;

/* For each wiki that shares the Drupal login front end, create a set
 * of settings here that matches what you have in LocalSettings.php for
 * the same variable FOR THAT WIKI.
 */
$GLOBALS['wgAuthDrupal_wiki_settings'] = array (

		// settings for wiki 1  (i.e. copy values from wiki1/LocalSettings.php)
		array(
			'wgCookieDomain' 	=> $wgCookieDomain,
			'wgDBname' 		=> 'drupal',
			'wgDBprefix' 		=> '',

			// **IF** you set wgCookiePath in wiki/LocalSettings, set it to
			// the same thing here; if don't see it in wiki/LocalSettings.php,
			// leave it alone.
			'wgCookiePath' 		=> '/',
			//'wgCookieSecure' => $wgCookieSecure,
			'wgCookiePrefix'	=> '',
		)

	);

