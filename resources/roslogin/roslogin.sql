-- SQL Dump of the "roslogin" database

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
