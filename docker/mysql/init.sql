-- ReactOS Web Services - Docker database initialization

-- -------------------------------------------------------
-- Databases
-- -------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `roslogin` CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE DATABASE IF NOT EXISTS `testman`  CHARACTER SET latin1 COLLATE latin1_general_ci;
CREATE DATABASE IF NOT EXISTS `gitinfo`  CHARACTER SET utf8 COLLATE utf8_general_ci;

-- -------------------------------------------------------
-- Users
-- -------------------------------------------------------
CREATE USER IF NOT EXISTS 'roslogin'@'%'       IDENTIFIED WITH mysql_native_password BY '';
CREATE USER IF NOT EXISTS 'testman'@'%'        IDENTIFIED WITH mysql_native_password BY '';
CREATE USER IF NOT EXISTS 'gitinfo_reader'@'%' IDENTIFIED WITH mysql_native_password BY '';

GRANT SELECT, INSERT, UPDATE, DELETE ON `roslogin`.* TO 'roslogin'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON `testman`.*  TO 'testman'@'%';
GRANT SELECT                          ON `gitinfo`.*  TO 'gitinfo_reader'@'%';

FLUSH PRIVILEGES;

-- -------------------------------------------------------
-- roslogin schema
-- -------------------------------------------------------
USE `roslogin`;

CREATE TABLE `forbidden_maildomains` (
  `domain` varchar(254) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `forbidden_usernames` (
  `username` varchar(60) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `pending` (
  `username` varchar(60) NOT NULL,
  `email` varchar(254) NOT NULL,
  `verification_key` char(32) NOT NULL,
  `timeout` datetime NOT NULL,
  `type` enum('mailchange','registration','resetpassword') NOT NULL,
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sessions` (
  `id` char(32) CHARACTER SET utf8 NOT NULL,
  `username` varchar(60) CHARACTER SET utf8 NOT NULL,
  `timeout` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------
-- testman schema
-- -------------------------------------------------------
USE `testman`;

CREATE TABLE `sources` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) collate latin1_general_ci NOT NULL,
  `password` char(32) collate latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_logs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `log` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(10) unsigned NOT NULL,
  `suite_id` int(10) unsigned NOT NULL,
  `status` enum('ok','crash','canceled') COLLATE latin1_general_ci NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  `failures` int(10) unsigned NOT NULL DEFAULT '0',
  `skipped` int(10) unsigned NOT NULL DEFAULT '0',
  `todo` int(10) unsigned NOT NULL DEFAULT '0',
  `time` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_and_suite` (`test_id`,`suite_id`),
  KEY `suite_id` (`suite_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_runs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `source_id` int(10) unsigned NOT NULL,
  `revision` varchar(40) NOT NULL,
  `platform` varchar(24) COLLATE latin1_general_ci NOT NULL,
  `comment` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `failures` int(10) unsigned NOT NULL DEFAULT '0',
  `boot_cycles` bigint(20) unsigned NOT NULL DEFAULT '0',
  `context_switches` int(10) unsigned NOT NULL DEFAULT '0',
  `interrupts` int(10) unsigned NOT NULL DEFAULT '0',
  `reboots` int(10) unsigned NOT NULL DEFAULT '0',
  `system_calls` int(10) unsigned NOT NULL DEFAULT '0',
  `time` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `revision` (`revision`),
  KEY `platform` (`platform`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_suites` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `module` varchar(50) collate latin1_general_ci NOT NULL,
  `test` varchar(50) collate latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- -------------------------------------------------------
-- gitinfo schema
-- -------------------------------------------------------
USE `gitinfo`;

CREATE TABLE `master_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rev_hash` char(40) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_email` varchar(100) NOT NULL,
  `commit_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rev_hash` (`rev_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `master_revisions_todo` (
  `oldrev` char(40) NOT NULL,
  `newrev` char(40) NOT NULL,
  UNIQUE KEY `oldrev` (`oldrev`),
  UNIQUE KEY `newrev` (`newrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
