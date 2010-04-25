<?php
/*
Mysql connector
*/

/**
 * Copyright (C) 2008 - Ian Homer & bemoko
 *
 * This program is free software; you can redistribute it and/or modify it 
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) 
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for    
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along 
 * with this program; if not, see <http://www.gnu.org/licenses>.
 */
class BMysqlConnector {
	protected $context;
	protected $error;

	function BMysqlConnector( $context ) {
		$this->setContext($context);
	}
	
	public function setContext($context) {
		$this->context=$context;
	}

	public function getContext() {
		return $this->context;
	}

	public function connect() {
		$db=mysql_connect($this->context->host, 
			$this->context->dbuser, $this->context->password);
			
		/*
		 * Set character encoding
		 */	
		
		mysql_query("SET NAMES '".$this->context->dbencoding."';", $db);
		mysql_query("SET CHARACTER SET '".$this->context->dbencoding."';", $db);
					
		if (!$db) {
			$this->setError($this->context
				->getErrorMessage('bReport_noconnection',
					$this->context->dbuser,
					$this->context->host,mysql_error()));	
			return FALSE;
		} 		
		
		/*
		 * Test the connection early - note that we can't switch to the db
		 * with mysql_select_db since if this is a shared database connection
		 * with mediawiki then we will have changed the db for the mediawiki
		 * access.
		 */
		$sql="select count(id) from `".$this->context->database."`".
			".priority;";
		$result=mysql_query($sql,$db);
		if (!$result) {
			$this->setError($this->context->getErrorMessage('bReport_nodb',
				"Can't find test table 'priority' in database ".
				"`".$this->context->database."` using ".$sql.
				" - this probably means your username and password set in the variable wgBugzillaReports are not correct."));
			$db=null;			
		} else if (mysql_error($db)) {
			$this->setError($this->context->getErrorMessage('bReport_nodb'),
				mysql_error($db));
			$db=null;
		} else if ($this->getRowCount($result) != 1) {
			$this->setError($this->context->getErrorMessage('bReport_nodb',
				"`".$this->context->database."`-".$this->getRowCount($result)));
			$db=null;
		}
		$this->free($result);
			
		return $db;
	}
	
	public function execute($sql,$db) {
		return mysql_query($sql, $db);		
	}
	
	public function getRowCount($result) {
		return mysql_num_rows($result);
	}
	
	public function fetch($result) {
		return mysql_fetch_array($result, MYSQL_ASSOC);
	}
	public function free($result) {
		mysql_free_result($result);
	}
	
	public function close($db) {		
		/* 
		 * In PHP you should rely on script termination to close mysql
		 * and not explicitly call mysql_close($db) - see
		 * http://uk.php.net/manual/en/function.mysql-close.php
		 * This is because the implementation may reuse connections.  This 
		 * does happen if the connection details for the Bugzila database are
		 * the same as the wiki database.  Setting to null is good practice
		 * to free up the resource early.
		 */
		$db=null;
	}

	public function getTable($table) {
		return "`".$this->context->database."`.".$table;
	}
	
	public function setError($message) {
		$this->message=$message;
	}

	public function getError() {
		return $this->message;
	}
	
	public function getDbError($db) {
		return mysql_error($db);
	}

}