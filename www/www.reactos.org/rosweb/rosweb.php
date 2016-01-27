<?php
/*
  PROJECT:    ReactOS RosWeb Component for sharing layout and user information between website subsystems
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Encapsulating the shared information inside a class that doesn't clash with the code of other subsystems
  COPYRIGHT:  Copyright 2015 Colin Finck <colin@reactos.org>
*/

	class RosWeb
	{
		//// SETTINGS ////

		// Add language codes and their native names for all languages supported by our subsystems here.
		private $_language_names = array(
			"en" => "English",
			"de" => "Deutsch",
			"es" => "Español",
			"fr" => "Français",
			"ja" => "日本語",
			"it" => "Italiano",
			"lt" => "Lietuvių",
			"pl" => "Polski",
			"ru" => "Русский",
		);

		// Specifies the "rosweb-provider-X.php" file that is queried for layout and user information.
		// This must be set to "drupal" on the web server to get dynamic results from our Drupal installation.
		// For developing subsystems locally, you can set this to "dummy" and don't need a local Drupal setup then.
		private $_provider = "drupal";


		//// CODE ////

		// Member Variables
		private $_context;
		private $_language;
		private $_supported_languages;

		// Private Functions
		private function _createHTTPContext()
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
			$this->_context = stream_context_create($opts);
		}

		/*
		 * This will return the last two components of the server name, with a leading
		 * dot (i.e. usually .reactos.com or .reactos.org for us). See the PHP docs
		 * on setcookie() why we need the leading dot.
		 */
		private function _getCookieDomain()
		{
			// Server name might be just an IP address
			if (preg_match("#[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}#", $_SERVER["SERVER_NAME"]))
				return $_SERVER["SERVER_NAME"];
		
			// If it' a DNS address, return the domain name along with the suffix
			if (preg_match("#(\.[^.]+\.[^.]+$)#", $_SERVER["SERVER_NAME"], $matches))
				return $matches[1];
		
			// Otherwise return nothing
			return "";
		}

		private function _handleLanguage($supported_languages)
		{
			// Preserve the supported languages for the language box later
			$this->_supported_languages = $supported_languages;

			// Get the language from the query string or cookie
			if (array_key_exists("lang", $_GET))
				$this->_language = $_GET["lang"];
			else if (array_key_exists("multilink_pl", $_COOKIE))
				$this->_language = $_COOKIE["multilink_pl"];

			// Check if it's valid
			if (array_search($this->_language, $supported_languages) === FALSE)
				$this->_language = "en";

			// Set a cookie for one year
			setcookie("multilink_pl", $this->_language, time() + 31536000, "/", $this->_getCookieDomain());
		}

		/* Functional programming in PHP is prone to naming collisions. As Drupal 7 is still using functional PHP throughout the
		   whole CMS, we have to use this clean but slow provider approach and do a single HTTP request for each query.
		   When you add queries here, return as much information as useful in one query to reduce the number of required requests. */
		private function _queryProvider($part)
		{
			$q = ($this->_language == "en") ? "" : $this->_language;
			$tls = ($_SERVER["HTTPS"] == "on") ? "1" : "0";

			$fp = fopen(sprintf("http://%s/rosweb/rosweb-provider-%s.php?q=%s&part=%s&tls=%s", $_SERVER["HTTP_HOST"], $this->_provider, $q, $part, $tls), "r", false, $this->_context);
			$ret = stream_get_contents($fp);
			fclose($fp);

			return $ret;
		}


		// Public Functions
		public function __construct($supported_languages = null)
		{
			$this->_createHTTPContext();

			if ($supported_languages)
				$this->_handleLanguage($supported_languages);
			else
				$this->_language = "en";
		}

		public function getCurrentUser()
		{
			return json_decode($this->_queryProvider("CurrentUser"));
		}

		public function getFooter()
		{
			return $this->_queryProvider("Footer");
		}

		public function getHead()
		{
			return $this->_queryProvider("Head");
		}

		public function getHeader()
		{
			return $this->_queryProvider("Header");
		}

		public function getLanguage()
		{
			return $this->_language;
		}

		public function getLanguageBox()
		{
			require(__DIR__ . "/lang/" . $this->_language . ".inc.php");

			// First of all, disable Drupal's Multilink language box that can't be used here.
			$html  = '<style type="text/css">#block-locale-language {display: none;}</style>';

			// Now add our own language links
			$html .= '<div class="region region-sidebar-first column sidebar"><div class="block">';
			$html .= '<h2 class="block-title">' . $shared_langres["language"] . '</h2>';
			$html .= '<div class="content">';
			$html .= '<ul class="language-switcher-locale-url">';

			foreach ($this->_supported_languages as $lang_key)
			{
				// Add the appropriate CSS class if this is the current language
				$active = ($this->_language == $lang_key ? " active" : "");

				$html .= sprintf(
					'<li class="%s%s"><a class="language-link%s" xml:lang="%s" href="?lang=%s">%s</a></li>',
					$lang_key,
					$active,
					$active,
					$lang_key,
					$lang_key,
					$this->_language_names[$lang_key]
				);
			}

			$html .= '</ul></div></div></div>';

			return $html;
		}

		public function getLatestRevision()
		{
			$fp = fopen("http://svn.reactos.org/svnact/svn_activity.xml", "r");

			do
			{
				$line = fread($fp, 1024);
				$firstpos = strpos($line, "<id>");
			
				if($firstpos > 0)
				{
					$lastpos = strpos($line, "</id>");
					return substr($line, $firstpos + 4, ($lastpos - $firstpos - 4));
				}
			}
			while($line);
		
			fclose($fp);
		}
	}
