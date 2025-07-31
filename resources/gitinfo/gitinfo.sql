-- SQL Dump for the "gitinfo" database

CREATE TABLE `master_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rev_hash` char(40) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_email` varchar(100) NOT NULL,
  `commit_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rev_hash` (`rev_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `master_revisions_todo` (
  `oldrev` char(40) NOT NULL,
  `newrev` char(40) NOT NULL,
  UNIQUE KEY `rev_pair` (`oldrev`, `newrev`),
  ADD CONSTRAINT `fk_oldrev` FOREIGN KEY (`oldrev`) REFERENCES `master_revisions`(`rev_hash`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_newrev` FOREIGN KEY (`newrev`) REFERENCES `master_revisions`(`rev_hash`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
