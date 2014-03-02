-- SQL Dump for the "testman" database

CREATE TABLE `sources` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(100) collate latin1_general_ci NOT NULL,
  `password` char(32) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_logs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `log` mediumblob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(10) unsigned NOT NULL,
  `suite_id` int(10) unsigned NOT NULL,
  `status` enum('ok','crash','canceled') COLLATE latin1_general_ci NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0' COMMENT 'Number of all executed tests',
  `failures` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of failed tests',
  `skipped` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of skipped tests',
  `todo` int(10) unsigned NOT NULL DEFAULT '0',
  `time` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_and_suite` (`test_id`,`suite_id`),
  KEY `suite_id` (`suite_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_runs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `source_id` bigint(20) unsigned NOT NULL,
  `revision` int(9) unsigned NOT NULL,
  `platform` varchar(24) COLLATE latin1_general_ci NOT NULL,
  `comment` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sum of all executed tests',
  `failures` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sum of all test failures',
  `boot_cycles` bigint(20) unsigned NOT NULL DEFAULT '0',
  `context_switches` int(10) unsigned NOT NULL DEFAULT '0',
  `interrupts` int(10) unsigned NOT NULL DEFAULT '0',
  `reboots` int(10) unsigned NOT NULL DEFAULT '0',
  `system_calls` int(10) unsigned NOT NULL DEFAULT '0',
  `time` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `winetest_suites` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `module` varchar(50) collate latin1_general_ci NOT NULL,
  `test` varchar(50) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
