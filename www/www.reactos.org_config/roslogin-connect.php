<?php
	// DB Settings
	// The user entered here must have SELECT, INSERT, UPDATE and DELETE privileges to ROSLOGIN_DB_NAME
	define("ROSLOGIN_DB_HOST", "127.0.0.1");
	define("ROSLOGIN_DB_USER", "roslogin");
	define("ROSLOGIN_DB_PASS", "");
	define("ROSLOGIN_DB_NAME", "roslogin");

	// LDAP Settings
	define("ROSLOGIN_LDAP_HOST", "127.0.0.1");
	define("ROSLOGIN_LDAP_BIND_DN", "uid=roslogin,ou=Service Accounts,o=ReactOS Website");
	define("ROSLOGIN_LDAP_BIND_PW", "test");
	define("ROSLOGIN_LDAP_BASE_DN", "ou=People,o=ReactOS Website");

	// Single Sign-On Settings
	define("ROSLOGIN_COOKIE_DOMAIN", "reactos.org");
	define("ROSLOGIN_COOKIE_VALIDITY", 60 * 60 * 24 * 365);		// 1 Year
	define("ROSLOGIN_SESSION_VALIDITY", "1 YEAR");

	// Self-Service Settings
	define("ROSLOGIN_MAIL_FROM", "ReactOS Website <noreply@reactos.org>");
	define("ROSLOGIN_MAIL_LINK", "https://reactos.org/roslogin/?p=confirm&");
	define("ROSLOGIN_MAIL_VALIDITY", "1 DAY");

	// Captcha Settings
	define("ROSLOGIN_RECAPTCHA_SITEKEY", "YOUR_GOOGLE_RECAPTCHA_SITEKEY_HERE");
	define("ROSLOGIN_RECAPTCHA_SECRET", "YOUR_GOOGLE_RECAPTCHA_SECRET_HERE");

	// Miscellaneous Website Settings
	define("ROSLOGIN_TITLE_SUFFIX", " | ReactOS Project");
