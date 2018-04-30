<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Saving the account information in the self-service
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class SelfServiceSaveAction
	{
		public function perform()
		{
			global $lang;
			global $roslogin_langres;

			if (!array_key_exists("displayname", $_POST) ||
				!array_key_exists("email", $_POST) ||
				!array_key_exists("current_password", $_POST) ||
				!array_key_exists("new_password", $_POST) ||
				!array_key_exists("reenter_new_password", $_POST))
			{
				throw new RuntimeException("Necessary information not specified");
			}

			$data = [
				"displayname" => $_POST["displayname"],
				"email" => $_POST["email"],
			];

			try
			{
				$rl = new RosLogin();
				$username = $rl->isLoggedIn();

				// Forward to the Login page if the user is not logged in.
				if (!$username)
					redirect_to("?p=login");

				$userinfo = $rl->getUserInformation($username);
				$successdata = [];

				// Check if the password has changed and both match.
				if ($_POST["new_password"] != "" && $_POST["new_password"] != $_POST["reenter_new_password"])
					redirect_to("?p=selfservice&password_mismatch=1&" . http_build_query($data));

				// Try to change every data field that has changed.
				if ($userinfo["displayname"] != $_POST["displayname"])
					$rl->changeDisplayName($username, $_POST["displayname"]);

				if ($userinfo["email"] != $_POST["email"])
				{
					$mailtemplate = file_get_contents("lang/{$lang}_mailchange_mail.txt");
					$rl->changeEmailRequest($username, $_POST["email"], $roslogin_langres["confirm_mailchange_subject"], $mailtemplate);
					$successdata["sent"] = 1;
					$successdata["email"] = $_POST["email"];
				}

				if ($_POST["new_password"] != "")
					$rl->changePassword($username, $_POST["current_password"], $_POST["new_password"]);

				// We have been successful.
				redirect_to("?p=selfservice&success=1&" . http_build_query($successdata));
			}
			catch (InvalidDisplayNameException $e)
			{
				redirect_to("?p=selfservice&invalid_displayname=1&" . http_build_query($data));
			}
			catch (InvalidEmailException $e)
			{
				redirect_to("?p=selfservice&invalid_email=1&" . http_build_query($data));
			}
			catch (AlreadyInUseException $e)
			{
				redirect_to("?p=selfservice&in_use=1&" . http_build_query($data));
			}
			catch (InvalidCredentialsException $e)
			{
				redirect_to("?p=selfservice&invalid_current_password=1&" . http_build_query($data));
			}
			catch (InvalidPasswordException $e)
			{
				redirect_to("?p=selfservice&invalid_new_password=1&" . http_build_query($data));
			}
		}
	}
