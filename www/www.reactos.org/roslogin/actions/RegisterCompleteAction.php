<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Verifying the mail key and completing the registration of a new user account
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class RegisterCompleteAction
	{
		public function perform()
		{
			global $lang;
			global $roslogin_langres;

			if (!array_key_exists("username", $_POST) ||
				!array_key_exists("email", $_POST) ||
				!array_key_exists("key", $_POST) ||
				!array_key_exists("displayname", $_POST) ||
				!array_key_exists("password", $_POST) ||
				!array_key_exists("reenter_password", $_POST))
			{
				throw new RuntimeException("Necessary information not specified");
			}

			$data = [
				"username" => $_POST["username"],
				"email" => $_POST["email"],
				"key" => $_POST["key"],
				"displayname" => $_POST["displayname"],
			];

			try
			{
				$rl = new RosLogin();

				// We have to verify the mail key again, even though this has already been done on the ConfirmPage.
				// Otherwise, this action could be abused to create users without verification.
				$type = $rl->verifyMailKey($_POST["username"], $_POST["email"], $_POST["key"]);
				if ($type != "registration")
					throw new RuntimeException("Attempting to use RegisterCompleteAction with type \"{$type}\"");

				// Ensure that both passwords match.
				if ($_POST["password"] != $_POST["reenter_password"])
					redirect_to("?p=confirm&password_mismatch=1&" . http_build_query($data));

				// Try to complete the registration.
				$rl->registerComplete($_POST["username"], $_POST["email"], $_POST["displayname"], $_POST["password"]);

				redirect_to("?p=message&register_finished=1");
			}
			catch (InvalidVerificationException $e)
			{
				// Let verifyMailKey fail again on the ConfirmPage and show a nice error message.
				redirect_to("?p=confirm&" . http_build_query($data));
			}
			catch (InvalidDisplayNameException $e)
			{
				redirect_to("?p=confirm&invalid_displayname=1&" . http_build_query($data));
			}
			catch (InvalidPasswordException $e)
			{
				redirect_to("?p=confirm&invalid_password=1&" . http_build_query($data));
			}
			catch (AlreadyInUseException $e)
			{
				redirect_to("?p=message&register_in_use=1");
			}
		}
	}
