<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Implementation of CAPTCHA support based on Google reCAPTCHA
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class Captcha
	{
		public function printHead()
		{
			echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
		}

		public function printWidget()
		{
			echo '<div class="g-recaptcha" data-sitekey="' . ROSLOGIN_RECAPTCHA_SITEKEY . '"></div>';
		}

		public function verify()
		{
			if (!array_key_exists("g-recaptcha-response", $_POST))
				throw new CaptchaNotSolvedException();

			$data = [
				"secret" => ROSLOGIN_RECAPTCHA_SECRET,
				"response" => $_POST["g-recaptcha-response"],
				"remoteip" => $_SERVER["REMOTE_ADDR"],
			];
			$opts = [
				"http" => [
					"content" => http_build_query($data),
					"header" => "Content-type: application/x-www-form-urlencoded",
					"method" => "POST",
				]
			];
			$context = stream_context_create($opts);
			$json = file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $context);
			$result = json_decode($json);
			if (!$result->success)
				throw new CaptchaNotSolvedException();
		}
	}
