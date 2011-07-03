<?php
/**
 * AuthDrupal.php
 *
 * v 0.7.2 - 2010-12
 *   - fixed handling of usernames with underscores in them
 *   - fixed two typo bugs
 *
 * v 0.7.1 - 2010-03
 *   - fixed propagation of Drupal user roles to MW group membership
 * 
 * v 0.7 - 2010-03
 *
 *   - updated for Drupal 6.16 and Mediawiki 1.15.1
 *   
 *     Thanks to anarcat (Antoine Beaupré from koumbit.org) for code fixes
 *     for Mediawiki 1.13+
 *     This version will no longer work with MW 1.12 and before.
 *
 * v 0.6 - 2008-06
 *   - removed use of mcrypt/crypto.php and replaced with weaker home-grown
 *     username encoding.
 * 
 *   - made support for user roles optional, turned off by default, and now 
 *     allows only some roles to be propagated. (This is not well tested.)
 *     
 * 
 * v 0.5 - 2007-09
 *   - corrected return values from hook functions as suggested by anisotropic
 *     http://drupal.org/node/177258#comment-273705
 *
 *   - added support for pulling user roles from Drupal and setting them as
 *     group membership on the MW user object.
 *     updateUser() is now called for existing session as well as new session
 *     to ensure user roles are pulled fresh from Drupal.
 *
 *     additions to LocalSettings.php:
 *     - $wgAuthDrupal_RolesTable
 *     - $wgAuthDrupal_UsersRolesTable
 *
 *     replaced some references to $wgAuth inside methods with $this
 *
 * v 0.4 - 2007-0729
 *   - trivial update to match changes to Mediawiki.module
 *
 * v 0.3.2  - 2007-0727 (contrib from michaeljoseph AT gmail DOT com)
 *  - formatted code and standardised phpdoc comment style
 *  - tested with Drupal 5.1
 *  - small patch to MediaWiki user object creation code make it work withtested with MediaWiki 1.10.1
 *
 *  v 0.3.1 - 2007-0401
 *
 * Signin integration for MediaWiki as slave of Drupal user DB.
 *
 * Implemented/tested using Drupal 4.7.x and MediaWiki 1.9.2/1.9.3;
 * Please see accompanying README.txt.
 *
 * Original 2006/01/06 by Mitch Schwenk <tazzytazzy2 (at) yahoo (dot) com>
 * Rewrite, Jan-March 2007 by Maarten van Dantzich (drupal.org user maartenvd)
 *
 * Support for separate databases is based on Auth_phpBB.
 *
 * For the rewrite, I looked at (and borrowed code from):
 *
 * - Auth_Shibboleth (ShibAuth)
 *   http://meta.wikimedia.org/wiki/Shibboleth_Authentication
 *   and http://shibboleth.internet2.edu
 *
 * - LdapAuthentication.php by Ryan Lane <rlane32@gmail.com>
 *   http://meta.wikimedia.org/wiki/LDAP_Authentication
 *
 *
 * @version $Id$
 * @copyright 2007
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 *  59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 */

$wgExtensionCredits['parserhook'][] = array (
	'name' => 'AuthDrupal',
	'author' => 'Mitch Schwenk, Maarten van Dantzich',
	'url' => 'http://www.mediawiki.org/wiki/AuthDrupal',
);

require_once ( 'includes/AuthPlugin.php' );
require_once('AuthDrupalEncode.php');
	

/**
 * Setup function--call this from LocalSettings.php
 *
 * Args:
 *  cookie 'DRXtrArgs' set by Mediawiki.module during Drupal login
 *  global $wgAuthDrupal_ReplaceLogin, set in LocalSettings.php
 */
