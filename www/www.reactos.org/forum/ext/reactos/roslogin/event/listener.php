<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Authentication Plugin for phpBB
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	namespace reactos\roslogin\event;

	use Symfony\Component\EventDispatcher\EventSubscriberInterface;

	class listener implements EventSubscriberInterface
	{
		private $_script_path;

		public function __construct(\phpbb\config\config $config)
		{
			$this->_script_path = $config['script_path'];
		}

		static public function getSubscribedEvents()
		{
			return array(
				'core.login_box_before' => 'login_box_before',
			);
		}

		public function login_box_before($event)
		{
			redirect("/roslogin/?p=login&redirect=" . rawurlencode($this->_script_path . '/' . $event['redirect']));
		}
	}
