<?php
/**
 * @file
 * @ingroup SpecialPage
 */

require_once(ROSCMS_PATH . "lib/RosCMS_Autoloader.class.php");

/**
 * constructor
 */
function wfSpecialUserlogin( $par = '' ) {
	/* Login to RosCMS */
	$target = "/wiki";
	Subsystem_Wiki::in(Login::REQUIRED, $target);
	
	/* Just redirect us to the main page in case we were called but already logged in */
	header("Location: $target");
	exit;
}
