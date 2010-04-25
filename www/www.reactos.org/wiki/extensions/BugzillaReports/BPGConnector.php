<?php
/**
 * PostgreSQL connector
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
class BPGConnector {
	protected $context;
	protected $error;

	function BPGConnector( $context ) {
		$this->setContext($context);
	}
	
	public function setContext($context) {
		$this->context=$context;
	}

	public function getContext() {
		return $this->context;
	}

	public function connect() {
		$db=pg_connect(
			"dbname=".$this->context->database.
			" host=".$this->context->host.
			" user=".$this->context->dbuser.
			" password=".$this->context->password);
			
		# $this->context->host, $this->context->dbuser, $this->context->password);		
			
		if (!$db) {
			$this->setError($this->context
				->getErrorMessage('bReport_noconnection',
					$this->context->dbuser,
					$this->context->host,pg_last_error()));	
			return FALSE;
		} 		
		
		if (!pg_dbname($db)) {
			$this->close($db);
			$this->setError($this->context->getErrorMessage('bReport_nodb'));
			return FASLE;
		}
			
		return $db;
	}
	
	public function execute($sql,$db) {
		return pg_query($db,$sql);		
	}
	
	public function getRowCount($result) {
		return pg_num_rows($result);
	}
	
	public function fetch($result) {
		return pg_fetch_array($result);
	}
	public function free($result) {
		pg_free_result($result);
	}
	
	public function close($db) {
		pg_close($db);		
	}

	public function getTable($table) {
		return $table;
	}
	
	public function setError($message) {
		$this->message=$message;
	}

	public function getError() {
		return $this->message;
	}

	public function getDbError($db) {
		return pg_last_error($db);
	}
}