function SetupAuthDrupal() {
	global $wgAuthDrupal_ReplaceLogin;

	global $wgHooks;
	global $wgAuth;

	// If there is a Drupal cookie, install the user hook
	if (! empty( $_COOKIE["DRXtrArgs"] )) {
		// $wgHooks['AutoAuthenticate'][] = 'Auth_drupal_autologin_hook'; /* Hook for magical authN */
		$wgHooks['UserLoadFromSession'][] = 'Auth_drupal_autologin_hook';

		$wgHooks['UserLoadAfterLoadFromSession'][] = 'Auth_drupal_afteruserload_hook';


		if ( $wgAuthDrupal_ReplaceLogin )
			$wgHooks['PersonalUrls'][] = 'Auth_drupal_logoutlink_hook'; /* Disallow logout link */

		$wgAuth = new AuthDrupal();
	} else {
		// The cookie set by Drupal disappeared, so we should be logged out.

		// if there are cookies from a previous session, try to get rid of em
		authdrupal_StaticUserLogout();

		if ( $wgAuthDrupal_ReplaceLogin )
			$wgHooks['PersonalUrls'][] = 'Auth_drupal_loginlink_hook'; /* Hook to replace login link */
	}
}

/**
 * Function that handles MW AutoAuthenticate hook
 *
 * Use info passed by Drupal in DXtrArgs cookie to log the user in.
 * Modeled on SibAuthPlugin's AutoAuth() function
 *
 * the $return_user arg will normally be a reference to $wgUser
 * Not expected to return anything.
 */
function Auth_drupal_autologin_hook($user, &$result ) {
	global $wgUser;
	global $wgAuth;
	global $wgContLang;

	//! dbg wfDebug("##" . __FUNCTION__ . "\n");

	wfSetupSession();

	// Now lets check for drupal cookie
	$name = getCurrentDrupalUsername();

	if ( empty( $name ) ) {
		return false;
	}

/*** NEW CODE v0.7
 * 
 * Sketch for a rewrite based on newer Shibboleth Auth code
 *
	// see if that user exists in the wiki db
	$wiki_name = User::getCanonicalName( $name );
	$id = User::idFromName( $wiki_name );

	if ( $id ) {
	  // it's an existing user -- let mediawiki do the rest when the hook returns
	  // (will call wgUser->loadFromId() to fetch user from DB) 
	  $_SESSION['wsUserName'] = $wiki_name;
	  $_SESSION['wsUserID'] = $id;
	  return true;
	} 
	else {
	  // new user to add
	  // XXX YYY
	  wfDebug("   NEED TO ADD NEW USER");
	}
***/

	$user = User::newFromName( $name );

	// is it a new user?
	if ( 0 == $user->getID() ) {
		// we have a new user to add...
		$drupal_user = $wgAuth->getDrupalUser( $name );

		if ( empty( $drupal_user ) ) {
			wfDebug( __FUNCTION__ . " AuthDrupal ERROR: " . $name . " not found in Drupal DB \n" );
			return false;
		}

		//!dbg wfDebug( "AuthDrupal: logging in NEW user " . $name . "\n" );

		// this mimicks what LoginForm::initUser() does (code identical to
		// regular login moved down to common code)
		$user->setName( str_replace( '_', ' ', $wgContLang->ucfirst( $drupal_user->name ) ) );
		$user->addToDatabase();

		// Update user count in site stats (stolen from SpecialUserlogin)
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		// LoginForm::initUser() calls $wgAuth->initUser, but I don't see the point
		// $wgAuth->initUser( $u );
	} else {
		//wfDebug( "AuthDrupal: logging in existing user " . $name . "\n" );
	}

	// update email, real name, etc.
	$wgAuth->updateUser( $user );

	// Go ahead and log 'em in
	$user->setToken();
	$user->saveSettings();
	$user->setupSession();
	$user->setCookies();

	$message = 'MediWiki session (cookie) opened for <em>' . $name . '</em>.';
	$wgAuth->drupal_uid = $user->getID();
	$wgAuth->logit( $message );

	// we do not set $result here because we want loadFromSession to go ahead
	// and load the user object
	return true;
}

