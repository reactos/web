-- SQL Dump for the "gitinfo" database

CREATE TABLE `master_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rev_hash` char(40) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_email` varchar(100) NOT NULL,
  `commit_timestamp` timestamp NOT NULL,
  `message` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rev_hash` (`rev_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- MySQL always creates timestamp columns with a default value and "on update CURRENT_TIMESTAMP".
-- This is the dirty hack to remove them again (from https://stackoverflow.com/a/31865524).
-- Even exporting the table structure through mysqldump and importing it again results in these unwanted extras...
ALTER TABLE `master_revisions` CHANGE COLUMN `commit_timestamp` `commit_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `master_revisions` ALTER COLUMN `commit_timestamp` DROP DEFAULT;


CREATE TABLE `master_revisions_todo` (
  `oldrev` char(40) NOT NULL,
  `newrev` char(40) NOT NULL,
  UNIQUE KEY `oldrev` (`oldrev`),
  UNIQUE KEY `newrev` (`newrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
