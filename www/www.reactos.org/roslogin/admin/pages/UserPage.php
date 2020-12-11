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

			$revoke_ok = array_key_exists("revoke_ok", $_GET);
			$revoke_all_ok = array_key_exists("revoke_all_ok", $_GET);
			$revoke_problem = array_key_exists("revoke_problem", $_GET);
			$revoke_all_problem = array_key_exists("revoke_all_problem", $_GET);
			if ($revoke_problem || $revoke_all_problem)
				$revoke_error = $this->_ra->mm->getLastError();
			$chat_sessions = null;
			$chat_audits = null;
			$chat_user_id = $this->_ra->mm->getUserByName($_GET["username"]);
			if (!is_null($chat_user_id))
			{
				$chat_sessions = $this->_ra->mm->getSessionsById($chat_user_id);
				$chat_audits = $this->_ra->mm->getAuditsById($chat_user_id);
			}
			$chat_message = "";
			if (is_null($chat_user_id) || is_null($chat_sessions) || is_null($chat_audits))
			{
				$chat_message = $this->_ra->mm->getLastError();
				if ($chat_message != "User is not registered in Mattermost")
				{
					if (is_null($chat_user_id))
						$chat_message = "Failed to get user ID: {$chat_message}";
					else if (is_null($chat_sessions))
						$chat_message = "Failed to get user sessions: {$chat_message}";
					else if (is_null($chat_audits))
						$chat_message = "Failed to get user audits: {$chat_message}";
				}
			}
			else if (count($chat_sessions) == 0)
			{
				$chat_message = "User has no active Mattermost sessions";
			}

			$user_message = "";
			if ($banned || $already_banned || $unbanned || $was_not_banned)
			{
				if ($banned)
					$user_message = "User has been banned";
				else if ($already_banned)
					$user_message = "User has already been banned";
				else if ($unbanned)
					$user_message = "User has been unbanned and a Reset Password email sent";
				else if ($was_not_banned)
					$user_message = "User was not banned";
			}
			else if ($revoke_ok || $revoke_all_ok || $revoke_problem || $revoke_all_problem)
			{
				if ($revoke_ok)
					$user_message = "User session has been revoked";
				else if ($revoke_all_ok)
					$user_message = "All user sessions has been revoked";
				else if ($revoke_problem)
					$user_message = "Failed to revoke user session: {$revoke_error}";
				else if ($revoke_all_problem)
					$user_message = "Failed to revoke all user sessions: {$revoke_error}";
			}

			if (!empty($user_message))
			{
?>
			<p class="lead center col-md-9">Message</p>
			<form>
				<div class="form-group col-md-offset-1 col-md-8">
					<label class="control-label">
						<?php echo $user_message; ?>
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

			<p class="lead center col-md-9">Mattermost Sessions</p>
<?php
			if (!empty($chat_message))
			{
?>
			<div class="col-md-10 col-md-offset-1"><?php echo $chat_message; ?></div>
<?php
			}
			else
			{
?>
			<table class="col-md-offset-1 table table-striped table-bordered">
				<tr>
					<th>
						<form class="form-horizontal" method="post">
						<input type="hidden" name="username" value="<?php echo $username; ?>">
						<input type="hidden" name="user_id" value="<?php echo $chat_user_id; ?>">
						<button type="submit" name="a" value="revoke_all" class="btn btn-danger">Revoke All</button>
						</form>
					</th>
					<th>Token</th>
					<th>IP Addresses</th>
					<th>User Agent</th>
				</tr>
<?php
				for ($i = 0; $i < count($chat_sessions); $i++)
				{
					$e = $chat_sessions[$i];
					$ua = $e['props']['os'];
					if (empty($ua))
						$ua = $e['props']['platform'];
					if (!empty($ua))
						$ua .= ' - ';
					$ua .= $e['props']['browser'];
?>
				<tr>
					<td>
						<form class="form-horizontal" method="post">
						<input type="hidden" name="username" value="<?php echo $username; ?>">
						<input type="hidden" name="user_id" value="<?php echo $chat_user_id; ?>">
						<input type="hidden" name="session_id" value="<?php echo $e['id']; ?>">
						<button type="submit" name="a" value="revoke" class="btn btn-warning">Revoke</button>
						</form>
					</td>
					<td><? echo $e['token']; ?></td>
					<td><? echo implode('<br>', $this->_ra->mm->getSessionAddresses($chat_audits, $e['id'])); ?></td>
					<td><? echo htmlspecialchars($ua); ?></td>
				</tr>
<?php
				}
?>
			</table>
<?php
			}
		}
	}