/*
 * anarcat: This code was stripped out because it was crashing MW,
 *    not sure what it's for, everything works without it, as long as you login on the Drupal directly.
 * 
 * thinkling: this is an optimization to use an existing user esession if the user was previously logged in 
 *    to the wiki. using this means you skip recreating cookies, etc and so will make for faster page loads. 
 *
 * belonged under the wfSetupSession() call.

	// Give us a user, see if we're around
	$tmpuser = User::newFromSession();
	// MJ: changed from $tmpuser->loadFromSession();
	$rc = $tmpuser->load();

	// If there's a prior session, check that it matches the current Drupal user
	if ($rc && $tmpuser->isLoggedIn()) {
		if ( $wgAuth->authenticate( $tmpuser->getName(), '' ) ) {
			//!dbg wfDebug("AuthDrupal: User " . $tmpuser->getName() . " already logged in\n");

			// update email, real name, etc.
			$wgAuth->updateUser( $tmpuser );

			return true;

		} else {
			// log out the existing user and continue below to start over
			$tmpuser->logout();

			// no return here--fall through to code below
		}
	}
*/

/**
 * Hook function to rewrite login link to point to Drupal instance
 */
function Auth_drupal_loginlink_hook( & $personal_urls, & $title ) {
	//!dbg wfDebug("##" . __FUNCTION__ . "\n");
	//!dbg wfDebug("AuthDrupal Login link hook: setting login" . "\n");

	//XXX replace ini_get with session_name() ?
	if ( $GLOBALS['wgShowIPinHeader'] && isset( $_COOKIE[ini_get( "session.name" )] ) ) {
		// shown for anonymous users without a session?
		$personal_urls['anonlogin'] = array (
			'text' => wfMsg( 'userlogin'	),
			'href' => $GLOBALS['wgAuthDrupal_LoginURL'] );
	} else {
		// shown for anonymous users with a session?
		$personal_urls['login'] = array (
			'text' => wfMsg('userlogin'	),
			'href' => $GLOBALS['wgAuthDrupal_LoginURL'] );
	}


	/* XXX Maarten: this is unfinished--message content should be loaded from a
	 * localizable file; for now, installers have to edit these messages by
	 *	hand via the associated message page.

		// Separately, replace the text that appears on the "You have to log in to
		// edit pages" page, when a non-logged-in user clicks an edit tab

		// replacing these messages:
		// MediaWiki:whitelistedittitle => 'Login required to edit',
	    // MediaWiki:whitelistedittext  => 'You have to $1 to edit pages.',

		global $wgMessageCache;
		$orig_msg = wfMsgGetKey('whitelistedittext');

		$wgMessageCache->addMessage('whitelistedittext',
			"You have to <a href='" . $GLOBALS['wgAuthDrupal_LoginURL']
			. "'>log in</a> to edit pages"
	 */
	 return true;
}

/**
 * Hook function to rewrite logout link to point to Drupal instance
 */
function Auth_drupal_logoutlink_hook(& $personal_urls, & $title) {
	//!dbg wfDebug("##" . __FUNCTION__ . "\n");
	//!dbg wfDebug("AuthDrupal Login link hook: setting logout" . "\n");

	$personal_urls['logout'] = array (
		'text' => wfMsg('userlogout' ),
		'href' => $GLOBALS['wgAuthDrupal_LogoutURL'] );

	return true;
}

/* 
 * UserLoadAfterLoadFromSession hook
 * 
 * We transfer Drupal roles to MW group membership here by adding them to mGroups
 * in the $wgUser object. Group membership does not get saved to the MW database.
 * 
 * MW 1.14+  
 * 
 */
function Auth_drupal_afteruserload_hook( $user ) 
{
	global $wgAuthDrupal_PropagateRoles;
	global $wgAuth;
	
	//!dbg 
	wfDebug("## " . __FUNCTION__ . "\n");

	if ( !empty( $wgAuthDrupal_PropagateRoles ) ) {
		$user->load();
		
		$name = $user->getName();
		$drupal_user = $wgAuth->getDrupalUser($name);
	
		if ( empty( $drupal_user ) ) {
			wfDebug( __FUNCTION__ . " AuthDrupal ERROR: " . $name . " not found in Drupal DB \n" );
			return true; // return error instead?
		}	

		// we load the user's Drupal roles into the MW groups array *transiently*.
		// Using $user->AddGroup() would save them into the MW database, and then
		// we'd have to worry about updating roles that have been removed.
		$d_roles = $wgAuth->getDrupalUserRoles($drupal_user);
		
		// if requested, filter which roles are propagated
		if ( !empty( $wgAuthDrupal_Roles ) ) {
			$d_roles = array_intersect( $d_roles, $wgAuthDrupal_Roles );
		}
		$user->mGroups = array_merge($user->mGroups, $d_roles);
	
		$user->getEffectiveGroups(true); // force update
		$user->mRights = null; // force rights update
	
		// wfDebug("## AuthDrupal Effective Groups after merge: " . var_export($user->getEffectiveGroups(true), true) . "\n");
		// wfDebug("## AuthDrupal Effective Rights after merge: " . var_export($user->getRights(), true) . "\n");
	}
	
	return true;
}

