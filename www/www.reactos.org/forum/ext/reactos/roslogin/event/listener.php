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
		private $_server_name;

		public function __construct(\phpbb\config\config $config)
		{
			$this->_script_path = $config['script_path'];
			$this->_server_name = $config['server_name'];
		}

		static public function getSubscribedEvents()
		{
			return array(
				'core.login_box_before' => 'login_box_before',
			);
		}

		public function login_box_before($event)
		{
			// Due to a bug (?), $event['redirect'] never contains anything else than /forum or /forum/index.php in phpBB 3.2.2.
			// Therefore, parse the HTTP_REFERER and prefer that over $event['redirect'] if it contains a forum URL.
			$referer = array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : '';
			$check_url_1 = 'https://' . $this->_server_name . $this->_script_path . '/';
			$check_url_2 = 'https://www.' . $this->_server_name . $this->_script_path . '/';

			if (strncmp($referer, $check_url_1, strlen($check_url_1)) === 0)
			{
				$redirect = substr($referer, strlen($check_url_1));
			}
			else if (strncmp($referer, $check_url_2, strlen($check_url_2)) === 0)
			{
				$redirect = substr($referer, strlen($check_url_2));
			}
			else
			{
				$redirect = $event['redirect'];
			}

			redirect("/roslogin/?p=login&redirect=" . rawurlencode($this->_script_path . '/' . $redirect));
		}
	}
