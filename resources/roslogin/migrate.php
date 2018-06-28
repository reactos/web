<?php
/*
 * PROJECT:     RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory
 * LICENSE:     AGPL-3.0-or-later (https://spdx.org/licenses/AGPL-3.0-or-later)
 * PURPOSE:     Migration script from Drupal + MediaWiki + phpBB + JIRA
 * COPYRIGHT:   Copyright 2018 Colin Finck (colin@reactos.org)
 */

	// Configuration
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('ROSLOGIN_LDAP_HOST', 'localhost');
	define('ROSLOGIN_LDAP_BIND_DN', 'uid=roslogin,ou=Service Accounts,o=ReactOS Website');
	define('ROSLOGIN_LDAP_BIND_PW', 'test');
	define('ROSLOGIN_LDAP_BASE_DN', 'ou=People,o=ReactOS Website');

	// Include phpBB UTF8 tools
	$phpbb_root_path = '/srv/www/www.reactos.org/forum/';
	$phpEx = 'php';
	define('IN_PHPBB', 1);
	require_once($phpbb_root_path . 'vendor/patchwork/utf8/src/Patchwork/PHP/Shim/Normalizer.php');
	require_once($phpbb_root_path . 'vendor/patchwork/utf8/src/Normalizer.php');
	require_once($phpbb_root_path . 'vendor/patchwork/utf8/src/Patchwork/Utf8.php');
	require_once($phpbb_root_path . 'vendor/patchwork/utf8/src/Patchwork/Utf8/Bootup.php');
	require_once($phpbb_root_path . 'includes/utf/utf_tools.php');

	// Entry point
	try
	{
		// Set up Connections
		$dbh = new PDO('mysql:host=' . DB_HOST, DB_USER, DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$ds = ldap_connect(ROSLOGIN_LDAP_HOST);
		if (!$ds)
			throw new RuntimeException("Could not connect to LDAP host");

		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (!ldap_bind($ds, ROSLOGIN_LDAP_BIND_DN, ROSLOGIN_LDAP_BIND_PW))
			throw new RuntimeException("Could not bind to the LDAP directory");

		// Empty RosLogin DB and LDAP
		$dbh->query('DELETE FROM roslogin.forbidden_usernames');

		$sr = ldap_list($ds, ROSLOGIN_LDAP_BASE_DN, 'objectClass=*', ['']);
		$info = ldap_get_entries($ds, $sr);
		for ($i = 0; $i < $info['count']; $i++)
		{
			if (!ldap_delete($ds, $info[$i]['dn']))
				throw new RuntimeException("Could not empty LDAP directory");
		}

		// Count Users
		$stmt = $dbh->query('SELECT COUNT(*) FROM drupal.users');
		$total_count = (int)$stmt->fetchColumn();
		$migrated_count = 0;
		$violation_count = 0;
		printf("Total Users in the Drupal database: %u\n\n", $total_count);

		// Queries
		$one_month_ago = time() - 60 * 60 * 24 * 30;

		$drupal_activity_stmt = $dbh->prepare('SELECT (SELECT COUNT(*) FROM drupal.history WHERE uid = :uid) + (SELECT COUNT(*) FROM drupal.node_revision WHERE uid = :uid) + (SELECT COUNT(*) FROM drupal.users_roles WHERE uid = :uid)');
		$drupal_delete_stmt = $dbh->prepare('DELETE FROM drupal.users WHERE uid = :uid');

		$phpbb_uid_stmt = $dbh->prepare('SELECT user_id FROM forum.phpbb_users WHERE username_clean = :phpbb_name');
		$phpbb_activity_stmt = $dbh->prepare('SELECT (SELECT COUNT(*) FROM forum.phpbb_posts WHERE poster_id = :phpbb_uid) + (SELECT COUNT(*) FROM forum.phpbb_privmsgs WHERE author_id = :phpbb_uid)');
		$phpbb_delete_stmt = $dbh->prepare('DELETE FROM forum.phpbb_users WHERE user_id = :phpbb_uid');

		$wiki_activity_stmt = $dbh->prepare('SELECT COUNT(*) FROM wiki.revision WHERE LOWER(rev_user_text) = :wiki_name');
		$wiki_delete_stmt = $dbh->prepare('DELETE FROM wiki.user WHERE LOWER(user_name) = :wiki_name');

		$jira_activity_stmt = $dbh->prepare('SELECT (SELECT COUNT(*) FROM jira.jiraaction WHERE AUTHOR = :jira_name) + (SELECT COUNT(*) FROM jira.jiraissue WHERE REPORTER = :jira_name) + (SELECT COUNT(*) FROM jira.jiraissue WHERE ASSIGNEE = :jira_name) + (SELECT COUNT(*) FROM jira.jiraissue WHERE CREATOR = :jira_name)');
		$jira_delete_stmt = $dbh->prepare('DELETE FROM jira.cwd_user WHERE lower_user_name = :jira_name');

		$forbidden_stmt = $dbh->prepare('INSERT INTO roslogin.forbidden_usernames (username) VALUES (:username)');

		$stmt = $dbh->query('SELECT uid, name, mail, created, password_ldap FROM drupal.users');
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			printf('%u: %s ... ', $row['uid'], $row['name']);
			$active_user = false;

			for (;;)
			{
				// Do we have a user name?
				if (trim($row['name'] == ''))
				{
					echo "Not adding (empty user name)";
					break;
				}

				// Is this user less than a month old?
				if ((int)$row['created'] > $one_month_ago)
				{
					echo "Adding (created less than a month ago)";
					$active_user = true;
					break;
				}

				// Did this user ever change a Drupal node?
				$drupal_activity_stmt->bindValue(':uid', $row['uid']);
				$drupal_activity_stmt->execute();
				$drupal_activity_count = (int)$drupal_activity_stmt->fetchColumn();
				if ($drupal_activity_count > 0)
				{
					echo "Adding (Drupal activity)";
					$active_user = true;
					break;
				}

				// Did this user ever post in the forums?
				$phpbb_name = utf8_clean_string($row['name']);
				$phpbb_uid_stmt->bindValue(':phpbb_name', $phpbb_name);
				$phpbb_uid_stmt->execute();
				$phpbb_uid = (int)$phpbb_uid_stmt->fetchColumn();
				if ($phpbb_uid > 0)
				{
					$phpbb_activity_stmt->bindValue(':phpbb_uid', $phpbb_uid);
					$phpbb_activity_stmt->execute();
					$phpbb_activity_count = (int)$phpbb_activity_stmt->fetchColumn();
					if ($phpbb_activity_count > 0)
					{
						echo "Adding (phpBB activity)";
						$active_user = true;
						break;
					}
				}

				// Did this user ever change anything in the Wiki?
				$wiki_name = strtolower(str_replace('_', ' ', $row['name']));
				$wiki_activity_stmt->bindValue(':wiki_name', $wiki_name);

				try
				{
					$wiki_activity_stmt->execute();
					$wiki_activity_count = (int)$wiki_activity_stmt->fetchColumn();
					if ($wiki_activity_count > 0)
					{
						echo "Adding (Wiki activity)";
						$active_user = true;
						break;
					}
				}
				catch (PDOException $e)
				{
					// This fails for users with non-latin characters, because the Wiki database is latin1.
					// Just reset $wiki_name and count this as no Wiki activity.
					unset($wiki_name);
				}

				// Did this user ever participate on JIRA?
				$jira_name = strtolower($row['name']);
				$jira_activity_stmt->bindValue(':jira_name', $jira_name);
				$jira_activity_stmt->execute();
				$jira_activity_count = (int)$jira_activity_stmt->fetchColumn();
				if ($jira_activity_count > 0)
				{
					echo "Adding (JIRA activity)";
					$active_user = true;
					break;
				}

				// No activity determined.
				echo "Not adding (no activity)";
				break;
			}

			if ($active_user)
			{
				// Add it to the forbidden_usernames DB table.
				$username_normalized = strtolower(preg_replace('#([\. _-])#', '', $row['name']));
				$forbidden_stmt->bindValue(':username', $username_normalized);

				try
				{
					$forbidden_stmt->execute();
				}
				catch (PDOException $e)
				{
					// This normalized username already exists in forbidden_usernames or uses invalid characters.
					// We allow this for the migration, but not for new users. Count these violations.
					echo " - could not add to forbidden_usernames";
					$violation_count++;
				}

				// Add it to the LDAP directory.
				$username_escaped = ldap_escape($row['name'], null, LDAP_ESCAPE_DN);
				$dn = "cn={$username_escaped}," . ROSLOGIN_LDAP_BASE_DN;
				$info = [
					'objectClass' => 'inetOrgPerson',
					'cn' => $row['name'],
					'sn' => $row['name'],
					'displayName' => $row['name'],
					'mail' => $row['mail'],
					'userPassword' => $row['password_ldap'],
				];
				if (!ldap_add($ds, $dn, $info))
					throw new RuntimeException("Could not add to the LDAP directory");

				$migrated_count++;
			}
			else
			{
				// Delete this inactive user from all user tables.
				$drupal_delete_stmt->bindValue(':uid', $row['uid']);
				$drupal_delete_stmt->execute();

				if (isset($phpbb_uid) && $phpbb_uid > 0)
				{
					$phpbb_delete_stmt->bindValue(':phpbb_uid', $phpbb_uid);
					$phpbb_delete_stmt->execute();
				}

				if (isset($wiki_name))
				{
					$wiki_delete_stmt->bindValue(':wiki_name', $wiki_name);
					$wiki_delete_stmt->execute();
				}

				if (isset($jira_name))
				{
					$jira_delete_stmt->bindValue(':jira_name', $jira_name);
					$jira_delete_stmt->execute();
				}
			}

			echo "\n";
		}

		printf("\nMigrated %u Users\n", $migrated_count);
		printf("Constraint Violations in forbidden_usernames: %u\n", $violation_count);
	}
	catch (Exception $e)
	{
		die($e->getFile() . ':' . $e->getLine() . ' - ' . $e->getMessage());
	}
