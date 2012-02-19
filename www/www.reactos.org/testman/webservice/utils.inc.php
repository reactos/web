<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Miscellaneous utility functions for the Web Service
  COPYRIGHT:  Copyright 2009-2011 Colin Finck <colin@reactos.org>
*/
	
	// What one of these classes has to look like
	interface Test
	{
		public function getTestId($source_id, $revision, $platform, $comment);
		public function getSuiteId($module, $test);
		public function submit($source_id, $test_id, $suite_id, $log);
		public function finish($source_id, $test_id, $performance);
	}
	
	function VerifyLogin($source_id, $password)
	{
		global $dbh;
		
		// Check the login credentials
		$stmt = $dbh->prepare("SELECT COUNT(*) FROM sources WHERE id = :sourceid AND password = MD5(:password)");
		$stmt->bindParam(":sourceid", $source_id);
		$stmt->bindParam(":password", $password);
		$stmt->execute() or die("SQL failed #1");
		
		if(!$stmt->fetchColumn())
			die("Invalid Login credentials!");
	}
?>
