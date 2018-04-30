<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Logging in a user account and redirecting the user to a page
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class LoginAction
	{
		public function perform()
		{
			try
			{
				$rl = new RosLogin();

				// Check if the user is already logged in.
				// In that case, we skip logging in again.
				if (!$rl->isLoggedIn())
				{
					if (!array_key_exists("username", $_POST) || !array_key_exists("password", $_POST))
						throw new RuntimeException("username or password not specified");

					$rl->login($_POST["username"], $_POST["password"]);
				}

				// Redirect to the given URL or to the Self-Service if there is none.
				if (array_key_exists("redirect", $_POST))
					redirect_to($_POST["redirect"]);
				else
					redirect_to("?p=selfservice");
			}
			catch (InvalidCredentialsException $e)
			{
				// Redirect back to the Login page and show that the Login was invalid.
				redirect_to("?p=login&invalid=1");
			}
		}
	}
