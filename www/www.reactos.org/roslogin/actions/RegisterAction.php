<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Sending out a verification mail for registering a new user account
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	require_once("Captcha.php");

	class RegisterAction
	{
		public function perform()
		{
			global $lang;
			global $roslogin_langres;

			if (!array_key_exists("username", $_POST) ||
				!array_key_exists("email", $_POST))
			{
				throw new RuntimeException("Necessary information not specified");
			}

			$data = [
				"username" => $_POST["username"],
				"email" => $_POST["email"],
			];

			try
			{
				$captcha = new Captcha();
				$captcha->verify();

				$mailtemplate = file_get_contents("lang/{$lang}_registration_mail.txt");
				$rl = new RosLogin();
				$rl->registerRequest($_POST["username"], $_POST["email"], $roslogin_langres["confirm_registration_subject"], $mailtemplate);

				redirect_to("?p=message&register_sent=1&email=" . rawurlencode($_POST["email"]));
			}
			catch (InvalidUserNameException $e)
			{
				redirect_to("?p=register&invalid_username=1&" . http_build_query($data));
			}
			catch (InvalidEmailException $e)
			{
				redirect_to("?p=register&invalid_email=1&" . http_build_query($data));
			}
			catch (AlreadyInUseException $e)
			{
				redirect_to("?p=register&in_use=1&" . http_build_query($data));
			}
			catch (CaptchaNotSolvedException $e)
			{
				redirect_to("?p=register&captcha_not_solved=1&" . http_build_query($data));
			}
		}
	}
