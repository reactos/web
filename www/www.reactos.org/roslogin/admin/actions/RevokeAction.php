<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Revoking a user session
 * COPYRIGHT:   Copyright 2020 Stanislav Motylkov (x86corez@gmail.com)
 */

	class RevokeAction
	{
		public function perform($ra)
		{
			if (!array_key_exists('username', $_POST)
				|| !array_key_exists('user_id', $_POST)
				|| !array_key_exists('session_id', $_POST))
			{
				throw new RuntimeException("Necessary information not specified");
			}

			$username = $_POST['username'];
			$user_id = $_POST['user_id'];
			$session_id = $_POST['session_id'];
			$data = [
				'username' => $username,
			];

			$result = $ra->mm->revokeSession($user_id, $session_id);
			if (!$result || $result['status'] != "OK")
			{
				$ra->mm->rememberError();
				redirect_to("?p=user&revoke_problem=1&" . http_build_query($data));
			}
			else
				redirect_to("?p=user&revoke_ok=1&" . http_build_query($data));
		}
	}
