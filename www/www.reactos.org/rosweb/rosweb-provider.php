<?php
/*
  PROJECT:    ReactOS RosWeb Component for sharing layout and user information between website subsystems
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Counterpart to rosweb.php for providing the information by using Drupal-internal functions
  COPYRIGHT:  Copyright 2015 Colin Finck <colin@reactos.org>
*/

	function get_page_theme($theme)
	{
		// Adapted from drupal_render_page: First populate $page using element_info, finally use drupal_render on the array.
		// We modify the array here to render our theme only and remove the "html" wrapper template from processing.
		$page = element_info("page");
		$page["#theme"] = $theme;
		$page["#theme_wrappers"] = array();

		return drupal_render($page);
	}


	// Clear the $_GET array for Drupal
	$rosweb_query = array_key_exists("q", $_GET) ? $_GET["q"] : "";
	$_GET = array();

	// Set the $base_url for Drupal.
	// This is mandatory for all pathes to work properly with this bootstrapping method.
	$base_url = (array_key_exists("HTTPS", $_SERVER) && $_SERVER["HTTPS"] == "on" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];

	// Bootstrap Drupal.
	// This pollutes the global namespace with many Drupal-specific variables and functions and is the sole reason we have to use this provider approach.
	define("DRUPAL_ROOT", __DIR__ . "/..");
	chdir(DRUPAL_ROOT);
	require_once(DRUPAL_ROOT . "/includes/bootstrap.inc");
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


	switch($rosweb_query)
	{
		case "CurrentUser":
			$rosweb_user_info["id"] = $user->uid;
			$rosweb_user_info["mail"] = $user->mail;
			$rosweb_user_info["name"] = $user->name;
			die(json_encode($rosweb_user_info));

		case "Footer":
			die(get_page_theme("page__footerinc"));

		case "Header":
			die(get_page_theme("page__headerinc"));

		case "Sidebar":
			die(get_page_theme("page__sidebarinc"));
	}