/**
 * Replacement login class which checks for a logged in Drupal user
 */
class AuthDrupal extends AuthPlugin {

	// Database Settings initialized in constructor
	/* private */
	var $db_table;
	/* private */
	var $db_prefix;
	/* private */
	var $drupal_users_tbl;
	/* private */
	var $drupal_log_table;

	var $drupal_logging;
	var $drupal_uid;

	var $my_dbr = NULL; // either the MW db or a separate db

	/**
	 * Constructor
	 */
	function AuthDrupal() {
		global $wgAuthDrupal_TablePrefix;
		global $wgAuthDrupal_UserTable;
		global $wgAuthDrupal_RolesTable;
		global $wgAuthDrupal_UsersRolesTable;
		global $wgAuthDrupal_LogMessages;
		global $wgAuthDrupal_UID;

		if (! empty( $wgAuthDrupal_LogMessages ) ) {
			$drupal_logging = $wgAuthDrupal_LogMessages;
		}

		if (! empty( $wgAuthDrupal_UID) ) {
			$drupal_uid = $wgAuthDrupal_UID;
		}

		$this->db_prefix = $wgAuthDrupal_TablePrefix;

		// $this->drupal_users_table = "`" . $this->db_prefix . $this->db_table . "`";
		// $this->drupal_log_table = "`" . $this->db_prefix . "watchdog`";
		$this->drupal_users_table = $this->makeDrupalTableName( $wgAuthDrupal_UserTable );
		$this->drupal_roles_table = $this->makeDrupalTableName( $wgAuthDrupal_RolesTable );
		$this->drupal_users_roles_table = $this->makeDrupalTableName( $wgAuthDrupal_UsersRolesTable );
		$this->drupal_log_table = $this->makeDrupalTableName( "watchdog" );

		return;
	}

	/**
	 * Returns a handle to the Drupal database, and creates one if it doesn't exist
	 */
	function getDB() {
		if ( empty( $this->my_dbr ) ) {
			$this->connectToDB();
		}

		return $this->my_dbr;
	}

	/**
	 * Connects to the Drupal database
	 */
	function connectToDB() {
		if ($GLOBALS['wgAuthDrupal_UseExtDatabase']) {
			// Drupal tables are in a separate DB from MW tables, create
			// a separate DB connection
			$this->my_dbr = & Database :: newFromParams(
					$GLOBALS['wgAuthDrupal_MySQL_Host'],
					$GLOBALS['wgAuthDrupal_MySQL_Username'],
					$GLOBALS['wgAuthDrupal_MySQL_Password'],
					$GLOBALS['wgAuthDrupal_MySQL_Database'],
					'auth_drupal_db_error_callback' );
		} else {
			$this->my_dbr = & wfGetDB(DB_SLAVE);
		}

		if (!$this->my_dbr->isOpen()) {
			wfDebug("AuthDrupal::connectToDB() : DB failed to open\n");
		}
	}

	/**
	 * Return entire user record from Drupal user table, so we can get at email, etc.
	 *
	 * @param string $username the name of the user to retrieve from the Drupal database
	 */
	function getDrupalUser($username) {
		$dbr = & $this->getDB();

		$qUsername = $dbr->addQuotes($username);
		return $dbr->selectRow(	$this->drupal_users_table,
								"*",
								"LCase(name)=LCase(CONVERT($qUsername USING latin1))",
								"AuthDrupal::getDrupalUser" );
	}

