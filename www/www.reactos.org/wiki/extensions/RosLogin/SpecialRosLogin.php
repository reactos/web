<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     MediaWiki replacement page for SpecialUserlogin that forwards to RosLogin
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class SpecialRosLogin extends UnlistedSpecialPage
	{
		public function __construct()
		{
			parent::__construct("RosLogin");
		}

		public function execute($par)
		{
			$output = $this->getOutput();
			$redirect = array_key_exists("returnto", $_GET) ? "/wiki/index.php?title=" . $_GET["returnto"] : "/wiki";
			$output->redirect("/roslogin/?p=login&redirect=" . rawurlencode($redirect));
		}
	}
