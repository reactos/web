<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     SessionProvider for MediaWiki
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	define("ROOT_PATH", "../");
	require_once(ROOT_PATH . "roslogin/RosLogin.php");

	use MediaWiki\Session\SessionBackend;
	use MediaWiki\Session\SessionInfo;
	use MediaWiki\Session\SessionProvider;
	use MediaWiki\Session\UserInfo;

	class RosLoginSessionProvider extends SessionProvider
	{
		private $_rl;

		/**
		 * Gets the valid MediaWiki user name for the given RosLogin user name.
		 * MediaWiki user names need to begin with a capital letter and underscores must be converted to spaces.
		 * RosLogin's "forbidden_usernames" table must ensure that this does not lead to conflicting usernames.
		 */
		private function _getMediaWikiUsername($username)
		{
			$username_replacements = [
				"_" => " ",
			];

			$username = ucfirst($username);
			$username = strtr($username, $username_replacements);
			return $username;
		}


		public function __construct()
		{
			$this->_rl = new RosLogin();
		}

		/**
		 * Return MediaWiki SessionInfo when a RosLogin user is logged in.
		 */
		public function provideSessionInfo(WebRequest $request)
		{
			// Check if the user is logged in through RosLogin Single-Sign-On.
			$username = $this->_rl->isLoggedIn();
			if ($username)
			{
				// Convert the username into a MediaWiki username and create a MediaWiki User object.
				$wiki_username = $this->_getMediaWikiUsername($username);
				$user = User::newFromName($wiki_username);

				// This should never happen, otherwise our _getMediaWikiUsername function is buggy!
				if (!$user)
					die("Could not load a Username entry for <i>{$username}</i>");

				// Return a session for the logged in user.
				return new SessionInfo(
					SessionInfo::MAX_PRIORITY, [
						"provider" => $this,
						"id" => $_COOKIE["roslogin_session_id"],
						"userInfo" => UserInfo::newFromUser($user, TRUE),
						"forceHTTPS" => TRUE,
						"metadata" => [
							"username" => $username,
						],
					]
				);
			}

			// Not logged into RosLogin Single-Sign-On, so return nothing.
			return NULL;
		}

		/**
		 * Create the MediaWiki user if it does not exist yet and set or update E-Mail Address
		 * and Real Name based on the RosLogin data.
		 */
		public function refreshSessionInfo(SessionInfo $info, WebRequest $request, &$metadata)
		{
			// Get the MediaWiki user, create it if it does not exist.
			$user = $info->getUserInfo()->getUser();
			if (!$user->isLoggedIn())
			{
				$username = $user->getName();
				$user = $user->createNew($username);

				// This should never happen, otherwise our _getMediaWikiUsername function is buggy!
				if (!$user)
					die("Could not create a Username entry for <i>{$username}</i>");
			}

			// Get additional information about the account.
			$userinfo = $this->_rl->getUserInformation($metadata["username"]);
			$changed = FALSE;

			// Update the E-Mail address and authentication timestamp if it changed.
			if ($user->getEmail() != $userinfo["email"])
			{
				$user->setEmail($userinfo["email"]);
				$user->setEmailAuthenticationTimestamp(wfTimestampNow());
				$changed = TRUE;
			}

			// Update the real name if it changed.
			if ($user->getRealName() != $userinfo["displayname"])
			{
				$user->setRealName($userinfo["displayname"]);
				$changed = TRUE;
			}

			// Save any changed settings.
			if ($changed)
				$user->saveSettings();

			return TRUE;
		}

		public function canChangeUser()
		{
			// Enable the "Log out" button.
			return TRUE;
		}

		public function persistSession(SessionBackend $session, WebRequest $request)
		{
			// Dummy required function.
		}

		public function persistsSessionId()
		{
			// We must return FALSE here as we provide an "id" field in provideSessionInfo.
			return FALSE;
		}

		public function unpersistSession(WebRequest $request)
		{
			// Dummy required function.
		}
	}