	function getDrupalUserRoles($drupal_user) {
	    $roles = array();

	    // this role is implicit in Drupal for logged-in users
	    $roles[] = 'authenticated user';

		$q = "SELECT r.rid, r.name FROM " . $this->drupal_roles_table . " r "
			. " INNER JOIN " . $this->drupal_users_roles_table . " ur "
			. " ON ur.rid = r.rid WHERE ur.uid = " . $drupal_user->uid;

		$dbr = & $this->getDB();
		$res = $dbr->query($q, __METHOD__);

		if ( $res !== false ) {
			if ( !$dbr->numRows($res) ) {
				$dbr->freeResult($res);
			}
			else {
				$rows = array();
				while ( $row = $dbr->fetchRow( $res ) ) {
					$roles[] = $row['name'];
				}
				$dbr->freeResult( $res );
			}
		}

	    return $roles;
	}

	/**
	 * Log message to drupal watchdog database if $this->drupal_logging = true;
	 *
	 * @param UserLoginTemplate $template
	 * @access public
	 */
	function logit($message, $severity = 0, $id = 0) {

		if (!$this->drupal_logging)
			return;

		if ( empty( $this->drupal_uid) )
			$uid = $id;
		else
			$uid = $this->drupal_uid;

		$dbr = & $this->getDB();
		$inRes = $dbr->insert(	$this->drupal_log_table,
								array (
									'uid' => $uid,
									'type' => 'user',
									'message' => $message,
									'severity' => $severity,
									'link' => " ",
									'location' => 'no imp yet',
									'hostname' => $_SERVER["REMOTE_ADDR"],
									'timestamp' => time() ),
								"AuthDrupal::watchdog" );
	}

	/**
	 * BELOW HERE CODE IS STANDARD AuthPlugin CLASS METHODS
	 *
	 * Functions that we do not need to override are not included here, they
	 * can be found in includes/AuthPlugin.php
	 *
	 * Comments above each function are from AuthPlugin.php.
	 * I've documented my understanding of the use of each function--Maarten.
	 *
	 */

	/**
	 * Check whether there exists a user account with the given name.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param $username String: username.
	 * @return bool
	 * @public
	 */
	function userExists($username) {
		// Maarten: since we disable MW's own login and only log in users that
		//   exist in Drupal, this check is unnecessary in our scenario. It's
		//   normally used by plugins that respond to login from MW's own
		//   login form (SpecialUserlogin)

		//!dbg wfDebug("##" . __METHOD__ . "\n");

		return true;
	}

	/**
	 * Check if a username+password pair is a valid login.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * Maarten: I believe in most AuthPlugin modules, authenticate() is
	 * called with the information entered in MW's UserLogin form, assuming
	 * you're retaining the MW login UI and just checking a different DB.
	 * Instead, we use external login UI and real authentication happens in
	 * code elsewhere (in Drupal).
     *
	 * At this point, authenticate() becomes a security/sanity check; see
	 * code for both LDAP_Authenticate and Shibolleth.
     *
 	 * from #mediawiki: Ryan_Lane: You should add a paranoia check. You
	 * need to ensure the username that is given to the authenticate method
	 * is the same one your webserver gets. I put one in specifically to
	 * ensure the plugin isn't getting fooled.
	 *
	 * @param $username String: username.
	 * @param $password String: user password.
	 * @return bool
	 * @public
	 */
	function authenticate($username, $password) {
		//!dbg wfDebug("##" . __METHOD__ . "\n");

		// as a sanity check, we'll re-check that the user getting logged in is
		// the same that was passed by Drupal in its cookie

		$name = getCurrentDrupalUsername();

		// ignore case since wiki wants first letter upcase and drupal does not
		$same = (0 === strcasecmp($username, $name));

		if (!$same) {
			wfDebug("AuthDrupal: ERROR: authenticate() called with mismatched username: "
				. "wiki=" . $username . " vs cookie=" . $name . "\n");
		}

		return $same;
	}

