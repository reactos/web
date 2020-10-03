<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     The admin panel for RosLogin
 * COPYRIGHT:   Copyright 2020 Mark Jansen (mark.jansen@reactos.org)
 */

	//
	// INCLUDES
	//
	define("ROOT_PATH", "../../");
	require_once("../RosLogin.php");
	require_once("RosAdmin.php");

	require_once(ROOT_PATH . "rosweb/rosweb.php");
	$rw = new RosWeb();

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


	// If the user does not have moderation rights, or is not logged in,
	// this will block them from going any further!
	$ra = new RosAdmin();

	try
	{
		if (array_key_exists("a", $_REQUEST))
		{
			spl_autoload_register("load_action_class");
			switch ($_REQUEST["a"])
			{

				case "unban":
					$action = new UnbanAction();
					break;

				case "ban":
					$action = new BanAction();
					break;

				default:
					throw new RuntimeException("Invalid action");
			}

			$action->perform($ra);
		}
		else if (array_key_exists("p", $_REQUEST))
		{
			spl_autoload_register("load_page_class");
			switch ($_REQUEST["p"])
			{
				case "home":
					$page = new AdminPage($ra);
					break;

				case "user":
					$page = new UserPage($ra);
					break;

				default:
					throw new RuntimeException("Invalid page");
			}

			require_once("../page.php");
		}
		else
		{
			// Redirect to the Login page if this file was called without any arguments.
			redirect_to("?p=home");
		}
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}
