<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Presenting a form for resetting the password or sending the username by E-Mail
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	require_once("Captcha.php");

	class ForgotPage
	{
		private $_captcha;

		public function __construct()
		{
			$this->_captcha = new Captcha();
		}

		public function printBreadcrumbs()
		{
		}

		public function printTitle()
		{
			global $roslogin_langres;
			echo $roslogin_langres["forgot_title"];
		}

		public function printHead()
		{
			$this->_captcha->printHead();
		}

		public function printContent()
		{
			global $roslogin_langres;

			$username = array_key_exists("username", $_GET) ? htmlspecialchars($_GET["username"]) : "";
			$email = array_key_exists("email", $_GET) ? htmlspecialchars($_GET["email"]) : "";

			$unknown_username = array_key_exists("unknown_username", $_GET);
			$reset_password_captcha_not_solved = array_key_exists("reset_password_captcha_not_solved", $_GET);
			$send_username_captcha_not_solved = array_key_exists("send_username_captcha_not_solved", $_GET);
?>
			<p class="lead center"><?php echo $roslogin_langres["forgot_heading"]; ?></p>
			<hr>

			<div class="col-md-offset-3 col-md-6">
				<fieldset class="form-group">
					<legend><?php echo $roslogin_langres["forgot_password"]; ?></legend>

					<div class="form-group">
						<?php echo $roslogin_langres["forgot_password_intro"]; ?>
					</div>

					<form class="form-horizontal" method="post">
						<input type="hidden" name="a" value="reset_password">

						<div class="form-group <?php if ($unknown_username) { echo "has-error"; } ?>">
							<label for="username" class="col-md-4 control-label"><?php echo $roslogin_langres["username"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="username" value="<?php echo $username; ?>">
								<?php
									if ($unknown_username)
										echo '<span class="help-block">' . $roslogin_langres["unknown_username"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group <?php if ($reset_password_captcha_not_solved) { echo "has-error"; } ?>">
							<div class="col-md-offset-4 col-md-8">
								<?php
									$this->_captcha->printWidget();

									if ($reset_password_captcha_not_solved)
										echo '<span class="help-block">' . $roslogin_langres["captcha_not_solved"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn btn-primary"><?php echo $roslogin_langres["reset_password_button"]; ?></button>
							</div>
						</div>
					</form>
				</fieldset>

				<fieldset class="form-group">
					<legend><?php echo $roslogin_langres["forgot_username"]; ?></legend>

					<div class="form-group">
						<?php echo $roslogin_langres["forgot_username_intro"]; ?>
					</div>

					<form class="form-horizontal" method="post">
						<input type="hidden" name="a" value="send_username">

						<div class="form-group">
							<label for="email" class="col-md-4 control-label"><?php echo $roslogin_langres["email"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="email" value="<?php echo $email; ?>">
							</div>
						</div>

						<div class="form-group <?php if ($send_username_captcha_not_solved) { echo "has-error"; } ?>">
							<div class="col-md-offset-4 col-md-8">
								<?php
									$this->_captcha->printWidget();

									if ($send_username_captcha_not_solved)
										echo '<span class="help-block">' . $roslogin_langres["captcha_not_solved"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn btn-primary"><?php echo $roslogin_langres["send_username_button"]; ?></button>
							</div>
						</div>
					</form>
				</fieldset>
			</div>
<?php
		}
	}
