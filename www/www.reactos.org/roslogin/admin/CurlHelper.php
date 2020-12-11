<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Curl Helper Class for RosAdmin
 * COPYRIGHT:   Copyright 2020 Stanislav Motylkov (x86corez@gmail.com)
 */

	class CurlHelper
	{
		//
		// MEMBER VARIABLES
		//
		private $_last_error;
		private $_custom_headers;

		//
		// PRIVATE FUNCTIONS
		//

		private function perform($url, $content_type, $content_data)
		{
			$headers = $this->_custom_headers;
			if (!empty($content_type))
				$headers[] = "Content-Type: {$content_type}";

			$ver = phpversion();
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'utf-8');
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_FAILONERROR, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, "PHP/{$ver} RosAdmin Curl");
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			if (!empty($content_type))
				curl_setopt($ch, CURLOPT_POSTFIELDS, $content_data);
			$data = curl_exec($ch);
			if (!$data)
				$this->_last_error = curl_error($ch);
			curl_close($ch);
			return $data;
		}

		//
		// PUBLIC FUNCTIONS
		//

		public function __construct()
		{
			$this->_last_error = null;
			$this->_custom_headers = array();
		}

		public function get($url)
		{
			return $this->perform($url, '', '');
		}

		public function post($url, $content_type, $content_data)
		{
			return $this->perform($url, $content_type, $content_data);
		}

		public function setHeaders($headers)
		{
			$this->_custom_headers = $headers;
		}

		public function getLastError()
		{
			$error = $this->_last_error;
			$this->_last_error = null;
			return $error;
		}

	}
