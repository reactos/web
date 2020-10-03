<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Presenting a form for managing the information stored for a user account (if the user is logged in)
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	class SelfServicePage
	{
		private $_userinfo;
		private $_username;

		public function __construct()
		{
			$rl = new RosLogin();
			$this->_username = $rl->isLoggedIn();

			// Forward to the Login page if the user is not logged in.
			if (!$this->_username)
				redirect_to("?p=login");

			$this->_userinfo = $rl->getUserInformation($this->_username);
		}

		public function printBreadcrumbs()
		{
		}

		public function printTitle()
		{
			global $roslogin_langres;
			echo $roslogin_langres["selfservice_title"];
		}

		public function printHead()
		{
		}

		public function printContent()
		{
			global $roslogin_langres;

			$displayname = array_key_exists("displayname", $_GET) ? htmlspecialchars($_GET["displayname"]) : htmlspecialchars($this->_userinfo["displayname"]);
			$email = array_key_exists("email", $_GET) ? htmlspecialchars($_GET["email"]) : htmlspecialchars($this->_userinfo["email"]);

			$success = array_key_exists("success", $_GET);
			$sent = array_key_exists("sent", $_GET);
			$invalid_displayname = array_key_exists("invalid_displayname", $_GET);
			$invalid_email = array_key_exists("invalid_email", $_GET);
			$invalid_current_password = array_key_exists("invalid_current_password", $_GET);
			$invalid_new_password = array_key_exists("invalid_new_password", $_GET);
			$password_mismatch = array_key_exists("password_mismatch", $_GET);
?>
			<p class="lead center"><?php echo $roslogin_langres["selfservice_heading"]; ?></p>
			<hr>

			<form class="form-horizontal" method="post">
				<input type="hidden" name="a" value="selfservice_save">

				<div class="col-md-offset-3 col-md-6">
					<fieldset class="form-group">
						<?php printf($roslogin_langres["selfservice_intro"], htmlspecialchars($this->_username)); ?>

						<div class="has-success">
							<?php
								if ($success)
								{
									echo '<span class="help-block">';
									echo $roslogin_langres["selfservice_success"] . '<br>';

									if ($sent)
										printf($roslogin_langres["register_sent"], $email);

									echo '</span>';
								}
							?>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<legend><?php echo $roslogin_langres["general"]; ?></legend>

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

						<div class="form-group <?php if ($invalid_email) { echo "has-error"; } ?>">
							<label for="email" class="col-md-4 control-label"><?php echo $roslogin_langres["email"]; ?></label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="email" value="<?php echo $email; ?>">
								<?php
									if ($invalid_email)
										echo '<span class="help-block">' . $roslogin_langres["invalid_email"] . '</span>';
								?>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-group">
						<legend><?php echo $roslogin_langres["change_password"]; ?></legend>

						<div class="form-group <?php if ($invalid_current_password) { echo "has-error"; } ?>">
							<label for="current_password" class="col-md-4 control-label"><?php echo $roslogin_langres["current_password"]; ?></label>
							<div class="col-md-8">
								<input class="form-control" type="password" name="current_password">
								<?php
									if ($invalid_current_password)
										echo '<span class="help-block">' . $roslogin_langres["invalid_current_password"] . '</span>';
								?>
							</div>
						</div>

						<div class="form-group <?php if ($invalid_new_password || $password_mismatch) { echo "has-error"; } ?>">
							<label for="new_password" class="col-md-4 control-label"><?php echo $roslogin_langres["new_password"]; ?></label>
							<div class="col-md-8">
								<input class="form-control" type="password" name="new_password">
							</div>
						</div>

						<div class="form-group <?php if ($invalid_new_password || $password_mismatch) { echo "has-error"; } ?>">
							<label for="reenter_new_password" class="col-md-4 control-label"><?php echo $roslogin_langres["reenter_new_password"]; ?></label>
							<div class="col-md-8">
								<input class="form-control" type="password" name="reenter_new_password">
								<?php
									if ($invalid_new_password)
										echo '<span class="help-block">' . $roslogin_langres["invalid_password"] . '</span>';
									else if ($password_mismatch)
										echo '<span class="help-block">' . $roslogin_langres["password_mismatch"] . '</span>';
								?>
							</div>
						</div>
					</fieldset>

					<div class="form-group">
						<div class="col-md-offset-4 col-md-8">
							<button type="submit" class="btn btn-primary"><?php echo $roslogin_langres["save_button"]; ?></button>
							&nbsp;
							<a href="?a=logout" class="btn btn-default"><?php echo $roslogin_langres["logout_button"]; ?></a>
						</div>
					</div>
				</div>
			</form>
<?php
		}
	}
