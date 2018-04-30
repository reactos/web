<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     PHP Exceptions for RosLogin
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	/** The user name is invalid. If it's a new user name, it may be empty, too long or containing invalid characters. */
	class InvalidUserNameException extends Exception
	{
	}

	/** The E-Mail address has an invalid format. */
	class InvalidEmailException extends Exception
	{
	}

	/** The password is too short or too long. */
	class InvalidPasswordException extends Exception
	{
	}

	/** The display name is too short. */
	class InvalidDisplayNameException extends Exception
	{
	}

	/** User name or E-Mail address are already in use by another account. */
	class AlreadyInUseException extends Exception
	{
	}

	/** The provided login credentials (username + password) are invalid. */
	class InvalidCredentialsException extends Exception
	{
	}

	/** The user name, E-Mail address, verification key combination is invalid. */
	class InvalidVerificationException extends Exception
	{
	}

	/** The user did not correctly solve the CAPTCHA. */
	class CaptchaNotSolvedException extends Exception
	{
	}
