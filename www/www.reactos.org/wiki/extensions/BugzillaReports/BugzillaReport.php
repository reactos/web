<?php
/**
 * The bugzilla report objects
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

# 
# flag to record whether the head has been included already so that 
# we only include it once
#
$bzHeadIncluded=false;  

class BugzillaReport extends BMWExtension {

	# The handle on the query object
	var $query;

	# Default max rows for a report 			
	var $maxrowsFromConfig;
	var $maxrowsFromConfigDefault=100;
	
	var $dbdriverDefault="mysql";

	# Default max rows which are used for aggregation of a bar chart report
	var $maxrowsForBarChartFromConfig;
	var $maxrowsForBarChartFromConfigDefault=500;

	# Output raw HTML (i.e. not Wiki output)
	var $rawHTML;

	public $dbuser,$bzserver,$interwiki;
	public $database,$host,$password;
	public $dbdriver;
	public $dbencoding;
	public $instanceNameSpace;
	
	function BugzillaReport( &$parser ) {
		$this->parser =& $parser;	
	}
	
	public function render($args) {		
		global $wgBugzillaReports;
		global $bzScriptPath;
		global $wgDBserver,$wgDBname,$wgDBuser,$wgDBpassword;
		global $bzHeadIncluded;

		# Initialise query
		$this->dbdriver=$this->getProperty("dbdriver",$this->dbdriverDefault);
		$connector;
		switch ($this->dbdriver) {
			case "pg" :
				$connector=new BPGConnector($this);				
				break;
			default :
				$connector=new BMysqlConnector($this);
		}
		
		$this->query=new BugzillaQuery($connector);
		#
		# Process arguments from default setting across all the wiki
		#
		$this->extractOptions(explode("|",$this->getProperty("default")));
		#
		# Process arguments for this particular query
		#
		$this->extractOptions($args);

		if (!$bzHeadIncluded) {
			$bzHeadIncluded=true;
			$this->parser->mOutput->addHeadItem('<link rel="stylesheet" type="text/css" media="screen, projection" href="' . $bzScriptPath . '/skins/bz_main.css" />');
			$this->parser->mOutput->addHeadItem('<script type="text/javascript" src="' . $bzScriptPath . '/scripts/jquery-1.2.6.min.js" ></script>');
			$script=<<< EOH
<script type= "text/javascript">		
$(document).ready(function(){
	$("div.bz_comment").hide();
	$("tr.bz_bug").hover( 
		function () { 
			$(this).find("td div.bz_comment").show();
		},
		function () { 
			$(this).find("td div.bz_comment").hide();
		}
	)	
});
</script>
EOH;
			$this->parser->mOutput->addHeadItem($script);
		}
		if ($this->query->get("instance") != null) {
			$this->instanceNameSpace=$this->query->get("instance");
		}
		
		$this->dbuser=$this->getProperty("user",$wgDBuser);
		$this->bzserver=$this->getProperty("bzserver", null);
		$this->interwiki=$this->getProperty("interwiki", null);
		$this->dbencoding=$this->getProperty("dbencoding", "utf8");
		$this->database=$this->getProperty("database");
		$this->host=$this->getProperty("host");
		$this->password=$this->getProperty("password");
		$this->maxrowsFromConfig=
			$this->getProperty("maxrows",$this->maxrowsFromConfigDefault);
		$this->maxrowsForBarChartFromConfig=
			$this->getProperty("maxrowsbar",
				$this->maxrowsForBarChartFromConfigDefault);		
		if ($this->query->get("disablecache") != null) {
			#
			# Extension parameter take priority on disable cache configuration
			#
			if ($this->query->get("disablecache") == "1") {
				$this->disableCache();	
			}
		} elseif ($this->getProperty("disablecache")=="1") {
			#
			# ... then it's the LocalSettings property
			#
			$this->disableCache();
			
		}
		
		$this->debug && $this->debug("Rendering BugzillaReport");
		return $this->query->render().$this->getWarnings();
	}
	
	protected function disableCache() {
		$this->debug && $this->debug("Disabling parser cache for this page");
		$this->parser->disableCache();
	}

	#
	# Set value - implementation of the abstract function from BMWExtension
	#
	protected function set($name,$value) {
		# debug variable is store on this object
		if ($name=="debug") {
			$this->$name=$value;
		} else {
			$this->query->set($name,$value);
		}
	}
	
	protected function getParameterRegex($name) {
		if ($name=="debug") {
			return "/^[12]$/";
		} else {
			return $this->query->getParameterRegex($name);
		}		
	}

	function getProperty($name,$default="") {
		global $wgBugzillaReports;
		$value;
		if ($this->instanceNameSpace != null &&
			array_key_exists($this->instanceNameSpace.":".$name,$wgBugzillaReports)) {
			$value=$wgBugzillaReports[$this->instanceNameSpace.":".$name];	
		} elseif (array_key_exists($name,$wgBugzillaReports)) {
			$value=$wgBugzillaReports[$name];
		} else {
			$value=$default;
		}
		$this->debug &&
			$this->debug("Env property $name=$value");
		return $value;
	}

    public function getErrorMessage($key) {
		$args = func_get_args();
		array_shift( $args );	
		wfLoadExtensionMessages( 'BugzillaReports' );
		return '<strong class="error">BugzillaReports : '. 
			wfMsgForContent($key,$args).'</strong>';	
	}
	
	public function setRawHTML($bool) {
		$this->rawHTML=$bool;
	}
}
?>