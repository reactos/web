<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     The main admin page for RosLogin
 * COPYRIGHT:   Copyright 2020 Mark Jansen (mark.jansen@reactos.org)
 */

	class AdminPage
	{
		private $_ra;
		private $_banned_users;

		public function __construct($ra)
		{
			$this->_ra = $ra;
			$this->_banned_users = $this->_ra->getBannedUsers();
		}

		public function printBreadcrumbs()
		{
			echo " / <a href=\"/roslogin/admin\">admin</a>";
		}

		public function printTitle()
		{
			echo $this->_ra->userTitle() . " - home";
		}

		public function printHead()
		{
		}

		public function printContent()
		{
			$username = array_key_exists("username", $_GET) ? htmlspecialchars($_GET["username"]) : "";

			$invalid_username = array_key_exists("invalid_username", $_GET);
?>
			<p class="lead center col-md-10">Search user</p>
			<form class="form-horizontal" method="get">
				<input type="hidden" name="p" value="user">

				<div class="col-md-offset-1 col-md-8">
					<fieldset class="form-group">
						<div class="form-group <?php if ($invalid_username) { echo "has-error"; } ?>">
							<label for="username" class="col-md-4 control-label">Username</label>
							<div class="col-md-8">
								<input required class="form-control" type="text" name="username">
								<?php
									if ($invalid_username)
										echo "<span class=\"help-block\">Invalid username ($username)</span>";
								?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn btn-primary">Search</button>
							</div>
						</div>
					</fieldset>
				</div>
			</form>
<hr>
<p></p>
			<p class="lead center col-md-10">Banned users</p>
			<table class="col-md-offset-1 table table-striped table-bordered">
				<tr><th class="col-md-3">Username</th><th class="col-md-3">Display Name</th><th></th></tr>
<?php
				foreach ($this->_banned_users as $user)
				{
					$cn = htmlspecialchars($user['cn'][0]);
					$dn = htmlspecialchars($user['displayname'][0]);
					echo "<tr><td class=\"col-md-3\">$cn</td><td class=\"col-md-3\">$dn</td><td>";
?>
					<form class="form-horizontal" method="get">
						<input type="hidden" name="p" value="user">
						<input type="hidden" name="username" value="<?php echo $cn; ?>">
						<button type="submit" class="btn btn-info">View</button>
					</form>
<?php
					echo "</td></tr>";
				}
?>
			</table>
<?php
		}
	}
