<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     ReactOS GitInfo Component for fetching information about the Git master branch
 * COPYRIGHT:   Copyright 2017 Colin Finck (colin@reactos.org)
 */

	require_once(ROOT_PATH . "../www.reactos.org_config/gitinfo-connect.php");

	class GitInfoLimitException extends Exception
	{
	}

	class GitInfo
	{
		// Member Constants
		private $_LATEST_LIMIT = 100;
		private $_REV_RANGE_LIMIT = 3000;
		private $_SHORT_HASH_LENGTH = 7;

		// Member Variables
		private $_dbh;

		// Private Functions
		private function _getRevisionWithIDOffset($rev_hash, $offset, $output_short)
		{
			$stmt = $this->_dbh->prepare("SELECT id FROM master_revisions WHERE rev_hash = :rev_hash");
			$stmt->bindParam(":rev_hash", $rev_hash);
			$stmt->execute();
			$id = $stmt->fetchColumn();

			if ($id === FALSE)
				return FALSE;

			$id = (int)$id + $offset;
			$stmt = $this->_dbh->query("SELECT rev_hash FROM master_revisions WHERE id = $id");
			$output = $stmt->fetchColumn();

			if ($output_short && $output)
				return $this->getShortHash($output);
			else
				return $output;
		}

		// Public Functions
		public function __construct()
		{
			// Connect to the database.
			$this->_dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_GITINFO, DB_USER, DB_PASS);
			$this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		public function getLatestRevision()
		{
			$stmt = $this->_dbh->query("SELECT rev_hash FROM master_revisions ORDER BY id DESC LIMIT 1");
			return $stmt->fetchColumn();
		}

		public function getLatestRevisions($count)
		{
			$c = (int)$count;
			if ($c < 0 || $c > $this->_LATEST_LIMIT)
				throw new GitInfoLimitException();

			$stmt = $this->_dbh->query("SELECT rev_hash FROM master_revisions ORDER BY id DESC LIMIT $c");
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		public function getLongHash($short_hash)
		{
			$stmt = $this->_dbh->prepare("SELECT rev_hash FROM master_revisions WHERE rev_hash LIKE :short_hash LIMIT 1");
			$stmt->bindValue(":short_hash", $short_hash . '%');
			$stmt->execute();
			return $stmt->fetchColumn();
		}

		public function getNextRevision($rev_hash, $output_short = FALSE)
		{
			return $this->_getRevisionWithIDOffset($rev_hash, +1, $output_short);
		}

		public function getPreviousRevision($rev_hash, $output_short = FALSE)
		{
			return $this->_getRevisionWithIDOffset($rev_hash, -1, $output_short);
		}

		public function getRevisionInformation($rev_hash)
		{
			$stmt = $this->_dbh->prepare("SELECT author_name, author_email, UNIX_TIMESTAMP(commit_timestamp) AS commit_timestamp, UNCOMPRESS(message) AS message FROM master_revisions WHERE rev_hash = :rev_hash");
			$stmt->bindParam(":rev_hash", $rev_hash);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function getRevisionRange($start_hash, $end_hash)
		{
			$stmt = $this->_dbh->prepare("SELECT rev_hash FROM master_revisions WHERE id >= (SELECT id FROM master_revisions WHERE rev_hash = :start_hash) AND id <= (SELECT id FROM master_revisions WHERE rev_hash = :end_hash) LIMIT " . $this->_REV_RANGE_LIMIT);
			$stmt->bindParam(":start_hash", $start_hash);
			$stmt->bindParam(":end_hash", $end_hash);
			$stmt->execute();
			$range = $stmt->fetchAll(PDO::FETCH_COLUMN);

			if (count($range) == $this->_REV_RANGE_LIMIT && $range[$this->_REV_RANGE_LIMIT - 1] != strtolower($end_hash))
				throw new GitInfoLimitException();

			return $range;
		}

		public function getShortHash($rev_hash)
		{
			return substr($rev_hash, 0, $this->_SHORT_HASH_LENGTH);
		}
	}
