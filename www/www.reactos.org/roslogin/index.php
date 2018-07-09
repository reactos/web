<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     The entry point for all actions and pages
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	//
	// INCLUDES
	//
	require_once("config.inc.php");
	require_once("languages.inc.php");
	require_once("RosLogin.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	//$rw = new RosWeb($supported_languages);
	$rw = new RosWeb();
	$lang = $rw->getLanguage();
	require_once("lang/$lang.inc.php");

	//
	// FUNCTIONS
	//
	function load_action_class($class)
	{
		require_once("actions/{$class}.php");
	}

	function load_page_class($class)
	{
		require_once("pages/{$class}.php");
	}

	function is_valid_redirect($url)
	{
		// As a user may come from e.g. the Wiki, we have to support a lot of characters inside redirect URLs.
		// However, there are a few exceptions that guard us from potential attacks.

		// First of all, the trimmed redirect URL mustn't be empty.
		$url = trim($url);
		if (empty($url))
			return FALSE;

		// It also has to begin with either '?' (for RosLogin-internal URLs) or '/' (for site-local URLs).
		if ($url{0} != '?' && $url{0} != '/')
			return FALSE;

		// Prevent redirections to external sites (prefixed by '//').
		if (substr($url, 0, 2) == '//')
			return FALSE;

		// A redirect URL also mustn't contain arrow brackets.
		// This loosely guards against XSS attacks when $url is potentially inserted unescaped in some place.
		if (preg_match('#<>#', $url))
			return FALSE;

		return TRUE;
	}

	function redirect_to($url)
	{
		header("Location: {$url}");
		exit;
	}


	//
	// ENTRY POINT
	//

	// Redirect all plain HTTP requests to secure HTTPS URLs.
	if (!array_key_exists("HTTPS", $_SERVER) || $_SERVER["HTTPS"] != "on")
		redirect_to("https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);

	try
	{
		if (array_key_exists("a", $_REQUEST))
		{
			spl_autoload_register("load_action_class");
			switch ($_REQUEST["a"])
			{
				case "login":
					$action = new LoginAction();
					break;

				case "logout":
					$action = new LogoutAction();
					break;

				case "register":
					$action = new RegisterAction();
					break;

				case "register_complete":
					$action = new RegisterCompleteAction();
					break;

				case "reset_password":
					$action = new ResetPasswordAction();
					break;

				case "reset_password_complete":
					$action = new ResetPasswordCompleteAction();
					break;

				case "send_username":
					$action = new SendUsernameAction();
					break;

				case "selfservice_save":
					$action = new SelfServiceSaveAction();
					break;

				default:
					throw new RuntimeException("Invalid action");
			}

			$action->perform();
		}
		else if (array_key_exists("p", $_REQUEST))
		{
			spl_autoload_register("load_page_class");
			switch ($_REQUEST["p"])
			{
				case "confirm":
					$page = new ConfirmPage();
					break;

				case "forgot":
					$page = new ForgotPage();
					break;

				case "login":
					$page = new LoginPage();
					break;

				case "message":
					$page = new MessagePage();
					break;

				case "register":
					$page = new RegisterPage();
					break;

				case "selfservice":
					$page = new SelfServicePage();
					break;

				default:
					throw new RuntimeException("Invalid page");
			}

			require_once("page.php");
		}
		else
		{
			// Redirect to the Login page if this file was called without any arguments.
			redirect_to("/roslogin/?p=login");
		}
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}
