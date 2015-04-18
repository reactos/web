<?php
/*
  PROJECT:    ReactOS RosWeb Component for sharing layout and user information between website subsystems
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Encapsulating the shared information inside a class that doesn't clash with the code of other subsystems
  COPYRIGHT:  Copyright 2015 Colin Finck <colin@reactos.org>

  Functional programming in PHP is prone to naming collisions. As Drupal 7 is still using functional PHP throughout the
  whole CMS, we have to use this clean but slow provider approach and do a single HTTP request for each query.
  When you add queries here, return as much information as useful in one query to reduce the number of required requests.
*/

	class RosWeb
	{
		public function __construct()
		{
			// Collect available cookies for the HTTP request
			// This is mandatory for e.g. getting information about the current user
			$cookies = "";
			foreach($_COOKIE as $key => $value)
			{
				if($cookies == "")
					$cookies  = "$key=$value";
				else
					$cookies .= ";$key=$value";
			}

			$opts = array(
				"http" => array(
					"method" => "GET",
					"header" => "Cookie: $cookies\r\n"
				)
			);

			// Create the stream context to reuse for all HTTP requests
			$this->context = stream_context_create($opts);
		}

		private function _queryProvider($q)
		{
			$fp = fopen("http://" . $_SERVER["HTTP_HOST"] . "/rosweb/rosweb-provider.php?q=" . $q, "r", false, $this->context);
			$ret = stream_get_contents($fp);
			fclose($fp);

			return $ret;
		}

		public function getCurrentUser()
		{
			return json_decode($this->_queryProvider("CurrentUser"));
		}

		public function getFooter()
		{
			return $this->_queryProvider("Footer");
		}

		public function getHeader()
		{
			return $this->_queryProvider("Header");
		}

		public function getSidebar()
		{
			return $this->_queryProvider("Sidebar");
		}
	}
