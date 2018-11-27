<?php
/*
  PROJECT:    ReactOS RosWeb Component for sharing layout and user information between website subsystems
  LICENSE:    GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
  PURPOSE:    Counterpart to rosweb.php for providing the information by using Drupal-internal functions
  COPYRIGHT:  Copyright 2015-2018 Colin Finck <colin@reactos.org>
*/

	function get_page_theme($theme, $wrapper)
	{
		// This function is mostly a copied drupal_render_page.
		// But we modify the array here to render our desired theme and wrapper.
		$page = element_info("page");
		$page["#theme"] = $theme;
		$page["#theme_wrappers"] = $wrapper;

		foreach (module_implements('page_build') as $module)
		{
			$function = $module . '_page_build';
			$function($page);
		}

		drupal_alter('page', $page);
		return drupal_render($page);
	}


	// Save the variables from our query string
	$rosweb_part = $_GET["part"];

	// Recreate the $_GET array with only the "q" variable propagated to Drupal.
	// This lets Drupal know about the page language we're accessing.
	$_GET = array("q" => $_GET["q"]);

	// Set the $base_url for Drupal.
	// This is mandatory for all pathes to work properly with this bootstrapping method.
	$protocol = (array_key_exists("HTTPS", $_SERVER) && $_SERVER["HTTPS"] == "on") ? "https" : "http";
	$base_url = $protocol . "://" . $_SERVER["HTTP_HOST"];

	// Bootstrap Drupal.
	// This pollutes the global namespace with many Drupal-specific variables and functions and is the sole reason we have to use this provider approach.
	define("DRUPAL_ROOT", __DIR__ . "/..");
	chdir(DRUPAL_ROOT);
	require_once(DRUPAL_ROOT . "/includes/bootstrap.inc");
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


	switch($rosweb_part)
	{
		case "CurrentUser":
			$rosweb_user_info["id"] = $user->uid;
			$rosweb_user_info["mail"] = $user->mail;
			$rosweb_user_info["name"] = $user->name;
			die(json_encode($rosweb_user_info));

		case "Footer":
			die(get_page_theme("page__roswebfooter", array()));

		case "Head":
			die(get_page_theme("page", array("html__roswebhead")));

		case "Header":
			die(get_page_theme("page__roswebheader", array()));
	}
