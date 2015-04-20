<?php
/*
  PROJECT:    ReactOS RosWeb Component for sharing layout and user information between website subsystems
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Counterpart to rosweb.php for providing dummy information without requiring a Drupal setup
  COPYRIGHT:  Copyright 2015 Colin Finck <colin@reactos.org>
*/


	switch($_GET["q"])
	{
		case "CurrentUser":
			$rosweb_user_info["id"] = 0;
			$rosweb_user_info["mail"] = "";
			$rosweb_user_info["name"] = "";
			die(json_encode($rosweb_user_info));

		case "Footer":
			die(file_get_contents("dummy-content/footer.htm"));

		case "Header":
			die(file_get_contents("dummy-content/header.htm"));

		case "Sidebar":
			die(file_get_contents("dummy-content/sidebar.htm"));
	}
