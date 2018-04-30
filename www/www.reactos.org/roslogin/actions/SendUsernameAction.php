<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Sending out the username associated to a given E-Mail address
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	require_once("Captcha.php");

	class SendUsernameAction
	{
		public function perform()
		{
			global $lang;
			global $roslogin_langres;

			if (!array_key_exists("email", $_POST))
				throw new RuntimeException("email not specified");

			$data = [
				"email" => $_POST["email"]
			];

			try
			{
				$captcha = new Captcha();
				$captcha->verify();

				$mailtemplate = file_get_contents("lang/{$lang}_sendusername_mail.txt");
				$rl = new RosLogin();
				$rl->sendUsername($_POST["email"], $roslogin_langres["send_username_subject"], $mailtemplate);

				redirect_to("?p=message&username_sent=1&" . http_build_query($data));
			}
			catch (InvalidEmailException $e)
			{
				redirect_to("?p=forgot&unknown_email=1&" . http_build_query($data));
			}
			catch (CaptchaNotSolvedException $e)
			{
				redirect_to("?p=forgot&send_username_captcha_not_solved=1&" . http_build_query($data));
			}
		}
	}