	/**
	 * When a user logs in, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * Maarten: this is our chance to pull info out of the Drupal database
	 * and update it in MW's user table, e.g. in case the user's email address
	 * or real name has changed
	 * @param User $user
	 * @public
	 */
	function updateUser(& $user) {
		// wfDebug("##" . __METHOD__ . "\n"); //!dbg

		$user->load();

		$name = $user->getName();
		$drupal_user = $this->getDrupalUser($name);

		if ( empty( $drupal_user ) ) {
			wfDebug( __FUNCTION__ . " AuthDrupal ERROR: " . $name . " not found in Drupal DB \n" );
			return;
		}

		/* XXX replication of Drupal passwords in MW database disabled for now;
		   XXX wasn't actually working & I don't need it --Maarten

		                // we do not use user->setPassword(), because
		                //
		                // (a) that will call AuthPlugin::allowPasswordChange() which returns
		                // false to disable user editing of passwords in the Prefs form, and
		                // (b) that would re-encrypt the password, while we just want to save
		                // the previously md5'd password that's in the Drupal table

		                // See http://bugzilla.wikimedia.org/show_bug.cgi?id=8815 for discussion
		                // and note that semantics of some of the methods involved may change in
		                // future versions of MW

		                $user->mPassword =  $drupal_user->pass;
		                $user->mNewpassword = '';
		                $user->mNewpassTime = null;
		*/
		$user->mPassword = 'bogusPassword'; // not something a hash will match
		$user->mNewpassword = '';
		$user->mNewpassTime = null;

		$user->setRealName( $this->getDrupalRealname( $drupal_user->uid ) );
		$user->setEmail( $drupal_user->mail );
		$user->mEmailAuthenticated = wfTimestampNow();

		$user->saveSettings();

		return true;
	}

	/**
	 * Return true if the wiki should create a new local account automatically
	 * when asked to login a user who doesn't exist locally but does in the
	 * external auth database.
	 *
	 * If you don't automatically create accounts, you must still create
	 * accounts in some way. It's not possible to authenticate without
	 * a local account.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * Maarten: not sure if this is necessary since we explicitly add new users
	 * to the MW database in the AuthAuthenticate hook handler
	 *
	 * @return bool
	 * @public
	 */
	function autoCreate() {
		//!dbg wfDebug("##" . __METHOD__ . "\n");

		return true;
	}

	/**
	 * Can users change certain preferences?
	 *
	 * NOTE: to block user from changing password, return false from
	 * AuthPlugin::allowPasswordChange()
	 *
	 * Value set to true means "disallow editing of this field"
	 * Assumes fields are editable unless specified otherwise.
	 *
	 * e.g.: return array( 'wpRealName' => true );
	 *
	 * Returns all disallowed fields at once to avoid having to call this
	 * once for each field on the prefs form.
	 *
	 * @return array ( $key => boolean )
	 */
	function disallowPrefsEditByUser() {
		return array (
			'wpRealName' => true,
			'wpUserEmail' => true,
			'wpNick' => true
		);
	}

	/**
	 * Can users change their passwords?
	 * Maarten: we force users to do this on the Drupal side.
	 *
	 * @return bool
	 */
	function allowPasswordChange() {
		//!dbg wfDebug("##" . __METHOD__ . "\n");

		return false;
	}

	/**
	 * Set the given password in the authentication database.
	 * As a special case, the password may be set to null to request
	 * locking the password to an unusable value, with the expectation
	 * that it will be set later through a mail reset or other method.
	 *
	 * Maarten: we do not allow password changes to originate in the wiki and
	 * propagate back to Drupal. Note that returning false here will make
	 * User::setPassword fail to complete as well, at least in 1.9.x
	 *
	 * Return true if successful.
	 *
	 * @param $user User object.
	 * @param $password String: password.
	 * @return bool
	 * @public
	 */
	function setPassword( $user, $password ) {
		return false;
	}

	/**
	 * Return true to prevent logins that don't authenticate here from being
	 * checked against the local database's password fields.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * Maarten: in no case do we want to authenticate against MW's user table,
	 * so this should return true
     *
	 * @return bool
	 * @public
	 */
	function strict() {
		//!dbg wfDebug("##" . __METHOD__ . "\n");

		return true;
	}

