<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Internal implementation of all Self-Service and Single-Sign-On features
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	require_once(ROOT_PATH . "../www.reactos.org_config/roslogin-connect.php");
	require_once("exceptions.php");

	class RosLogin
	{
		//
		// MEMBER VARIABLES
		//
		private $_dbh;
		private $_ds;

		//
		// PRIVATE FUNCTIONS
		//
		/**
		 * Changes the password of the given user name in the LDAP directory.
		 * Throws an InvalidPasswordException if the password does not fulfill the criteria for valid passwords.
		 *
		 * You have to call _connectToLDAP first!
		 */
		private function _changePassword($username, $new_password)
		{
			// Verify that the password is valid.
			if (!$this->_isValidPassword($new_password))
				throw new InvalidPasswordException();

			// Change the password.
			$dn = $this->_getUserNameDN($username);
			$info = [
				"userPassword" => $this->_getPasswordHash($new_password),
			];
			if (!ldap_mod_replace($this->_ds, $dn, $info))
				throw new RuntimeException("Could not modify the password in the LDAP directory");
		}

		/**
		 * Connect to the MySQL database over PDO and set PDO to throw exceptions.
		 *
		 * This function can safely be called multiple times, even if a database connection already exists.
		 */
		private function _connectToDB()
		{
			if (!$this->_dbh)
			{
				// Connect to the database.
				$this->_dbh = new PDO("mysql:host=" . ROSLOGIN_DB_HOST . ";dbname=" . ROSLOGIN_DB_NAME, ROSLOGIN_DB_USER, ROSLOGIN_DB_PASS);
				$this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		}

		/**
		 * Connect to the LDAP directory for LDAPv3 operation.
		 * If `credentials` is TRUE, a user name and password must be provided. It then gets the DN for the user name
		 * and tries to bind with these credentials. An InvalidCredentialsException is thrown if the credentials are invalid.
		 * If `credentials` is FALSE, it binds using the service account credentials.
		 *
		 * This function can safely be called multiple times, even if an LDAP connection already exists.
		 */
		private function _connectToLDAP($credentials = FALSE, $username = NULL, $password = NULL)
		{
			if (!$this->_ds)
			{
				// Connect to the LDAP server.
				$this->_ds = ldap_connect(ROSLOGIN_LDAP_HOST);
				if (!$this->_ds)
					throw new RuntimeException("Could not connect to LDAP host");

				ldap_set_option($this->_ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			}

			if ($credentials)
			{
				// Try to connect using the provided credentials.
				// Silence the error output of this call, because every failed login attempt is logged by default.
				$dn = $this->_getUserNameDN($username);
				if (!@ldap_bind($this->_ds, $dn, $password))
					throw new InvalidCredentialsException();
			}
			else
			{
				// Connect using the service account.
				if (!ldap_bind($this->_ds, ROSLOGIN_LDAP_BIND_DN, ROSLOGIN_LDAP_BIND_PW))
					throw new RuntimeException("Could not bind to the LDAP directory");
			}
		}

		/**
		 * Cleans expired entries from the given table ("pending" or "sessions").
		 */
		private function _cleanExpired($table)
		{
			$this->_connectToDB();
			$this->_dbh->query("DELETE FROM {$table} WHERE timeout < NOW()");
		}

		/**
		 * Deletes a verification entry from the "pending" table for the given user name and E-Mail address.
		 */
		private function _deletePendingEntry($username, $email)
		{
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare("DELETE FROM pending WHERE username = :username AND email = :email");
			$stmt->bindParam(":username", $username);
			$stmt->bindParam(":email", $email);
			$stmt->execute();
		}

		/**
		 * Generate a random alphanumeric string of a specific length.
		 * Used for password salts, registration keys, and session IDs.
		 */
		private function _generateRandomAlphanumericString($length)
		{
			$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$max = strlen($characters) - 1;
			$random = "";

			for ($i = 0; $i < $length; $i++)
				$random .= $characters[random_int(0, $max)];

			return $random;
		}

		/**
		 * Generates a verification key, stores it in the "pending" table of the database,
		 * and sends it embedded in an URL to the given E-Mail address.
		 * If the E-Mail address is valid, the E-Mail is received and the receiver can click that URL to confirm
		 * the validity of the E-Mail address.
		 */
		private function _generateVerificationKeyAndSendMail($username, $email, $type, $mailsubject, $mailtemplate)
		{
			// Generate a verification key.
			$key = $this->_generateRandomAlphanumericString(32);

			// Insert the information into the "pending" table.
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare(
				"INSERT INTO pending (username, email, verification_key, timeout, type) " .
				"VALUES (:username, :email, :verification_key, NOW() + INTERVAL " . ROSLOGIN_MAIL_VALIDITY . ", :type)"
			);
			$stmt->bindParam(":username", $username);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":verification_key", $key);
			$stmt->bindParam(":type", $type);
			$stmt->execute();

			// Send an E-Mail to verify the E-Mail address.
			$mail_replacements = [
				"USERNAME" => $username,
				"EMAIL" => $email,
				"LINK" => ROSLOGIN_MAIL_LINK .
					"username=" . rawurlencode($username) .
					"&email=" . rawurlencode($email) .
					"&key=" . $key,
			];
			$mailtext = strtr($mailtemplate, $mail_replacements);
			mail($email, $mailsubject, $mailtext, "From: " . ROSLOGIN_MAIL_FROM);
		}

		/**
		 * Returns the hash for the given password for storing in the LDAP directory.
		 */
		private function _getPasswordHash($password)
		{
			// Generate a password salt and the hash using the C library's crypt() function.
			// This is one of the few modern options supported by both PHP and OpenLDAP.
			// It can generate salted SHA-512 with multiple rounds on recent glibc versions, which is what we do here.
			$salt = $this->_generateRandomAlphanumericString(16);
			$hash = crypt($password, '$6$rounds=5000$' . $salt);
			return '{CRYPT}' . $hash;
		}

		/**
		 * Returns the DN in the LDAP directory for the given user name.
		 */
		private function _getUserNameDN($username)
		{
			$username_escaped = ldap_escape($username, null, LDAP_ESCAPE_DN);
			$dn = "cn={$username_escaped}," . ROSLOGIN_LDAP_BASE_DN;
			return $dn;
		}

		/**
		 * Returns whether the domain of the given E-Mail address is in the list of forbidden domains (e.g. "mailinator.com").
		 */
		private function _isForbiddenMailDomain($email)
		{
			// Extract the lowercased domain name out of the E-Mail address.
			$domain_start = strpos($email, "@");
			if ($domain_start === FALSE)
				throw new InvalidEmailException();

			$domain = substr($email, $domain_start + 1);
			$domain = strtolower($domain);

			// Check if the normalized domain is a forbidden one.
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM forbidden_maildomains WHERE domain = :domain");
			$stmt->bindParam(":domain", $domain);
			$stmt->execute();
			return ($stmt->fetchColumn() > 0);
		}

		/**
		 * Returns whether the given user name is in the list of "forbidden" user names.
		 * This includes registered ones, usernames too similar to registered ones or prohibited names that
		 * should never belong to an account (e.g. "admin").
		 */
		private function _isForbiddenUsername($username)
		{
			// Check if the normalized user name is a forbidden one.
			$this->_connectToDB();
			$normalized_username = $this->_normalizeUserName($username);
			$stmt = $this->_dbh->prepare("SELECT COUNT(*) FROM forbidden_usernames WHERE username = :username");
			$stmt->bindParam(":username", $normalized_username);
			$stmt->execute();
			return ($stmt->fetchColumn() > 0);
		}

		/**
		 * Returns whether the given E-Mail address exists in the LDAP directory.
		 */
		private function _isMailInLDAPDirectory($email)
		{
			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Search the LDAP directory for the given E-Mail address.
			$email_escaped = ldap_escape($email, null, LDAP_ESCAPE_FILTER);
			$filter = "(mail={$email_escaped})";
			$sr = ldap_search($this->_ds, ROSLOGIN_LDAP_BASE_DN, $filter);
			return (ldap_count_entries($this->_ds, $sr) > 0);
		}

		/**
		 * Returns whether the given display name fulfills the criteria for valid display names.
		 */
		private function _isValidDisplayName($displayname)
		{
			// Prevent empty display names.
			if ($displayname == "")
				return FALSE;

			return TRUE;
		}

		/**
		 * Returns whether the given user name fulfills the criteria for valid new user names.
		 * Do not use this function for validating existing user names in the directory, because they
		 * may be imported from a less strict database and may not fulfill the criteria.
		 */
		private function _isValidNewUserName($username)
		{
			// Prevent empty usernames.
			if ($username == "")
				return FALSE;

			// Prevent user names without a single letter.
			if (!preg_match('#[a-zA-Z]#', $username))
				return FALSE;

			// Prevent user names with characters not from the allowed range.
			if (preg_match('#[^a-zA-Z0-9\. _-]#', $username))
				return FALSE;

			// Prevent user names starting or ending with a special character.
			if (preg_match('#^[\. _-]#', $username) || preg_match('#[\. _-]$#', $username))
				return FALSE;

			// Prevent user names with multiple spaces in a row.
			if (strpos($username, '  ') !== FALSE)
				return FALSE;

			// Prevent user names shorter than 3 characters.
			if (strlen($username) < 3)
				return FALSE;

			// Prevent user names longer than 60 characters.
			if (strlen($username) > 60)
				return FALSE;

			return TRUE;
		}

		/**
		 * Returns whether the given password fulfills the criteria for valid passwords.
		 */
		private function _isValidPassword($password)
		{
			// Prevent passwords shorter than 5 characters.
			if (strlen($password) < 5)
				return FALSE;

			// Also prevent passwords longer than 100 characters.
			// We don't want to process an infinite amount of data at every login request ;)
			if (strlen($password) > 100)
				return FALSE;

			return TRUE;
		}

		/**
		 * Returns the normalized version of the given user name.
		 *
		 * Normalization converts the user name to lowercase and removes special characters.
		 * These normalized names are later stored in "forbidden_usernames" and checked during account creation to prevent
		 * similar accounts from being added.
		 * In practice, when there is an account "Colin Finck", this prevents the creation of e.g. "ColinFinck",
		 * "Colin.Finck", "__Colin-Finck" or "Colin___Finck".
		 * Furthermore, MediaWiki requires all underscores to be converted to spaces, so this normalization also prevents
		 * name conflicts.
		 */
		private function _normalizeUserName($username)
		{
			// Remove all allowed special characters.
			$username = preg_replace('#([\. _-])#', '', $username);

			// Return the lowercased result.
			return strtolower($username);
		}

		/**
		 * Updates the validity timeout of the user login session in the database and the session cookie.
		 * If no session exists yet, it is created based on the given information.
		 */
		private function _updateSession($id, $username)
		{
			// Create a new entry or update the validity timeout of an existing entry in
			// the "sessions" table.
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare(
				"INSERT INTO sessions (id, username, timeout) " .
				"VALUES (:id, :username, NOW() + INTERVAL " . ROSLOGIN_SESSION_VALIDITY . ") " .
				"ON DUPLICATE KEY UPDATE timeout = NOW() + INTERVAL " . ROSLOGIN_SESSION_VALIDITY
			);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":username", $username);
			$stmt->execute();

			// Create a new or update the validity timeout of an existing session cookie.
			$validity = time() + ROSLOGIN_COOKIE_VALIDITY;
			setcookie("roslogin_session_id", $id, $validity, "/", ROSLOGIN_COOKIE_DOMAIN, TRUE);
		}

		//
		// PUBLIC FUNCTIONS
		//
		/**
		 * Changes the display name of the given user name in the LDAP directory.
		 * Throws an InvalidDisplayNameException if the display name does not fulfill the criteria for valid display names.
		 */
		public function changeDisplayName($username, $new_displayname)
		{
			// Verify that the new display name is valid.
			if (!$this->_isValidDisplayName($new_displayname))
				throw new InvalidDisplayNameException();

			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Change the display name.
			$dn = $this->_getUserNameDN($username);
			$info = [
				"displayName" => $new_displayname,
			];
			if (!ldap_mod_replace($this->_ds, $dn, $info))
				throw new RuntimeException("Could not modify the display name in the LDAP directory");
		}

		/**
		 * Step 1 of changing the E-Mail address of the given user name.
		 * Checks the format of the E-Mail address and throws an InvalidEmailException if it's invalid.
		 * Checks that the new E-Mail address does not yet exist in the directory and throws an
		 * AlreadyInUseException if it does.
		 * Generates a verification key and sends it over mail to the new E-Mail address to validate it.
		 * The key can be checked using verifyMailKey() and if it matches, the E-Mail address change is
		 * finalized in changeEmailComplete().
		 */
		public function changeEmailRequest($username, $new_email, $mailsubject, $mailtemplate)
		{
			// Verify that the new E-Mail address is valid.
			if (!filter_var($new_email, FILTER_VALIDATE_EMAIL))
				throw new InvalidEmailException();

			// Check if the E-Mail domain is forbidden.
			if ($this->_isForbiddenMailDomain($new_email))
				throw new InvalidEmailException();

			// Check if the new E-Mail address is already in the LDAP database.
			if ($this->_isMailInLDAPDirectory($new_email))
				throw new AlreadyInUseException();

			// Generate and store a verification key and send an E-Mail to verify the E-Mail address.
			$this->_generateVerificationKeyAndSendMail($username, $new_email, "mailchange", $mailsubject, $mailtemplate);
		}

		/**
		 * Step 2 of changing the E-Mail address of the given user name.
		 * Performs the actual change in the LDAP directory and deletes the verification entry from the "pending" table.
		 * Throws an AlreadyInUseException if the E-Mail address already exists in the directory.
		 */
		public function changeEmailComplete($username, $new_email)
		{
			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Delete the entry from the "pending" table.
			$this->_deletePendingEntry($username, $new_email);

			// Try to change the E-Mail address in the LDAP directory.
			// It is configured to require unique values for the "mail" field.
			// If this E-Mail address already exists, ldap_mod_replace fails and this is translated to an AlreadyInUseException.
			$dn = $this->_getUserNameDN($username);
			$info = [
				"mail" => $new_email,
			];
			if (!@ldap_mod_replace($this->_ds, $dn, $info))
				throw new AlreadyInUseException();
		}

		/**
		 * Changes the password of the given user name in the LDAP directory.
		 * Connects to the directory using the provided credentials and throws an InvalidCredentialsException if they are invalid.
		 * Also throws an InvalidPasswordException if the password does not fulfill the criteria for valid passwords.
		 */
		public function changePassword($username, $password, $new_password)
		{
			// Try to connect to LDAP using the provided credentials and change the password.
			$this->_connectToLDAP(TRUE, $username, $password);
			$this->_changePassword($username, $new_password);
		}

		/**
		 * Returns an associative array containing the display name ("displayname") and E-Mail address ("email") of the given user name.
		 * Throws an InvalidUserNameException if the user name does not exist in the LDAP directory.
		 */
		public function getUserInformation($username)
		{
			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Fetch the user information.
			$dn = $this->_getUserNameDN($username);
			$sr = @ldap_read($this->_ds, $dn, "(objectClass=*)", ["displayname", "mail"]);
			if (!$sr)
				throw new InvalidUserNameException();

			$info = ldap_get_entries($this->_ds, $sr);
			if ($info["count"] != 1)
				throw new InvalidUserNameException();

			// Return it as an associative array.
			return [
				"displayname" => $info[0]["displayname"][0],
				"email" => $info[0]["mail"][0],
			];
		}

		/**
		 * Checks if the browser provides a session cookie and whether this cookie refers to a valid session.
		 * Updates the validity timeout of the cookie and session information in the database if it is valid.
		 * Returns either the user name of the logged in user (if the session is valid) or FALSE.
		 *
		 * Must be called before any HTML output, because it modifies cookie information.
		 */
		public function isLoggedIn()
		{
			// Check if we have a session cookie and get the session ID.
			if (!array_key_exists("roslogin_session_id", $_COOKIE))
				return FALSE;

			$id = $_COOKIE["roslogin_session_id"];

			// Check if this session ID is valid and has not timed out.
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare("SELECT username FROM sessions WHERE id = :id AND timeout > NOW()");
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			$username = $stmt->fetchColumn();

			if ($username)
			{
				// We got a user name, so the session cookie is still valid.
				// Update the cookie and the database entry and return the user name.
				$this->_updateSession($id, $username);
				return $username;
			}
			else
			{
				// The session cookie is invalid.
				return FALSE;
			}
		}

		/**
		 * Logs in using the provided credentials and creates a new session cookie as well as the session database entry.
		 * Throws an InvalidCredentialsException if the credentials are invalid.
		 *
		 * Must be called before any HTML output, because it modifies cookie information.
		 */
		public function login($username, $password)
		{
			// Try to connect to LDAP using the provided credentials.
			$this->_connectToLDAP(TRUE, $username, $password);

			// The user may have entered the user name with a different letter case.
			// Therefore, fetch the user name that is stored in the LDAP directory.
			$dn = $this->_getUserNameDN($username);
			$sr = ldap_read($this->_ds, $dn, "(objectClass=*)", ["cn"]);
			$info = ldap_get_entries($this->_ds, $sr);
			if ($info["count"] != 1)
				throw new RuntimeException("Could not find the username entry, although login was successful");

			$username = $info[0]["cn"][0];

			// The credentials match.
			// Generate a session ID for this user name and store it in the database.
			$id = $this->_generateRandomAlphanumericString(32);
			$this->_updateSession($id, $username);

			// Clean expired sessions while we're dealing with it.
			$this->_cleanExpired("sessions");
		}

		/**
		 * Checks if a valid session exists and logs out by removing all session information from the database and cookie.
		 *
		 * Must be called before any HTML output, because it modifies cookie information.
		 */
		public function logout()
		{
			// Get the Session ID from the cookie.
			if (!array_key_exists("roslogin_session_id", $_COOKIE))
				return;

			$id = $_COOKIE["roslogin_session_id"];

			// Delete the session from the database.
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare("DELETE FROM sessions WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			// Remove the cookie.
			unset($_COOKIE["roslogin_session_id"]);
			setcookie("roslogin_session_id", "", time() - 60, "/", ROSLOGIN_COOKIE_DOMAIN, TRUE);
		}

		/**
		 * Step 1 of registering a new user with the given user name and E-Mail address.
		 * Checks the format of the given information and throws either an InvalidUserNameException or
		 * InvalidEmailException if it's invalid.
		 * Checks that the user name or E-Mail address do not yet exist in the directory and throws an
		 * AlreadyInUseException if one of them does.
		 * Generates a verification key and sends it over mail to the new E-Mail address to validate it.
		 * The key can be checked using verifyMailKey() and if it matches, the user registration is
		 * finalized in registerComplete().
		 */
		public function registerRequest($username, $email, $mailsubject, $mailtemplate)
		{
			// Verify that user name and E-Mail address are valid.
			if (!$this->_isValidNewUserName($username))
				throw new InvalidUserNameException();

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				throw new InvalidEmailException();

			// Check if the E-Mail domain is forbidden.
			if ($this->_isForbiddenMailDomain($email))
				throw new InvalidEmailException();

			// Check if the username is "forbidden" (see function description).
			if ($this->_isForbiddenUsername($username))
				throw new AlreadyInUseException();

			// Check if the E-Mail address is already in the LDAP database.
			if ($this->_isMailInLDAPDirectory($email))
				throw new AlreadyInUseException();

			// Generate and store a verification key and send an E-Mail to verify the E-Mail address.
			$this->_generateVerificationKeyAndSendMail($username, $email, "registration", $mailsubject, $mailtemplate);

			// Clean expired entries in the "pending" table while we're at it.
			$this->_cleanExpired("pending");
		}

		/**
		 * Step 2 of registering a new user with the given information.
		 * Performs the actual change in the LDAP directory and deletes the verification entry from the "pending" table.
		 * Throws an AlreadyInUseException if the user name or E-Mail address already exist in the directory.
		 */
		public function registerComplete($username, $email, $displayname, $password)
		{
			// Verify that the display name and password are valid.
			if (!$this->_isValidDisplayName($displayname))
				throw new InvalidDisplayNameException();

			if (!$this->_isValidPassword($password))
				throw new InvalidPasswordException();

			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Delete the entry from the "pending" table.
			$this->_deletePendingEntry($username, $email);

			// Try to add the normalized username to the "forbidden_usernames" table.
			$normalized_username = $this->_normalizeUserName($username);
			$stmt = $this->_dbh->prepare("INSERT INTO forbidden_usernames (username) VALUES (:username)");
			$stmt->bindParam(":username", $normalized_username);

			try
			{
				$stmt->execute();
			}
			catch (PDOException $e)
			{
				// SQL Error Code 23000 means "Constraint Violation", i.e. the entry already exists in the table.
				if ($e->getCode() == 23000)
					throw new AlreadyInUseException();
				else
					throw $e;
			}

			// Try to add the entry to the LDAP directory.
			// It is configured to require unique values for the "cn" and "mail" fields.
			// If either one already exists, ldap_add fails and this is translated to an AlreadyInUseException.
			$dn = $this->_getUserNameDN($username);
			$info = [
				"objectClass" => "inetOrgPerson",
				"cn" => $username,
				"sn" => $username,
				"mail" => $email,
				"displayName" => $displayname,
				"userPassword" => $this->_getPasswordHash($password),
			];
			if (!@ldap_add($this->_ds, $dn, $info))
				throw new AlreadyInUseException();
		}

		/**
		 * Step 1 of resetting the password of the given user name.
		 * Fetches the E-Mail address for the user name and throws an InvalidUserNameException if no such user exists.
		 * Generates a verification key and sends it over mail to the E-Mail address to reset the password.
		 */
		public function resetPasswordRequest($username, $mailsubject, $mailtemplate)
		{
			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Fetch the E-Mail address.
			$dn = $this->_getUserNameDN($username);
			$sr = ldap_read($this->_ds, $dn, "(objectClass=*)", ["mail"]);
			$info = ldap_get_entries($this->_ds, $sr);
			if ($info["count"] != 1)
				throw new InvalidUserNameException();

			// Generate and store a verification key and send an E-Mail to reset the password.
			$this->_generateVerificationKeyAndSendMail($username, $info[0]["mail"][0], "resetpassword", $mailsubject, $mailtemplate);
		}

		/**
		 * Step 2 of resetting the password of the given user name.
		 * Performs the actual password change in the LDAP directory and deletes the verification entry from the "pending" table.
		 * Throws an InvalidPasswordException if the password does not fulfill the criteria for valid passwords.
		 */
		public function resetPasswordComplete($username, $email, $new_password)
		{
			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Try to change the password.
			$this->_changePassword($username, $new_password);

			// Delete the entry from the "pending" table.
			$this->_deletePendingEntry($username, $email);
		}

		/**
		 * Looks up the user name associated to the given E-Mail address in the LDAP directory and sends it by E-Mail.
		 * Throws an InvalidEmailException if no entry for that E-Mail address is stored in the LDAP directory.
		 */
		public function sendUsername($email, $mailsubject, $mailtemplate)
		{
			// Connect to LDAP using the service account.
			$this->_connectToLDAP();

			// Fetch the user name.
			$email_escaped = ldap_escape($email, null, LDAP_ESCAPE_FILTER);
			$filter = "(mail={$email_escaped})";
			$sr = ldap_search($this->_ds, ROSLOGIN_LDAP_BASE_DN, $filter);
			$info = ldap_get_entries($this->_ds, $sr);
			if ($info["count"] != 1)
				throw new InvalidEmailException();

			// Send the user name by E-Mail.
			$mail_replacements = [
				"USERNAME" => $info[0]["cn"][0],
			];
			$mailtext = strtr($mailtemplate, $mail_replacements);
			mail($email, $mailsubject, $mailtext, "From: " . ROSLOGIN_MAIL_FROM);
		}

		/**
		 * Checks if the given user name, E-Mail address, and verification key combination exists in the
		 * "pending" table of the database.
		 * Returns the type ("mailchange", "registration" or "resetpassword") if they do.
		 * Otherwise, an InvalidVerificationException is thrown.
		 *
		 * This function must be used as part of changing the E-Mail address or registering a new user.
		 */
		public function verifyMailKey($username, $email, $key)
		{
			// Check the "pending" table of the database for the
			// user name, E-Mail address, verification key combination.
			$this->_connectToDB();
			$stmt = $this->_dbh->prepare(
				"SELECT type FROM pending " .
				"WHERE username = :username AND email = :email AND verification_key = :verification_key AND timeout > NOW()"
			);
			$stmt->bindParam(":username", $username);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":verification_key", $key);
			$stmt->execute();
			$result = $stmt->fetchColumn();

			// If the key is valid, return the type ("mailchange", "registration" or "resetpassword").
			// Otherwise, throw an InvalidVerificationException.
			if ($result)
				return $result;
			else
				throw new InvalidVerificationException();
		}
	}
