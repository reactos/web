<?php

/*
 * AuthDrupalEncode.php
 * 
 * This produces an obfuscated string that is meant to be hard to spoof and
 * thus verifies that the login is legitimate.
 * 
 * The best way to do this would be to encrypt the username on the Drupal
 * side, transmit an encrypted string, and decrypt it here. However, haven't
 * found a portable encryption alternative. md5() and crypt() are both one-way
 * and cannot be de-crypted. mcrypt() is not installed with PHP by default, 
 * so many servers do not have it. 
 */


function authdrupal_encode($plain_string)
{
	// Admin must set the key to something unique to their site to prevent this
	// technique from being trivially spoofable--so refuse to encode if the 
	// key is unchanged
	if ( empty( $GLOBALS['wgAuthDrupal_security_key'] ) 
	     || ( 'ReplaceThisString' == $GLOBALS['wgAuthDrupal_security_key'] ) ) {
	     	return null;
	}
	
	// concatenate the given string with the secret key
	$str = $plain_string . $_SERVER["REMOTE_ADDR"] . $GLOBALS['wgAuthDrupal_security_key'];

	// sort the characters
	$a = str_split( $str, 1 );
	sort( $a, SORT_STRING );

	// turn back into string and scramble with md5()
	return md5( implode( '', $a ) );
}

/**
 * StaticUserLogout
 *
 * Can't call User object functions from SetupAuthDrupal() because User.php
 * has not been included at that point. Hence, this is the code from
 * User::logout(), commenting out code that depends on having an actual User
 * object
 */

function authdrupal_StaticUserLogout($dbname = null, $dbprefix = null, $path = null, $domain = null, $cookie_secure = null) 
{
	if (is_null($dbname)) {
	    $prefix = $GLOBALS['wgDBname'];
	}
	if (is_null($dbprefix)) {
		$prefix = $GLOBALS['wgDBprefix'];
	}
	if (is_null($path)) {
		$path = $GLOBALS['wgCookiePath'];
	}
	if (is_null($domain)) {
		$domain = $GLOBALS['wgCookieDomain'];
	}
	if (is_null($cookie_secure)) {
	    $cookie_secure = $GLOBALS['wgCookieSecure'];
	}

	// this lifted from wiki/includes/Setup.php which hasn't been included
	// when we need these
	if ( ! empty($dbprefix) ) {
		$prefix = $dbname . '_' . $dbprefix;
	} else {
		$prefix = $dbname;
	}

        $GLOBALS['wgCookiePrefix'] = $prefix; // not sure this is necessary

	setcookie( $prefix . '_session', '', time() - 3600, $path, $domain, $cookie_secure );

	setcookie( $prefix . 'UserName', '', time() - 3600, $path, $domain, $cookie_secure );
	setcookie( $prefix . 'UserID',   '', time() - 3600, $path, $domain, $cookie_secure );
	setcookie( $prefix . 'Token',    '', time() - 3600, $path, $domain, $cookie_secure );

	// Remember when the user logged out, to prevent seeing cached pages
	$ts_now = gmdate('YmdHis', time()); // emulates wfTimestampNow()
	setcookie( $prefix . 'LoggedOut', $ts_now, time() + 86400, $path, $domain, $cookie_secure );
}
