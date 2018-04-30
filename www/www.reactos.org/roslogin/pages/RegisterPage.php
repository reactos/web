<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Presenting a form for registering a new user account
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	require_once("Captcha.php");

	class RegisterPage
	{
		private $_captcha;

		public function __construct()
		{
			$this->_captcha = new Captcha();
		}

		public function printTitle()
		{
			global $roslogin_langres;
			echo $roslogin_langres["register_title"];
		}

		public function printHead()
		{
			$this->_captcha->printHead();
		}

		public function printContent()
		{
			global $roslogin_langres;

			$username = array_key_exists("username", $_GET) ? $_GET["username"] : "";
			$email = array_key_exists("email", $_GET) ? $_GET["email"] : "";

			$invalid_username = array_key_exists("invalid_username", $_GET);
			$invalid_email = array_key_exists("invalid_email", $_GET);
			$in_use = array_key_exists("in_use", $_GET);
			$captcha_not_solved = array_key_exists("captcha_not_solved", $_GET);
?>
			<p class="lead center"><?php echo $roslogin_langres["register_heading"]; ?></p>
			<hr>

			<form class="form-horizontal" method="post">
				<input type="hidden" name="a" value="register">

				<div class="col-md-offset-3 col-md-6">
					<fieldset class="form-group">
						<?php echo $roslogin_langres["register_intro"]; ?>
					</fieldset>

					<fieldset class="form-group">
						<div class="form-group <?php if ($invalid_username || $in_use) { echo "has-error"; } ?>">
							<label for="username" class="col-md-4 control-label"><?php echo $roslogin_langres["username"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="username" value="<?php echo $username; ?>">
								<?php
									if ($invalid_username)
										echo '<span class="help-block">' . $roslogin_langres["invalid_username"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group <?php if ($invalid_email || $in_use) { echo "has-error"; } ?>">
							<label for="email" class="col-md-4 control-label"><?php echo $roslogin_langres["email"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="email" value="<?php echo $email; ?>">
								<?php
									if ($invalid_email)
										echo '<span class="help-block">' . $roslogin_langres["invalid_email"] . '</span>';
									else if ($in_use)
										echo '<span class="help-block">' . $roslogin_langres["in_use"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group <?php if ($captcha_not_solved) { echo "has-error"; } ?>">
							<div class="col-md-offset-4 col-md-8">
								<?php
									$this->_captcha->printWidget();

									if ($captcha_not_solved)
										echo '<span class="help-block">' . $roslogin_langres["captcha_not_solved"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn btn-primary"><?php echo $roslogin_langres["register_button"]; ?></button>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
<?php
		}
	}
