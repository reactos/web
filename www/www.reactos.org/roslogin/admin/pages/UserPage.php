<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     The main admin page for RosLogin
 * COPYRIGHT:   Copyright 2020 Mark Jansen (mark.jansen@reactos.org)
 */

	class UserPage
	{
		private $_ra;
		private $_userinfo;

		private function _checkMark($value, $color)
		{
			if ($value)
				return "<i style=\"color: $color;\" class=\"far fa-check-circle\"></i>";
			return "";
		}

		public function __construct($ra)
		{
			if (!array_key_exists("username", $_GET))
			{
				throw new RuntimeException("Necessary information not specified");
			}

			$this->_ra = $ra;
			$data = [
				"username" => $_GET["username"],
			];

			try
			{
				$this->_userinfo = $this->_ra->getUserWithGroupInformation($_GET["username"]);
			}
			catch (InvalidUserNameException $e)
			{
				// Search failed, so redirect back
				redirect_to("?p=home&invalid_username=1&" . http_build_query($data));
			}
		}

		public function printBreadcrumbs()
		{
			echo " / <a href=\"/roslogin/admin\">admin</a>";
		}

		public function printTitle()
		{
			echo $this->_ra->userTitle() . " - viewing user";
		}

		public function printHead()
		{
		}

		public function printContent()
		{
			$info = $this->_userinfo;
			$is_mod = RosAdmin::checkMod($info);
			$is_admin = RosAdmin::checkAdmin($info);
			$can_ban = $this->_ra->canBan($info);

			$username = htmlspecialchars($_GET["username"]);
			$displayname = htmlspecialchars($info["displayname"]);
			$email = htmlspecialchars($info["email"]);

			$banned = array_key_exists("banned", $_GET);
			$already_banned = array_key_exists("already_banned", $_GET);
			$unbanned = array_key_exists("unbanned", $_GET);
			$was_not_banned = array_key_exists("was_not_banned", $_GET);

			if ($banned || $already_banned || $unbanned || $was_not_banned)
			{
?>
			<p class="lead center col-md-9">Message</p>
			<form>
				<div class="form-group col-md-offset-1 col-md-8">
					<label class="control-label">
						<?php
							if ($banned)
								echo "User has been banned";
							else if ($already_banned)
								echo "User has already been banned";
							else if ($unbanned)
								echo "User has been unbanned and a Reset Password email sent";
							else if ($was_not_banned)
								echo "User was not banned";
						?>
					</label>
				</div>
			</form>
<?php
			}
?>

			<p class="lead center col-md-9">User Information</p>
			<table class="col-md-offset-1 table table-striped table-bordered">
				<tr>
					<th class="col-md-3">Username</th><td><?php echo $username; ?></td>
				</tr>
				<tr>
					<th class="col-md-3">Display Name</th><td><?php echo $displayname; ?></td>
				</tr>
				<tr>
					<th class="col-md-3">E-Mail Address</th><td><?php echo $email; ?></td>
				</tr>
				<tr>
					<th class="col-md-3">Banned</th><td><?php echo $this->_checkMark($info['banned'], 'red'); ?></td>
				</tr>
				<tr>
					<th class="col-md-3">Moderator</th><td><?php echo $this->_checkMark($is_mod, 'green'); ?></td>
				</tr>
				<tr>
					<th class="col-md-3">Administrator</th><td><?php echo $this->_checkMark($is_admin, 'green'); ?></td>
				</tr>
				<tr>
					<form class="form-horizontal" method="post">
					<input type="hidden" name="username" value="<?php echo $username; ?>">

					<th class="col-md-3">Actions</th><td><?php
					if ($info['banned'])
					{
?>
						<button type="submit" name="a" value="unban" class="btn btn-warning" <?php if (!$can_ban) { echo "disabled"; } ?>>Unban</button>
<?php
					}
					else
					{
?>
						<button type="submit" name="a" value="ban" class="btn btn-danger" <?php if (!$can_ban) { echo "disabled"; } ?>>Ban</button>
<?php
					}
					?></td>
					</form>
				</tr>
			</table>
<?php
		}
	}
