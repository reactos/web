<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Verifying the mail key and presenting a form for the next step (based on the type of the pending operation)
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class ConfirmPage
	{
		private $_rl;
		private $_type;

		private function _printInvalidVerificationContent()
		{
			global $roslogin_langres;
?>
			<div class="col-md-offset-3 col-md-6">
				<fieldset class="form-group">
					<?php echo $roslogin_langres["confirm_invalid"]; ?>
				</fieldset>
			</div>
<?php
		}

		private function _printMailChangeContent()
		{
			global $roslogin_langres;

			try
			{
				// Try to complete the request.
				$this->_rl->changeEmailComplete($_GET["username"], $_GET["email"]);
				$message = sprintf($roslogin_langres["confirm_mailchange_intro"], $_GET["email"]);
			}
			catch (AlreadyInUseException $e)
			{
				$message = sprintf($roslogin_langres["confirm_mailchange_in_use"], $_GET["email"]);
			}
?>
			<p class="lead center"><?php echo $roslogin_langres["confirm_mailchange_heading"]; ?></p>
			<hr>

			<div class="col-md-offset-3 col-md-6">
				<fieldset class="form-group">
					<?php echo $message; ?>
				</fieldset>
			</div>
<?php
		}

		private function _printRegistrationContent()
		{
			global $roslogin_langres;

			// Fill the Display Name field with the Username by default.
			$displayname = array_key_exists("displayname", $_GET) ? $_GET["displayname"] : $_GET["username"];

			$invalid_displayname = array_key_exists("invalid_displayname", $_GET);
			$invalid_password = array_key_exists("invalid_password", $_GET);
			$password_mismatch = array_key_exists("password_mismatch", $_GET);
?>
			<p class="lead center"><?php echo $roslogin_langres["confirm_registration_heading"]; ?></p>
			<hr>

			<form class="form-horizontal" method="post">
				<input type="hidden" name="a" value="register_complete">
				<input type="hidden" name="username" value="<?php echo $_GET["username"]; ?>">
				<input type="hidden" name="email" value="<?php echo $_GET["email"]; ?>">
				<input type="hidden" name="key" value="<?php echo $_GET["key"]; ?>">

				<div class="col-md-offset-3 col-md-6">
					<fieldset class="form-group">
						<?php echo $roslogin_langres["confirm_registration_intro"]; ?>
					</fieldset>

					<fieldset class="form-group">
						<div class="form-group <?php if ($invalid_displayname) { echo "has-error"; } ?>">
							<label for="displayname" class="col-md-4 control-label"><?php echo $roslogin_langres["displayname"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="displayname" value="<?php echo $displayname; ?>">
								<?php
									if ($invalid_displayname)
										echo '<span class="help-block">' . $roslogin_langres["invalid_displayname"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group <?php if ($invalid_password || $password_mismatch) { echo "has-error"; } ?>">
							<label for="password" class="col-md-4 control-label"><?php echo $roslogin_langres["password"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="password" name="password">
							</div>
						</div>

						<div class="form-group <?php if ($invalid_password || $password_mismatch) { echo "has-error"; } ?>">
							<label for="reenter_password" class="col-md-4 control-label"><?php echo $roslogin_langres["reenter_password"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="password" name="reenter_password">
								<?php
									if ($invalid_password)
										echo '<span class="help-block">' . $roslogin_langres["invalid_password"] . '</span>';
									else if ($password_mismatch)
										echo '<span class="help-block">' . $roslogin_langres["password_mismatch"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn btn-primary"><?php echo $roslogin_langres["finish_registration_button"]; ?></button>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
<?php
		}

		private function _printResetPasswordContent()
		{
			global $roslogin_langres;

			// Fill the Display Name field with the Username by default.
			$invalid_password = array_key_exists("invalid_password", $_GET);
			$password_mismatch = array_key_exists("password_mismatch", $_GET);
?>
			<p class="lead center"><?php echo $roslogin_langres["reset_password_heading"]; ?></p>
			<hr>

			<form class="form-horizontal" method="post">
				<input type="hidden" name="a" value="reset_password_complete">
				<input type="hidden" name="username" value="<?php echo $_GET["username"]; ?>">
				<input type="hidden" name="email" value="<?php echo $_GET["email"]; ?>">
				<input type="hidden" name="key" value="<?php echo $_GET["key"]; ?>">

				<div class="col-md-offset-3 col-md-6">
					<fieldset class="form-group">
						<?php echo $roslogin_langres["reset_password_intro"]; ?>
					</fieldset>

					<fieldset class="form-group">
						<div class="form-group <?php if ($invalid_password || $password_mismatch) { echo "has-error"; } ?>">
							<label for="password" class="col-md-4 control-label"><?php echo $roslogin_langres["password"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="password" name="password">
							</div>
						</div>

						<div class="form-group <?php if ($invalid_password || $password_mismatch) { echo "has-error"; } ?>">
							<label for="reenter_password" class="col-md-4 control-label"><?php echo $roslogin_langres["reenter_password"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="password" name="reenter_password">
								<?php
									if ($invalid_password)
										echo '<span class="help-block">' . $roslogin_langres["invalid_password"] . '</span>';
									else if ($password_mismatch)
										echo '<span class="help-block">' . $roslogin_langres["password_mismatch"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn btn-primary"><?php echo $roslogin_langres["save_button"]; ?></button>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
<?php
		}

		public function __construct()
		{
			if (!array_key_exists("username", $_GET) ||
				!array_key_exists("email", $_GET) ||
				!array_key_exists("key", $_GET))
			{
				throw new RuntimeException("Necessary information not specified");
			}

			try
			{
				$this->_rl = new RosLogin();
				$this->_type = $this->_rl->verifyMailKey($_GET["username"], $_GET["email"], $_GET["key"]);
			}
			catch (InvalidVerificationException $e)
			{
				$this->_type = NULL;
			}
		}

		public function printTitle()
		{
			global $roslogin_langres;

			if ($this->_type == "resetpassword")
				echo $roslogin_langres["reset_password_title"];
			else
				echo $roslogin_langres["confirm_title"];
		}

		public function printHead()
		{
		}

		public function printContent()
		{
			global $roslogin_langres;

			if ($this->_type == "mailchange")
				$this->_printMailChangeContent();
			else if ($this->_type == "registration")
				$this->_printRegistrationContent();
			else if ($this->_type == "resetpassword")
				$this->_printResetPasswordContent();
			else
				$this->_printInvalidVerificationContent();
		}
	}
