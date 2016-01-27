<?php
/*
  PROJECT:    ReactOS RosWeb Component for sharing layout and user information between website subsystems
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Counterpart to rosweb.php for providing the information by using Drupal-internal functions
  COPYRIGHT:  Copyright 2015 Colin Finck <colin@reactos.org>
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
	$rosweb_tls = $_GET["tls"];

	// Recreate the $_GET array with only the "q" variable propagated to Drupal.
	// This lets Drupal know about the page language we're accessing.
	$_GET = array("q" => $_GET["q"]);

	// Set the $base_url for Drupal.
	// This is mandatory for all pathes to work properly with this bootstrapping method.
	// The provider is always queried over HTTP, so we cannot rely on $_SERVER["HTTPS"] here to know whether the user accesses the website over HTTPS.
	$base_url = ($rosweb_tls ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];

	// Even then, Drupal still checks $_SERVER["HTTPS"] at some points, so it's value needs to be accordingly.
	// For example, logins on the HTTPS site won't be noticed if this is not set.
	if($rosweb_tls)
		$_SERVER["HTTPS"] = "on";

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
