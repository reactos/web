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
		$dbh = new PDO('mysql:host=' . DB_HOST, DB_USER, DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $dbh->query('SELECT COUNT(*) FROM drupal.users');
		$total_count = (int)$stmt->fetchColumn();
		printf("Total Users in the Drupal database: %u\n\n", $total_count);

		$one_month_ago = time() - 60 * 60 * 24 * 30;
		$drupal_activity_stmt = $dbh->prepare('SELECT (SELECT COUNT(*) FROM drupal.history WHERE uid = :uid) + (SELECT COUNT(*) FROM drupal.node_revision WHERE uid = :uid)');
		$phpbb_uid_stmt = $dbh->prepare('SELECT user_id FROM forum.phpbb_users WHERE username_clean = :phpbb_name');
		$phpbb_activity_stmt = $dbh->prepare('SELECT (SELECT COUNT(*) FROM forum.phpbb_posts WHERE poster_id = :phpbb_uid) + (SELECT COUNT(*) FROM forum.phpbb_privmsgs WHERE author_id = :phpbb_uid)');
		$wiki_activity_stmt = $dbh->prepare('SELECT COUNT(*) FROM wiki.revision WHERE LOWER(rev_user_text) = :wiki_name');
		$jira_activity_stmt = $dbh->prepare('SELECT COUNT(*) FROM jira.jiraaction WHERE AUTHOR = :jira_name');

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
					echo "Not adding (empty user name)\n";
					break;
				}

				// Is this user less than a month old?
				if ((int)$row['created'] > $one_month_ago)
				{
					echo "Adding (created less than a month ago)\n";
					$active_user = true;
					break;
				}

				// Did this user ever change a Drupal node?
				$drupal_activity_stmt->bindValue(':uid', $row['uid']);
				$drupal_activity_stmt->execute();
				$drupal_activity_count = (int)$drupal_activity_stmt->fetchColumn();
				if ($drupal_activity_count > 0)
				{
					echo "Adding (Drupal activity)\n";
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
					$phpbb_activity_count = (int)$stmt->fetchColumn();
					if ($phpbb_activity_count > 0)
					{
						echo "Adding (phpBB activity)\n";
						$active_user = true;
						break;
					}
				}

				// Did this user ever change anything in the Wiki?
				$wiki_name = strtolower(str_replace('_', ' ', $row['name']));
				$wiki_activity_stmt->bindValue(':wiki_name', $wiki_name);
				$wiki_activity_stmt->execute();
				$wiki_activity_count = (int)$wiki_activity_stmt->fetchColumn();
				if ($wiki_activity_count > 0)
				{
					echo "Adding (Wiki activity)\n";
					$active_user = true;
					break;
				}

				// Did this user ever participate on JIRA?
				$jira_name = strtolower($row['name']);
				$jira_activity_stmt->bindValue(':jira_name', $jira_name);
				$jira_activity_stmt->execute();
				$jira_activity_count = (int)$jira_activity_stmt->fetchColumn();
				if ($jira_activity_count > 0)
				{
					echo "Adding (JIRA activity)\n";
					$active_user = true;
					break;
				}

				// No activity determined.
				echo "Not adding (no activity)\n";
				break;
			}

			if ($active_user)
			{
				// TODO: Add to LDAP directory and forbidden_usernames table.
				// TODO: Count migrated users.
				// TODO: Remove an inactive user from Drupal, MediaWiki, phpBB, JIRA databases as well.
			}
		}
	}
	catch (Exception $e)
	{
		die($e->getFile() . ':' . $e->getLine() . ' - ' . $e->getMessage());
	}
