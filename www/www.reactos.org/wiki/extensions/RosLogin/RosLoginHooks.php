<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Hooks for MediaWiki
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class RosLoginHooks
	{
		public static function onSpecialPage_initList(&$specialPages) {
			$specialPages['Userlogin'] = "SpecialRosLogin";
			return TRUE;
		}

		public static function onUserLogout(&$user) {
			$rl = new RosLogin();
			$rl->logout();
			return TRUE;
		}
	}
