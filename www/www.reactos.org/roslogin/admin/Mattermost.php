<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Mattermost communication with RosAdmin
 * COPYRIGHT:   Copyright 2020 Stanislav Motylkov (x86corez@gmail.com)
 */

	class Mattermost
	{
		//
		// MEMBER VARIABLES
		//
		private $_ch;
		private $_url;
		private $_last_error;

		//
		// PRIVATE FUNCTIONS
		//

		/**
		 * Is this error returned by Mattermost server?
		 */
		private function isError($json)
		{
			return (isset($json['message']) && isset($json['status_code']));
		}

		/**
		 * Generates unique to the client temporary filename
		 */
		private function getTempFilename()
		{
			$uniq = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			return sys_get_temp_dir() . '/rosadmin_mattermost_' . substr($uniq, 0, 8);
		}

		/**
		 * Reads error message that was saved earlier
		 * and removes it from disk
		 */
		private function restoreError()
		{
			$filename = Mattermost::getTempFilename();
			if (!file_exists($filename))
				return null;
			$error = file_get_contents($filename);
			unlink($filename);
			return $error;
		}

		//
		// PUBLIC FUNCTIONS
		//

		public function __construct($curl_helper, $url, $token)
		{
			$this->_ch = $curl_helper;
			$this->_url = $url;
			$this->_ch->setHeaders(array("Authorization: Bearer {$token}"));
			$this->_last_error = null;
		}

		/**
		 * Returns user ID
		 */
		public function getUserByName($name)
		{
			/* Mattermost usernames are lower-case */
			$name = urlencode(strtolower($name));
			$json = $this->_ch->get("{$this->_url}/api/v4/users/username/{$name}");
			if (!$json)
			{
				$this->_last_error = $this->_ch->getLastError();
				return null;
			}
			$json = json_decode($json, true);
			if (Mattermost::isError($json))
			{
				$this->_last_error = $json['message'];
				if ($json['status_code'] == 404)
					$this->_last_error = 'User is not registered in Mattermost';
				return null;
			}
			else if (!isset($json['id']) && empty($this->_last_error))
			{
				/* Request was successful, but response is not recognized */
				$this->_last_error = 'Cannot connect to Mattermost';
				return null;
			}
			return $json['id'];
		}

		/**
		 * Returns user sessions
		 */
		public function getSessionsById($user_id)
		{
			$user_id = urlencode($user_id);
			$json = $this->_ch->get("{$this->_url}/api/v4/users/{$user_id}/sessions");
			if (!$json)
			{
				$this->_last_error = $this->_ch->getLastError();
				return null;
			}
			$json = json_decode($json, true);
			if (Mattermost::isError($json))
			{
				$this->_last_error = $json['message'];
				return null;
			}
			return $json;
		}

		/**
		 * Returns user audits
		 */
		public function getAuditsById($user_id)
		{
			$user_id = urlencode($user_id);
			$json = $this->_ch->get("{$this->_url}/api/v4/users/{$user_id}/audits");
			if (!$json)
			{
				$this->_last_error = $this->_ch->getLastError();
				return null;
			}
			$json = json_decode($json, true);
			if (Mattermost::isError($json))
			{
				$this->_last_error = $json['message'];
				return null;
			}
			return $json;
		}

		/**
		 * Revokes user session
		 */
		public function revokeSession($user_id, $session_id)
		{
			$user_id = urlencode($user_id);
			$json = $this->_ch->post(
				"{$this->_url}/api/v4/users/{$user_id}/sessions/revoke",
				"application/json",
				json_encode(array('session_id' => $session_id)));
			if (!$json)
			{
				$this->_last_error = $this->_ch->getLastError();
				return null;
			}
			$json = json_decode($json, true);
			if (Mattermost::isError($json))
			{
				$this->_last_error = $json['message'];
				return null;
			}
			return $json;
		}

		/**
		 * Revokes all user sessions
		 */
		public function revokeAllSessions($user_id)
		{
			$user_id = urlencode($user_id);
			$json = $this->_ch->post(
				"{$this->_url}/api/v4/users/{$user_id}/sessions/revoke/all",
				"application/json",
				"{}");
			if (!$json)
			{
				$this->_last_error = $this->_ch->getLastError();
				return null;
			}
			$json = json_decode($json, true);
			if (Mattermost::isError($json))
			{
				$this->_last_error = $json['message'];
				return null;
			}
			return $json;
		}

		/**
		 * Returns all IP addresses associated with a session
		 * using audit information
		 */
		public function getSessionAddresses($audits, $session_id)
		{
			$ips = array();
			for ($i = 0; $i < count($audits); $i++)
			{
				$e = $audits[$i];
				if ($e['session_id'] === $session_id)
				{
					$ip = $e['ip_address'];
					if (!in_array($ip, $ips, true))
						$ips[] = $ip;
				}
			}
			return $ips;
		}

		/**
		 * Writes error message to disk to display it later
		 */
		public function rememberError()
		{
			$error = $this->getLastError();
			$filename = Mattermost::getTempFilename();
			file_put_contents($filename, $error);
			return $error;
		}

		/**
		 * Gets textual description of last encountered error
		 */
		public function getLastError()
		{
			$error = $this->_last_error;
			$this->_last_error = null;
			if (is_null($error))
				$error = Mattermost::restoreError();
			return $error;
		}

	}
