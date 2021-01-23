<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Revoking all user sessions
 * COPYRIGHT:   Copyright 2020 Stanislav Motylkov (x86corez@gmail.com)
 */

	class RevokeAllAction
	{
		public function perform($ra)
		{
			if (!array_key_exists('username', $_POST)
				|| !array_key_exists('user_id', $_POST))
			{
				throw new RuntimeException("Necessary information not specified");
			}

			$username = $_POST['username'];
			$user_id = $_POST['user_id'];
			$data = [
				'username' => $username,
			];

			$result = $ra->mm->revokeAllSessions($user_id);
			if (!$result || $result['status'] != "OK")
			{
				throw new RuntimeException("Failed to revoke all user sessions: " . $ra->mm->getLastError());
			}
			else
				redirect_to("?p=user&revoke_all_ok=1&" . http_build_query($data));
		}
	}
