<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Presenting a message
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class MessagePage
	{
		private $_title;
		private $_heading;
		private $_message;

		public function __construct()
		{
			global $roslogin_langres;

			if (array_key_exists("register_sent", $_GET))
			{
				if (!array_key_exists("email", $_GET))
					throw new RuntimeException("email not specified");

				$email = htmlspecialchars($_GET["email"]);
				$this->_title = $roslogin_langres["register_title"];
				$this->_heading = $roslogin_langres["register_heading"];
				$this->_message = sprintf($roslogin_langres["register_sent"], $email);
			}
			else if (array_key_exists("register_in_use", $_GET))
			{
				$this->_title = $roslogin_langres["register_title"];
				$this->_heading = $roslogin_langres["register_heading"];
				$this->_message = sprintf($roslogin_langres["in_use_reregister"], "?p=register");
			}
			else if (array_key_exists("register_finished", $_GET))
			{
				$this->_title = $roslogin_langres["register_title"];
				$this->_heading = $roslogin_langres["register_heading"];
				$this->_message = sprintf($roslogin_langres["finished_registration"], "?p=login");
			}
			else if (array_key_exists("reset_password_sent", $_GET))
			{
				$this->_title = $roslogin_langres["forgot_title"];
				$this->_heading = $roslogin_langres["forgot_heading"];
				$this->_message = $roslogin_langres["reset_password_sent"];
			}
			else if (array_key_exists("reset_password_finished", $_GET))
			{
				$this->_title = $roslogin_langres["reset_password_title"];
				$this->_heading = $roslogin_langres["reset_password_heading"];
				$this->_message = sprintf($roslogin_langres["finished_password_reset"], "?p=login");
			}
			else if (array_key_exists("username_sent", $_GET))
			{
				if (!array_key_exists("email", $_GET))
					throw new RuntimeException("email not specified");

				$email = htmlspecialchars($_GET["email"]);
				$this->_title = $roslogin_langres["forgot_title"];
				$this->_heading = $roslogin_langres["forgot_heading"];
				$this->_message = sprintf($roslogin_langres["username_sent"], $email);
			}
			else
			{
				throw new RuntimeException("No message");
			}
		}

		public function printTitle()
		{
			echo $this->_title;
		}

		public function printHead()
		{
		}

		public function printContent()
		{
?>
			<p class="lead center"><?php echo $this->_heading; ?></p>
			<hr>

			<div class="col-md-offset-3 col-md-6">
				<fieldset class="form-group">
					<?php echo $this->_message; ?>
				</fieldset>
			</div>
<?php
		}
	}
