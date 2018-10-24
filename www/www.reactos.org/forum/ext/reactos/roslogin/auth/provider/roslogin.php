<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Authentication Plugin for phpBB
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	namespace reactos\roslogin\auth\provider;

	class roslogin extends \phpbb\auth\provider\base
	{
		private $_rl;

		/**
		 * Checks if the user's E-Mail address stored in RosLogin matches the one stored
		 * in the phpBB database. Updates the phpBB database if necessary.
		 * Also skips reauthentication for the Admin Control Panel.
		 */
		private function _update_user_data($username, $user)
		{
			// Get the E-Mail address stored in RosLogin and lowercase it.
			$userinfo = $this->_rl->getUserInformation($username);
			$email = strtolower($userinfo["email"]);

			// Does it match the lowercased E-Mail address stored in phpBB?
			if (strtolower($user['user_email']) != $email)
			{
				// No, then update the phpBB database.
				$sql_ary = array(
					'user_email' => $email,
					'user_email_hash' => phpbb_email_hash($email)
				);

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE user_id = ' . $user['user_id'];
				$this->db->sql_query($sql);
			}

			// Always set session_admin to 1 to skip the reauthentication for the Admin Control Panel.
			// It wouldn't work, because it relies on a phpBB login form, however only the RosLogin login form works.
			//
			// phpBB still checks if the user is qualified to access the Admin Control Panel, so doing this is safe.
			$this->user->data['session_admin'] = 1;
		}

		/**
		 * Generate an array for the user_add() function.
		 * Taken from the apache.php authentication module and adapted (add an E-Mail address instead of password).
		 */
		private function _user_row($username, $email)
		{
			// first retrieve default group id
			$sql = "SELECT group_id
				FROM " . GROUPS_TABLE . "
				WHERE group_name = 'REGISTERED'
				AND group_type = " . GROUP_SPECIAL;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!$row)
			{
				trigger_error('NO_GROUP');
			}

			// generate user account data
			return array(
				'username'		=> $username,
				'user_email'	=> $email,
				'group_id'		=> (int) $row['group_id'],
				'user_type'		=> USER_NORMAL,
				'user_ip'		=> $this->user->ip,
				'user_new'		=> 1,
			);
		}

		public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, $phpbb_root_path)
		{
			// Import the RosLogin class.
			define("ROOT_PATH", $phpbb_root_path . "../");
			require_once(ROOT_PATH . "roslogin/RosLogin.php");

			// Import phpBB's user_add()
			require_once($phpbb_root_path . "includes/functions_user.php");

			$this->_rl = new \RosLogin();
			$this->db = $db;
			$this->user = $user;
		}

		public function login($username, $password)
		{
			// listener.php redirects to the RosLogin Login page, so this function should never be called!
			trigger_error('Called reactos\roslogin\auth\provider\roslogin::login');
		}

		public function logout($user, $new_session)
		{
			$this->_rl->logout();
		}

		public function autologin()
		{
			// Check if the user is logged in through RosLogin Single-Sign-On.
			$username = $this->_rl->isLoggedIn();
			if ($username)
			{
				// Get the phpBB-style "clean" username, which is indexed in the phpBB database.
				$username_clean = utf8_clean_string($username);

				// Check if the user exists in the phpBB database.
				$sql = 'SELECT *
					FROM ' . USERS_TABLE . "
					WHERE username_clean = '" . $this->db->sql_escape($username_clean) . "'";
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				if ($row)
				{
					// The user exists in the phpBB database. Check if it's marked as inactive.
					if ($row['user_type'] != USER_INACTIVE)
					{
						// The username is active.
						// Update its E-Mail address if necessary and auto-login it in phpBB.
						$this->_update_user_data($username, $row);
						return $row;
					}
				}
				else
				{
					// The user does not exist in the phpBB database, so add it.
					$userinfo = $this->_rl->getUserInformation($username);
					user_add($this->_user_row($username, $userinfo["email"]));

					// Fetch the newly created user row from the phpBB database.
					$sql = 'SELECT *
						FROM ' . USERS_TABLE . "
						WHERE username_clean = '" . $this->db->sql_escape($username_clean) . "'";
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if ($row)
					{
						// Auto-login the newly created user in phpBB.
						// We can be sure that it's active and its E-Mail address is up to date.
						return $row;
					}
				}
			}

			// If we haven't returned at this point, all previous conditions for an auto-login were not met.
			// So return an empty array to indicate that we cannot auto-login.
			return array();
		}

		public function validate_session($user)
		{
			// Check if the user is logged in through RosLogin Single-Sign-On.
			$username = $this->_rl->isLoggedIn();
			if ($username && $username == $user['username'])
			{
				// The user is logged in through RosLogin and the RosLogin username matches the username of the current phpBB session.
				// Update the stored E-Mail if necessary and reuse this session.
				$this->_update_user_data($username, $user);
				return true;
			}
			else if (!$username && $user['user_id'] == ANONYMOUS)
			{
				// The user is not logged in through RosLogin and the current phpBB session is an anonymous one.
				// Let phpBB reuse this anonymous user session.
				return true;
			}

			// Indicate that this session is invalid to let phpBB create a new session.
			return false;
		}
	}
