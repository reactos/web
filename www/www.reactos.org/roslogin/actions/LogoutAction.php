<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Logging out a user account and redirecting the user to a page
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class LogoutAction
	{
		public function perform()
		{
			$rl = new RosLogin();
			$rl->logout();

			// Redirect to the given URL or to the Login Page if there is none.
			if (array_key_exists("redirect", $_GET) && is_valid_redirect($_GET["redirect"]))
				redirect_to($_GET["redirect"]);
			else
				redirect_to("?p=login");
		}
	}
