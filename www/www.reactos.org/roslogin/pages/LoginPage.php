<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Presenting a form for logging in
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class LoginPage
	{
		public function __construct()
		{
			// Forward to the Self-Service if the user is already logged in.
			$rl = new RosLogin();
			if ($rl->isLoggedIn())
				redirect_to("?p=selfservice");
		}

		public function printTitle()
		{
			global $roslogin_langres;
			echo $roslogin_langres["login_title"];
		}

		public function printHead()
		{
		}

		public function printContent()
		{
			global $roslogin_langres;

			$redirect = array_key_exists("redirect", $_GET) && is_valid_redirect($_GET["redirect"]) ? htmlspecialchars($_GET["redirect"]) : "";

			$invalid = array_key_exists("invalid", $_GET);
?>
			<p class="lead center"><?php echo $roslogin_langres["login_heading"]; ?></p>
			<hr>

			<form class="form-horizontal" method="post">
				<input type="hidden" name="a" value="login">
				<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

				<div class="col-md-offset-3 col-md-6">
					<fieldset class="form-group">
						<?php echo $roslogin_langres["login_intro"]; ?>
					</fieldset>

					<fieldset class="form-group">
						<div class="form-group <?php if ($invalid) { echo "has-error"; } ?>">
							<label for="username" class="col-md-4 control-label"><?php echo $roslogin_langres["username"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="username">
							</div>
						</div>

						<div class="form-group <?php if ($invalid) { echo "has-error"; } ?>">
							<label for="password" class="col-md-4 control-label"><?php echo $roslogin_langres["password"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="password" name="password">
								<?php
									if ($invalid)
										echo '<span class="help-block">' . $roslogin_langres["login_invalid"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn btn-primary"><?php echo $roslogin_langres["login_button"]; ?></button>
								&nbsp;
								<a href="?p=forgot"><?php echo $roslogin_langres["login_forgot"]; ?></a>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<?php printf($roslogin_langres["login_register"], "?p=register"); ?>
					</fieldset>
				</div>
			</form>
<?php
		}
	}
