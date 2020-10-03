<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Internal implementation of admin features
 * COPYRIGHT:   Copyright 2020 Mark Jansen (mark.jansen@reactos.org)
 */

	class RosAdmin extends RosLogin
	{
		//
		// MEMBER VARIABLES
		//
		private $_username;
		private $_userinfo;
		private $_is_mod;
		private $_is_admin;

		//
		// PRIVATE FUNCTIONS
		//

		//
		// PUBLIC FUNCTIONS
		//

		public function __construct()
		{
			$this->_username = $this->isLoggedIn();

			// Forward to the Login page if the user is not logged in.
			if (!$this->_username)
				redirect_to('/roslogin/?p=login&redirect=/roslogin/admin');

			$this->_userinfo = $this->getUserWithGroupInformation($this->_username);
			$this->_is_mod = RosAdmin::checkMod($this->_userinfo);
			$this->_is_admin = RosAdmin::checkAdmin($this->_userinfo);

			// Admins are also moderators
			if (!$this->_is_mod)
				redirect_to('/roslogin/?p=login');

			// Let's hope this never happens
			if ($this->_userinfo['banned'])
				redirect_to('/roslogin/?p=login');
		}


		public function banUser($username, $userinfo)
		{
			if (!$this->canBan($userinfo))
				throw new RuntimeException('Cannot ban this user');

			// Connect to LDAP with the service account
			$this->_connectToLDAP();
			$dn = $this->_getUserNameDN($username);
			$info = [
				'userPassword' => base64_encode(random_bytes(40)),
				'mail' => $userinfo['email'] . '.disabled',
			];

			if (!ldap_mod_replace($this->_ds, $dn, $info))
				throw new RuntimeException('Could not modify the password / email in the LDAP directory');

			// Delete the session from the database.
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare('DELETE FROM sessions WHERE username = :username');
			$stmt->bindParam(':username', $username);
			$stmt->execute();
		}

		public function unbanUser($username, $userinfo)
		{
			if (!$this->canBan($userinfo))
				throw new RuntimeException('Cannot ban this user');

			// Connect to LDAP with the service account
			$this->_connectToLDAP();
			// Restore the original email
			$dn = $this->_getUserNameDN($username);
			$info = [
				'mail' => $userinfo['email'],	// The $userinfo has a stripped email address!
			];

			if (!ldap_mod_replace($this->_ds, $dn, $info))
				throw new RuntimeException('Could not modify the email in the LDAP directory');

			// Send a reset password email
			// The text is enlgish, since we do not know the banned user's locale
			$mailtemplate = file_get_contents('../lang/en_resetpassword_mail.txt');
			$this->resetPasswordRequest($username, 'Reset Account Password', $mailtemplate);
		}

		/**
		 * Can the currently logged in user ban the specified $userinfo?
		 */
		public function canBan($userinfo)
		{
			if (RosAdmin::checkAdmin($userinfo))
			{
				// Admins cannot be banned
				return false;
			}
			else if (RosAdmin::checkMod($userinfo))
			{
				// Only admins can ban moderators
				return $this->isAdmin();
			}
			return true;
		}


		/**
		 * Finds all banned users
		 * These are indicated with a .disabled suffix on the email
		 */
		public function getBannedUsers()
		{
			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			$filter = '(mail=*.disabled)';
			$sr = ldap_search($this->_ds, ROSLOGIN_LDAP_BASE_DN, $filter);
			$info = ldap_get_entries($this->_ds, $sr);
			unset($info['count']);
			return $info;
		}

		public function getUserWithGroupInformation($username)
		{
			$info = parent::getUserInformation($username, ['memberOf']);

			// Flatten the ldap-returned data
			$groups = $info['memberof'];
			$memberof = array();
			for ($i = 0; $i < $groups['count']; $i++)
			{
				// Grab the value of the first entry (cn)
				// cn=Moderators,ou=Groups,o=ReactOS Website
				$memberof[] = ldap_explode_dn($groups[$i], 1)[0];
			}
			$info['memberof'] = $memberof;

			// clean up the email address, and add 'banned' info
			$disabled_str = '.disabled';
			$disabled_len = strlen($disabled_str);
			if (strlen($info['email']) >= $disabled_len && substr_compare($info['email'], $disabled_str, -$disabled_len) === 0)
			{
				$info['email'] = substr($info['email'], 0, -$disabled_len);
				$info['banned'] = true;
			}
			else
			{
				$info['banned'] = false;
			}

			return $info;
		}

		public function isMod()
		{
			if ($this->_is_mod)
				return true;

			// Admins are also moderators
			return $this->isAdmin();
		}

		public function isAdmin()
		{
			return $this->_is_admin;
		}

		public static function checkMod($userinfo)
		{
			if (in_array(ROSLOGIN_MODERATOR_GROUP, $userinfo['memberof']))
			{
				return true;
			}

			// Admins are also moderators
			return RosAdmin::checkAdmin($userinfo);
		}

		public static function checkAdmin($userinfo)
		{
			return in_array(ROSLOGIN_ADMIN_GROUP, $userinfo['memberof']);
		}

		public function userTitle()
		{
			if ($this->isAdmin())
				return 'Administrator';
			if ($this->isMod())
				return 'Moderator';
			return 'User';
		}

	}