	/**
	 * When creating a user account, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param $user User object.
	 * @public
	 */
	function initUser( & $user ) {
		//!dbg wfDebug("##" . __METHOD__ . "\n");
		// XXX TODO: set notification defaults and such
	}

	/**
	 * If you want to munge the case of an account name before the final
	 * check, now is your chance.
	 */
	function getCanonicalName( $username ) {
		//!dbg wfDebug("##" . __METHOD__ . "\n");

		global $wgContLang;
		return $wgContLang->ucfirst( $username );
	}

	function makeDrupalTableName($table) {
		return "`" . $this->db_prefix . $table . "`";
	}

	function getDrupalRealname( $drupal_uid ) {
		global $wgAuthDrupal_GetRealNames;
		global $wgAuthDrupal_RealNames_fields_table; // set if different than 'profile_fields'
		global $wgAuthDrupal_RealNames_values_table; // set if different than 'profile_values'
		global $wgAuthDrupal_RealNames_first_name_field; // set if different than 'profile_first_name'
		global $wgAuthDrupal_RealNames_last_name_field; // set if different than 'profile_last_name'

		if ( ! $wgAuthDrupal_GetRealNames || 0 == $drupal_uid )
			return '';

		if ( ! empty($wgAuthDrupal_RealNames_fields_table) ) {
			$fields_table = $this->makeDrupalTableName( $wgAuthDrupal_RealNames_fields_table );
		} else {
			$fields_table = $this->makeDrupalTableName('profile_fields');
		}

		if ( ! empty($wgAuthDrupal_RealNames_values_table) ) {
			$values_table = $this->makeDrupalTableName( $wgAuthDrupal_RealNames_values_table );
		} else {
			$values_table = $this->makeDrupalTableName('profile_values');
		}

		if ( ! empty($wgAuthDrupal_RealNames_first_name_field) ) {
			$fname_field = $wgAuthDrupal_RealNames_first_name_field;
		} else {
			$fname_field = "profile_first_name";
		}

		if ( ! empty($wgAuthDrupal_RealNames_last_name_field) ) {
			$lname_field = $wgAuthDrupal_RealNames_last_name_field;
		} else {
			$lname_field = "profile_last_name";
		}

		$dbr = & $this->getDB();

		if ( ! $dbr->tableExists( $fields_table ) ) {
			wfDebug("##" . __METHOD__ . "ERROR : table " . $fields_table . " not found in DB\n");
			return '';
		}

		$fid_fname = $dbr->selectRow( 	$fields_table,
										array ( 'fid' ),
										array ( 'name' => $fname_field ),
										__METHOD__ );

		$fid_lname = $dbr->selectRow(	$fields_table,
										array ( 'fid' ),
										array ( 'name' => $lname_field ),
										__METHOD__ );

		if (false === $fid_fname || false === $fid_lname) {
			wfDebug("##" . __METHOD__ . "ERROR : could not find name field in profile table");
			return '';
		}

		$fname = $dbr->selectRow(	$values_table,
									array ( 'value' ),
									array ( 'fid' => $fid_fname->fid,
											'uid' => $drupal_uid ),
									__METHOD__ );

		$lname = $dbr->selectRow(	$values_table,
									array ( 'value' ),
									array ( 'fid' => $fid_lname->fid,
											'uid' => $drupal_uid ),
									__METHOD__);

		return $fname->value . ' ' . $lname->value;
	}
}

/**
 * Database error callback function
 */
function auth_drupal_db_error_callback($db_obj, $error) {
	wfDebug( __FUNC__ . " - ERROR: " . $error . "\n" );
}

/**
 * Utility functions for decoding cookie with username
 *
 * Does a check against an obfuscated version to verify that the username
 * was actually set by our code on the Drupal side, and not being spoofed 
 * by a malicious end user.
 * 
 */
function getCurrentDrupalUsername() {
    $plaintext_name = $_COOKIE["DRXtrArgs"];
	$encoded_name = $_COOKIE["DRXtrArgs2"];
	
	if ( authdrupal_encode( $plaintext_name ) == $encoded_name ) {
		return $plaintext_name;
	}
	else {
		return null;	
	}
}
?>
