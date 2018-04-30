<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Sending out a verification mail for resetting an account's password
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	require_once("Captcha.php");

	class ResetPasswordAction
	{
		public function perform()
		{
			global $lang;
			global $roslogin_langres;

			if (!array_key_exists("username", $_POST))
				throw new RuntimeException("username not specified");

			$data = [
				"username" => $_POST["username"]
			];

			try
			{
				$captcha = new Captcha();
				$captcha->verify();

				$mailtemplate = file_get_contents("lang/{$lang}_resetpassword_mail.txt");
				$rl = new RosLogin();
				$rl->resetPasswordRequest($_POST["username"], $roslogin_langres["reset_password_subject"], $mailtemplate);

				redirect_to("?p=message&reset_password_sent=1");
			}
			catch (InvalidUserNameException $e)
			{
				redirect_to("?p=forgot&unknown_username=1&" . http_build_query($data));
			}
			catch (CaptchaNotSolvedException $e)
			{
				redirect_to("?p=forgot&reset_password_captcha_not_solved=1&" . http_build_query($data));
			}
		}
	}
