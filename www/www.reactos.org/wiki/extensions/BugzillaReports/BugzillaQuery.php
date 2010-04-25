<?php
/**
 * A bugzilla query 
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
class BugzillaQuery extends BSQLQuery {
  var $supportedParameters=array (
    'alias'         => 'field-id',
    'assigned'      => 'field-date',
    'attachments'   => 'field-number',
    'bar'           => 'column',
    'bzurl'         => 'value',     # Show the url to the BZ query
    'blocks'        => 'field-depends',
    'cc'            => 'field',
    'closed'        => 'field-date',
    'columns'       => 'columns',   
    'created'       => 'field-date',
    'createdformat' => 'value',   # date or relativedate      
    'component'     => 'field',
    'customfields'  => 'value',     # Comma separated list of custom fields
    'customprefix'  => 'cf_',     # Prefix that all custom fields should start with
    'deadline'      => 'field-date',
    'depends'       => 'field-depends',
    'dependsstatus' => 'field-join',  # Status values to include in depends (and blocks) tasks
    'detailsrow'    => 'columns',
    'detailsrowprepend' => 'free',
    'disablecache'    => 'boolean',
    'estimated'     => 'field-number',
    'filters'       => 'filters',   # Generic filter setting which can be used for custom fields
    'flag'          => 'field-special',
    'format'        => 'value',     # table (default), list, inline or count
    'from'          => 'field',
    'group'         => 'sort',
    'groupformat'   => 'value',
    'grouporder'    => 'value',     # asc or desc
    'hardware'      => 'field',
    'heading'       => 'free',
    'headers'       => 'value',
    'hide'          => 'value',
    'id'            => 'field-id',
    'implicitcustom'  => 'boolean',   # true => allow custom fields not explicitly defined and not
                        # starting with the custom field prefix
    'instance'      => 'value',     # Alternative bugzilla instance as defined in 
                        # LocalSettings configuration
    'keywords'      => 'field-keywords',
    'link'          => 'columns',   # Define rules for linking headings and values 
                        # through to wiki pages
    'lastcomment'   => 'boolean',
    'maxrows'       => 'value',
    'maxrowsbar'    => 'value',
    'milestone'     => 'field',
    'modified'      => 'field-date',
    'modifiedformat'  => 'value',   # date or relativedate      
    'nameformat'    => 'value',     # real (default),tla or login
    'order'         => 'value',
    'os'            => 'field',
    'priority'      => 'field',
    'product'       => 'field',
    'qa'            => 'field',
    'quickflag'     => 'value',
    'noresultsmessage'  => 'free',
    'remaining'     => 'field-number',
    'reopened'      => 'field-date',
    'resolution'    => 'field',
    'resolved'      => 'field-date',
    'search'        => 'field-text',
    'severity'      => 'field',
    'sort'          => 'sort',
    'sortable'      => 'boolean',   # Whether the table is sortable or not
    'status'        => 'field',
    'to'            => 'field',
    'total'         => 'columns',
    'url'           => 'field',
    'version'       => 'field',
    'verified'      => 'field-date',
    'votes'         => 'field-number',
    'work'          => 'field-number',
    'zeroasblank'   => 'boolean'    # Render "0" as blank, if false rendered as "0" (default=true)
  );
  var $defaultParameters=array (
    'bzurl'           => 'show',    
    'columns'         => 'id,priority,status,severity,version,product,summary,url',
    'customprefix'    => 'cf_',
    'dependsstatus'   => '!(CLOSED,VERIFIED,RESOLVED)',
    'format'          => 'table',
    'implicitcustom'  => 'false',     # Default to false since Bugzilla nowadays enforces custom
                        # fields to start with "cf_"
    'noresultsmessage'  => 'no bugzilla tickets were found',
    'order'           => 'asc',
    'status'          => '!CLOSED',
    'sort'            => 'priority,status',
    'sortable'        => '1',
    'zeroasblank'     => 'true'
  );
  public $columnName=array (
    'alias'       => 'Alias',
    'assigned'    => 'Assigned',
    'attachments' => '@',
    'blocks'      => 'Blocks',
    'closed'      => 'Closed',
    'component'   => 'Component',
    'cc'          => 'CC',
    'created'     => 'Created',
    'deadline'    => 'Deadline',
    'depends'     => 'Depends',
    'estimated'   => 'E',
    'flag'        => 'Flagged For',
    'flagdate'    => 'Flag Date',
    'flagfrom'    => 'Flagged By',
    'flagname'    => 'Flag',
    'from'        => 'Requester',
    'hardware'    => 'Hardware',
    'keyworddefs.name'    => 'Keywords',
    'id'          => 'ID',
    'milestone'   => 'Milestone',
    'modified'    => 'Modified',
    'os'          => 'OS',
    'product'     => 'Product',
    'priority'    => 'P',
    'qa'          => 'QA',
    'remaining'   => 'R' ,
    'reopened'    => 'Reopened',
    'resolution'  => 'Resolution',
    'resolved'    => 'Resolved',
    'severity'    => 'Severity',
    'status'      => 'Status',
    'summary'     => 'Summary',
    'to'          => 'Assignee',
    'url'         => '&nbsp;',
    'version'     => 'Version',
    'verified'    => 'Verified',
    'votes'       => 'Votes',
    'work'        => 'W'
    );
  
  public $columnLabelName=array (
    'estimated'   => 'Estimated',
    'priority'    => 'Priority',
    'remaining'   => 'Remaining',
    'work'        => 'Work'
    );
    
  # Fields and their mapping to the value in the results sets
  public $fieldMapping=array (
    'cc'          => 'cc',
    'from'        => 'raisedby',
    'to'          => 'assignedto',
    );
  var $fieldSQLColumn=array (
    'assigned'    => 'assignedactivity.bug_when',
    'attachments' => 'attachments.nattachments',
    'cc'          => 'ccprofiles.login_name',
    'component'   => 'components.name',
    'closed'      => 'closedactivity.bug_when',
    'created'     => 'creation_ts',
    'estimated'   => 'estimated_time',
    'hardware'    => 'rep_platform',
    'id'          => 'bugs.bug_id',
    'from'        => 'reporterprofiles.login_name',
    'keywords'    => 'keyworddefs.name',
    'milestone'   => 'target_milestone',
    'modified'    => 'lastdiffed',
    'product'     => 'products.name',
    'os'          => 'op_sys',
    'qa'          => 'qaprofiles.login_name',
    'remaining'   => 'remaining_time',
    'reopened'    => 'reopenedactivity.bug_when',
    'resolved'    => 'resolvedactivity.bug_when',
    'severity'    => 'bug_severity',
    'status'      => 'bug_status',
    'to'          => 'profiles.login_name',
    'url'         => 'bug_file_loc',
    'verified'    => 'verifiedactivity.bug_when',
    'work'        => 'work_time'
  );
  # Bugzilla Query field names
  var $fieldBZQuery=array (
    'blocks'      => 'blocked',
    'hardware'    => 'rep_platform',
    'id'          => 'bug_id',  
    'milestone'   => 'target_milestone',
    'os'          => 'op_sys',
    'qa'          => 'qa_contact',
    'severity'    => 'bug_severity',
    'status'      => 'bug_status',
    'to'          => 'assigned_to'
  );
  var $fieldDefaultOrder=array (
    'modified'    => 'desc',
    'votes'       => 'desc'
  );
  public $formats=array (
    'alias'     => 'id',
    'assigned'  => 'date',
    'blocks'    => 'id',
    'cc'        => 'name',
    'created'   => 'date',
    'closed'    => 'date',
    'deadline'  => 'date',
    'depends'   => 'id',
    'estimated' => 'number',
    'flagdate'  => 'date',
    'flagfrom'  => 'name',
    'from'      => 'name',
    'id'        => 'id',
    'modified'  => 'relativedate',
    'qa'        => 'name',
    'remaining' => 'number',
    'reopened'  => 'date',
    'resolved'  => 'date',
    'to'        => 'name',
    'url'       => 'url',
    'votes'     => 'number',
    'work'      => 'number'
  );
  var $fieldValues=array (
    'priority'    => 'P1,P2,P3,P4,P5',
    'status'      => 'ASSIGNED,NEW,REOPENED,RESOLVED,VERIFIED,CLOSED',
    'severity'    => 'blocker,critical,major,normal,minor,trivial,enhancement'
  );
  var $sortMapping=array (
    'deadline'    => "COALESCE(deadline, '2100-01-01')",      
    'milestone'   => "COALESCE(NULLIF(milestone,'---'),'XXXXX')", 
    'id'          => "bugs.bug_id"  
  );
  public $dependsRowColumns=array (
    'depends'         => "block",
    'dependsto'       => "title",   # Output in the title
    'dependsstatus'   => "extra",   # Output as greyed
    'dependssummary'  => "block",
  ); 
  public $blocksRowColumns=array (
    'blocks'          => "block",
    'blocksto'        => "title",   # Output in the title
    'blocksstatus'    => "extra",
    'blockssummary'   => "block"
  );
  #
  # Title for a given value rendering
  #
  public $valueTitle=array (
    'alias'       => "id,alias",
    'blocks'      => "blocks,blocksalias",
    'depends'     => "depends,dependsalias",
    'id'          => "id,alias"
  );

  private $supportedCustomFields=array();   # Supported custom fields
  private $requiredCustomFields=array();    # Custom fields that are required for the report  
  private $bzFieldCount=0;          # Field counter for BZ URL
  private $customPrefixLength;        # Cached length of custom prefix length

  public $bzURL="";     # Bugzilla URL to run query
  public $explitlyOneValue; # Set if report is explictly one value

  public static $fieldIds=array();
    
  #
  # Parse in a context object which implements the following
  # 
  # Public Variables
  # - debug, bzserver, interwiki, 
  # - database, host, dbuser, password;
  #
  # Functions
  # - debug
  # - warn, 
  # - getErrorMessage
  # 
  function BugzillaQuery( $connector ) {
    $this->setConnector($connector);
    $this->setContext($connector->getContext());
  }

  #
  # Get rendering formats
  # 
  function getFormats() {
    return $this->formats;
  }

  #
  # Get default priority
  # 
  function getDefaultSort() {
    return $this->defaultSort;
  }

  
  #
  # Render the results
  #
  function render() {   
    $this->bzURL=$this->context->bzserver."/buglist.cgi?";

    #
    # Register supported custom fields
    #
    if ($this->get("customfields")) {
      $this->supportedCustomFields=explode(",",$this->get("customfields"));
    }

    #
    # Calculate the customPrefixLength once so that we reuse below
    #
    $this->customPrefixLength=strlen($this->get('customprefix'));

    #
    # Extract rules on how to link through headings and values to wiki pages
    #
    if ($this->get("link")) {
      foreach (explode(",",$this->get("link")) as $linkedColumn) {
        $parts=explode("~",$linkedColumn);
        $format="link";
        if (sizeof($parts) > 1) {
          $format.="~".$parts[1];
        }
        $this->formats[$parts[0]]=$format;
        $this->implictlyAddColumn($parts[0]);
      }
    }
    
    #
    # If lastcomment mode is selected then we require the keywords field and we
    # will set those to link through to the appropriate wiki page
    #
    if ($this->get("lastcomment")) {
      $this->requireField("keywords");
      if (!array_key_exists("keywords",$this->formats)) {
        $this->formats["keywords"]="link~keyword";
      }
    }
    #
    # Sorting does not work when grouping is enabled so we disable it
    #
    if ($this->get("group")) {
      $this->set("sortable","0");
    }
    
    $db = $this->connector->connect();
    
    $this->initFieldIds($db);
    $sql = $this->getSQL();


    if (!$db)
      return $this->connector->getError();

    $result = $this->connector->execute($sql,$db);

    #
    # Check that the record set is open
    #
    if ($result) {
      if ($this->get('format') == "count") {
        while ($line = $this->connector->fetch($result)) {
          $output=$line["count"];
        }
      } else {
        $this->overrideFormats();
        $renderer=new BugzillaQueryRenderer($this);
            
        if ($this->connector->getRowCount($result) > 0) {
          $this->context->debug &&
            $this->context->debug("Rendering results");
          $output=$renderer->renderHTML($result);
        } else {
          $this->context->debug &&
            $this->context->debug("No results to render");
          #
          # If total is set then we still want to render the result
          # because we want the zero totals to show
          #
          if ($this->get('total')) {
            $output=$renderer->renderHTML($result);            
          } else {
            $output=$renderer->renderNoResultsHTML();
          }
        }
      }
      $this->context->debug &&
        $this->context->debug("Freeing up db result");
      $this->connector->free($result);
    } else {
      return $this->context->getErrorMessage('bReport_sqlerror',
        $sql." ".$this->connector->getDbError($db));
    }
    
    $this->connector->close($db);
  
    if ($this->context->debug) {
      $output.="<div>SQL = ".$sql."</div>";
    }
    $this->context->debug &&
      $this->context->debug(
        "All done and returning page output : Number of characters in output = "
        .strlen($output));
    $this->context->debug==2 && $this->context->debug("Report HTML output is ".$output);
    
    return $output;
  }
    
  /**
   * Build the SQL for the query
   */
  public function getSQL() {      
    
    $this->context->debug && 
      $this->context->debug("Rendering BugzillaQuery");
  
    $where="";

      #
      # Process fields and make sure we have SQL and implicit usage built up
      #     
      foreach (array_keys($this->supportedParameters) as $column) {
        $fieldValue=$this->get($column);
        if ($fieldValue) {
          $this->context->debug &&
            $this->context
              ->debug("Handling field : $column : $fieldValue");
          $type=$this->supportedParameters[$column];

          #
          # Support generic argument syntax
          # 
          if ($type == 'filters') {
            $args=split("%26",$fieldValue);
            foreach ($args as $arg) {
              $this->context
                ->debug("Processing filter : $arg");              
              #
              # Match for encoded =
              #
              if (preg_match("/%3D/",$arg)) {
                $parts=split("%3D",$arg);
                $argColumn=$parts[0];
                $argFieldValue=$parts[1];
                if ($this->isCustomField($argColumn)) {
                  $argType="field";
                  $this->addCustomField($argColumn);
                } else {
                  $argType=$this->supportedParameters[$argColumn];
                }
                if (substr($argType,0,5)!='field') {
                  $this->context
                    ->warn("$argColumn is not of type field so ignoring");
                } else {
                  $where.=$this->processField($argColumn,$argFieldValue,$argType);
                }
              } else {
                $this->context
                  ->warn("arg field not a valid format so ignoring " .
                        ", it should include '%3D', it was ".$arg);
              }
            }
          } else if ($type == 'field-keywords') {
            $where.="and EXISTS (SELECT keywordid,keywords.bug_id from ".
              $this->connector->getTable("keywords")." as keywords ".
              " LEFT JOIN ".
              $this->connector->getTable("keyworddefs")." as keyworddefs ".
              " on keywords.keywordid=keyworddefs.id ".             
              " where keywords.bug_id=bugs.bug_id ".
              $this->processField($column,$fieldValue,"field").
              ")";        
          } else {
            $where.=$this->processField($column,$fieldValue,$type);
          }         
        }
      }

      if ($this->get('format') == "list") {
        $this->requireField("to");
        $this->requireField("deadline");        
      }
      if ($this->get('flag')) {
        $this->requireField("flag");
        $this->implictlyAddColumn("flagfrom");
        $this->implictlyAddColumn("flagname");
        $this->implictlyAddColumn("flagdate");
      }
      if ($this->get('lastcomment')) {
        $this->requireField("lastcomment");       
      }
      if ($this->get('search')) {
        $where.=" and short_desc like '%".$this->get('search')."%'";
      }
      #
      # Set implicit group order
      #     
      if ($this->get('group') && array_key_exists($this->get('group'),
          $this->fieldDefaultOrder)) {
        $this->setImplicit('grouporder',$this->fieldDefaultOrder[
                $this->get('group')]);
      }

    #
    # Quick flag enabled by default
    #
    $this->requireField("quickflag");

    #
    # Alias enabled by default
    #
    $this->requireField("alias");

    #
    # Prepare the query;
    #
    $this->preSQLGenerate();

    $this->context->debug && 
      $this->context->debug("Columns required are "
        .join(",",array_keys($this->fieldsRequired)));
    $sql="";
    if ($this->get('format') == "count") {
      $sql.="SELECT count(distinct(id)) as count from (";
    }     
    $sql.="SELECT DISTINCT bugs.bug_id as id";
    if ($this->isRequired("alias")) {
      $sql.=", alias";
    }
    if ($this->isRequired("assigned")) {
      $sql.=", assignedactivity.bug_when as assigned";
    }    
    if ($this->isRequired("attachments")) {
      $sql.=", attachments.nattachments as attachments ";
    }    
    if ($this->isRequired("blocks")) {
      $sql.=", blockstab.blocks as blocks, blockstab.blocksalias as blocksalias, blockstab.blockssummary as blockssummary,blockstab.blocksstatus as blocksstatus, blockstab.blockspriority as blockspriority, blockstab.realname as blocksto";
    }
    if ($this->isRequired("cc")) {
      if ($this->get('nameformat')=='login') {
        $sql.=", ccprofiles.login_name as cc";
      } else {
        $sql.=", ccprofiles.realname as cc";
      }
    }
    if ($this->isRequired("closed")) {
      $sql.=", closedactivity.bug_when as closed";
    }    
    if ($this->isRequired("component")) {
      $sql.=", components.name as component";
    }
    if ($this->isRequired("created")) {
      $sql.=", creation_ts as created";
    }
    if ($this->isRequired("deadline")) {
      $sql.=", deadline";
    }
    if ($this->isRequired("depends")) {
      $sql.=", dependstab.depends as depends, dependstab.dependsalias as dependsalias, dependstab.dependssummary as dependssummary,dependstab.dependsstatus as dependsstatus, dependstab.dependspriority as dependspriority, dependstab.realname as dependsto";
    }
    if ($this->isRequired("flag")) {
      if ($this->get('nameformat')=='login') {
        $sql.=", flagprofiles.flagfrom_login as flagfrom";
        $sql.=", flagprofiles.flag_login as flag";
      } else {
        $sql.=", flagprofiles.flagfrom_realname as flagfrom";
        $sql.=", flagprofiles.flag_realname as flag";
      }
      $sql.=", flagprofiles.flagname as flagname";
      $sql.=", flagprofiles.flagdate as flagdate";
    } else if ($this->isRequired("quickflag")) {
      $sql.=", quickflag.flagdate as flagdate";     
    }
    if ($this->isRequired("estimated")) {
      $sql.=", estimated_time as estimated";
    }
    if ($this->isRequired("from")) {
      if ($this->get('nameformat')=='login') {
        $sql.=", reporterprofiles.login_name as raisedby";
      } else {
        $sql.=", reporterprofiles.realname as raisedby";        
      }
    }
    if ($this->isRequired("hardware")) {
      $sql.=", rep_platform as hardware";
    }
    if ($this->isRequired("keywords")) {
      $sql.=", keywords";
    }
    if ($this->isRequired("milestone")) {
      $sql.=", target_milestone as milestone";
    }
    if ($this->isRequired("lastcomment")) {
      $sql.=", longdescslastcomment.thetext";
    }
    if ($this->isRequired("modified")) {
      $sql.=", lastdiffed as modified";
    }
    if ($this->isRequired("os")) {
      $sql.=", op_sys as os";
    }
    #
    # Priority always required because it used as class name for bug row
    #
    $sql.=", priority";
    if ($this->isRequired("product")) {
      $sql.=", products.name as product";
    }
    if ($this->isRequired("qa")) {
      if ($this->get('nameformat')=='login') {
        $sql.=", qaprofiles.login_name as qa";
      } else {
        $sql.=", qaprofiles.realname as qa";
      }
    }
    if ($this->isRequired("remaining")) {
      $sql.=", remaining_time as remaining";
    }
    if ($this->isRequired("reopened")) {
      $sql.=", reopenedactivity.bug_when as reopened";
    }
    if ($this->isRequired("resolution")) {
      $sql.=", resolution";
    }
    if ($this->isRequired("resolved")) {
      $sql.=", resolvedactivity.bug_when as resolved";
    }
    #
    # Severity always required because it used as class name for bug row
    #
    $sql.=", bug_severity as severity";
    if ($this->isRequired("status")) {
      $sql.=", bug_status as status";
    }
    if ($this->isRequired("summary")) {
      $sql.=", short_desc as summary";
    }
    if ($this->isRequired("to")) {
      if ($this->get('nameformat')=='login') {      
        $sql.=", profiles.login_name as assignedto";
      } else {
        $sql.=", profiles.realname as assignedto";
      }
    }
    if ($this->isRequired("url")) {
      $sql.=", bug_file_loc as url";
    }
    if ($this->isRequired("version")) {
      $sql.=", version";
    }
    if ($this->isRequired("votes")) {
      $sql.=", votes";
    }
    if ($this->isRequired("work")) {
      $sql.=", SUM(longdescswork.work_time) as work";
    }
    #
    # Now add custom fields
    #
    $this->context->debug && 
      $this->context->debug(sizeof($this->requiredCustomFields)." custom fields");
    
    if (sizeof($this->requiredCustomFields) > 0) {
      foreach($this->requiredCustomFields as $column) {
        $sql.=", $column";
      }
    }
    $sql.=" FROM ".$this->connector->getTable("bugs");
    if ($this->isRequired("assigned")) {
      $sql.=" LEFT JOIN ".
        " (SELECT bug_id, MAX(bug_when) as bug_when from ".
        $this->connector->getTable("bugs_activity").
        " where fieldid=".$this->fieldIds["bug_status"].
        " and added='ASSIGNED' GROUP BY bug_id) as assignedactivity on bugs.bug_id=assignedactivity.bug_id";
    }
    if ($this->isRequired("attachments")) {
      $sql.=" LEFT JOIN (SELECT bug_id as attachmentbugid, COUNT(attach_id) as nattachments from ".
        $this->connector->getTable("attachments").
        " group by attachmentbugid) as ".
        "attachments on attachments.attachmentbugid=bugs.bug_id";                    
    }
    if ($this->isRequired("blocks")) {
      $sql.=" LEFT JOIN (SELECT dependson,blocked as blocks, blockedbugs.alias as blocksalias, blockedbugs.short_desc as blockssummary, blockedbugs.bug_status as blocksstatus, blockedbugs.priority as blockspriority,login_name,realname from ".
        $this->connector->getTable("dependencies")
        ." INNER JOIN ".
        $this->connector->getTable("bugs").
        " as blockedbugs ON dependencies.blocked=blockedbugs.bug_id"
        ." INNER JOIN ".
        $this->connector->getTable("profiles").
        " ON blockedbugs.assigned_to=profiles.userid".
        " where 1=1 ".$this->getWhereClause($this->get('dependsstatus'),"blockedbugs.bug_status").
        " order by blockedbugs.priority) as blockstab ON blockstab.dependson=bugs.bug_id";
    }
    if ($this->isRequired("component")) {
      $sql.=" LEFT JOIN ".
        $this->connector->getTable("components").
        " on bugs.component_id=components.id";
    }
    if ($this->isRequired("cc")) {
      $sql.=" INNER JOIN (SELECT bug_id,login_name,realname from ".
        $this->connector->getTable("cc").
        " INNER JOIN ".
        $this->connector->getTable("profiles").
        " ON cc.who=profiles.userid";
      if ($this->get('cc')) {
        $sql.=$this
          ->getWhereClause($this->get('cc'),"profiles.login_name");
      } 
      $sql.=") as ".
        "ccprofiles on ccprofiles.bug_id=bugs.bug_id";
    }
    if ($this->isRequired("closed")) {
      $sql.=" LEFT JOIN ".
        " (SELECT bug_id, MAX(bug_when) as bug_when from ".
        $this->connector->getTable("bugs_activity").
        " where fieldid=".$this->fieldIds["bug_status"].
        " and added='CLOSED' GROUP BY bug_id) as closedactivity on bugs.bug_id=closedactivity.bug_id";
    }
    if ($this->isRequired("depends")) {
      $sql.=" LEFT JOIN (SELECT blocked,dependson as depends, dependsonbugs.alias as dependsalias, dependsonbugs.short_desc as dependssummary, dependsonbugs.bug_status as dependsstatus, dependsonbugs.priority as dependspriority, login_name, realname from ".
        $this->connector->getTable("dependencies")
        ." INNER JOIN ".
        $this->connector->getTable("bugs").
        " as dependsonbugs ON dependencies.dependson=dependsonbugs.bug_id".
        " INNER JOIN ".
        $this->connector->getTable("profiles").
        " ON dependsonbugs.assigned_to=profiles.userid".
        " where 1=1 ".$this->getWhereClause($this->get('dependsstatus'),"dependsonbugs.bug_status").
        " order by dependsonbugs.priority) as dependstab ON dependstab.blocked=bugs.bug_id";
    }
    if ($this->isRequired("flag")) {
      $sql.=" INNER JOIN (SELECT bug_id,creation_date as flagdate,flagsto.login_name as flag_login,flagsto.realname as flag_realname,flagsfrom.login_name as flagfrom_login, flagsfrom.realname as flagfrom_realname,flagtypes.name as flagname from ".
        $this->connector->getTable("flags").
        " INNER JOIN ".
        $this->connector->getTable("flagtypes").
        " ON flags.type_id=flagtypes.id INNER JOIN ".
        $this->connector->getTable("profiles").
        " as flagsto ON flags.requestee_id=flagsto.userid INNER JOIN ".
        $this->connector->getTable("profiles").
        " as flagsfrom ON flags.setter_id=flagsfrom.userid where status='?'";
      if ($this->get('flag')) {
          $sql.=$this
            ->getWhereClause($this->get('flag'),
              "flagsto.login_name");
        }
      $sql.=") as ".
        "flagprofiles on flagprofiles.bug_id=bugs.bug_id";
    } else if ($this->isRequired("quickflag")) {
      $sql.=" LEFT JOIN (SELECT bug_id as quickflagbugid, MAX(creation_date) as flagdate from ".
        $this->connector->getTable("flags").
        " where status='?' group by quickflagbugid) as ".
        "quickflag on quickflag.quickflagbugid=bugs.bug_id";                    
    }
    if ($this->isRequired("from")) {
      $sql.=" LEFT JOIN ".
        $this->connector->getTable("profiles").
        " as reporterprofiles on bugs.reporter=reporterprofiles.userid";
    }
    if ($this->isRequired("lastcomment")) {
      $sql.=" LEFT JOIN (SELECT MAX(longdescs.bug_when) as sub_comment_when, ".
      "longdescs.bug_id as sub_bug_id FROM ".
      $this->connector->getTable("longdescs").
      " GROUP BY longdescs.bug_id) ".
      "descs ON bugs.bug_id=descs.sub_bug_id LEFT JOIN ".
      $this->connector->getTable("longdescs")." as longdescslastcomment ON ".
      "longdescslastcomment.bug_when=sub_comment_when";
    }
    if ($this->isRequired("product")) {
      $sql.=" LEFT JOIN ".
        $this->connector->getTable("products").
        " on bugs.product_id=products.id";
    }
    if ($this->isRequired("qa")) {
      $sql.=" LEFT JOIN ".
        $this->connector->getTable("profiles").
        " as qaprofiles on bugs.qa_contact=qaprofiles.userid";
    }
    if ($this->isRequired("reopened")) {
      $sql.=" LEFT JOIN ".
        " (SELECT bug_id, MAX(bug_when) as bug_when from ".
        $this->connector->getTable("bugs_activity").
        " where fieldid=".BugzillaQuery::$fieldIds["bug_status"].
        " and added='REOPENED' GROUP BY bug_id) as reopenedactivity on bugs.bug_id=reopenedactivity.bug_id";
    }
    if ($this->isRequired("resolved")) {
      $sql.=" LEFT JOIN ".
        " (SELECT bug_id, MAX(bug_when) as bug_when from ".
        $this->connector->getTable("bugs_activity").
        " where fieldid=".BugzillaQuery::$fieldIds["bug_status"].
        " and added='RESOLVED' GROUP BY bug_id) as resolvedactivity on bugs.bug_id=resolvedactivity.bug_id";
    }
    if ($this->isRequired("to")) {
      $sql.=" LEFT JOIN ".
        $this->connector->getTable("profiles").
        " on bugs.assigned_to=profiles.userid";
    }
    if ($this->isRequired("verified")) {
      $sql.=" LEFT JOIN ".
        " (SELECT bug_id, MAX(bug_when) as bug_when from ".
        $this->connector->getTable("bugs_activity").
        " where fieldid=".BugzillaQuery::$fieldIds["bug_status"].
        " and added='VERIFIED' GROUP BY bug_id) as verifiedactivity on bugs.bug_id=verifiedactivity.bug_id";
    }
    if ($this->isRequired("work")) {
      $sql.=", ".$this->connector->getTable("longdescs")." as longdescswork";
    }
    $sql.=" where 1=1 ".$where;
    if ($this->isRequired("work")) {
      $sql.=" and longdescswork.bug_id=bugs.bug_id GROUP BY bugs.bug_id";
    }
    $sql.=" order by ".
      $this->getMappedSort()." ".$this->getOrder();
    if ($this->get('format') == "count") {
      $sql.=") as b";
    }     
    $sql.=";";
    $this->context->debug && $this->context->debug("SQL : ".$sql);

    return $sql;
  }
  
  # 
  # Process a field
  #
  public function processField($column,$fieldValue,$type) {
    $where="";
    switch ($type) {
      case "field-id" :
        if (!strpos($fieldValue,",")) {
          $this->explitlyOneValue=true;
          $this->context->debug &&
            $this->context
              ->debug("Explicitly one value");
        }
      case "field" :
      case "field-filter" :
      case "field-date" :
      case "field-number" :
        if ($type!="field-id") {
          #
          # If field is multiple values ",", not a value
          # "!", any value "*", a non-null (or 
          # positive value) "+", then add column and 
          # sort, otherwise remove it.
          #
          if (preg_match("/[,!+\*%<>]/",$fieldValue)) {
            $this->implictlyAddColumn($column);
            if (array_key_exists($column,
                $this->fieldDefaultOrder)) {
              $this->setImplicit('sort',"$column");
              $this->setImplicit('order',
              $this->fieldDefaultOrder[$column]);
            }
          } else {
            $this->implictlyRemoveColumn($column);                
          }
        }
      case "field-depends" :
        $sqlColumn=$column;
        if (array_key_exists($column,
            $this->fieldSQLColumn)) {
          $sqlColumn=$this->fieldSQLColumn[$column];
        }
        switch ($type) {
          case "field-id" :
          case "field" :
          case "field-depends" :
            $where=$this->
              getWhereClause($fieldValue,
                $sqlColumn);    
            break;
          case "field-number" :
            $where=$this->
              getIntWhereClause($fieldValue,
                $sqlColumn);  
            break;
          case "field-date" :
            $where=$this->
              getDateWhereClause($fieldValue,
                $sqlColumn);                
        }       
        $this->requireField($column); 
        # Create the bugzilla query URL
        $bzFieldName=$column;
        if (array_key_exists($column,
            $this->fieldBZQuery)) {
          $bzFieldName=$this->fieldBZQuery[$column];
        }
        $this->bzURL.=
          $this->getBZQuery($fieldValue,$bzFieldName);          
        break;              
    }
    return $where;
  }
  
  public function getMatchExpression($match,$name,$negate) {
    $trimmedMatch=trim($match);
    $controlCharacter=substr($trimmedMatch,0,1);
    $localNegate=$negate;
    $range=0;
    $this->context->debug &&
      $this->context
        ->debug("Control character is ".$controlCharacter);
    if (preg_match("/[!><]/",$controlCharacter)) {
      $trimmedMatch=substr($trimmedMatch,1);
      switch ($controlCharacter) {
        case "!":
          $localNegate=!$negate;
          break;
        case ">":
        case "<":
          $range=1;
          break;
      }
    }
    $decodedMatch=$this->safeSQLdecode($trimmedMatch);
    
    if (preg_match("/%/",$match)) {
      # We have a like clause
      if ($localNegate) {       
        return $name." not like '".$decodedMatch."'";
      } else {
        return $name." like '".$decodedMatch."'";
      }     
    } elseif ($range) {
      if ($controlCharacter=="<"){
        if ($localNegate) {       
          return $name." > '".$decodedMatch."'";
        } else {
          return $name." <'".$decodedMatch."'";
        }
      } else {
        if ($localNegate) {       
          return $name." < '".$decodedMatch."'";
        } else {
          return $name." > '".$decodedMatch."'";
        }       
      }     
    } else {
      if ($localNegate) {       
        return $name."<>'".$decodedMatch."'";
      } else {
        return $name."='".$decodedMatch."'";
      }
    }
  }
    
  #
  # Get the BZ Query URL
  #
  private function getBZQuery($value,$name) {
    if (preg_match("/^[\*+-]/",$value)) {
      #
      # *,+ and - (i.e. any value, not null/not zero and null/zero) 
      # not supported in Bugzilla queries
      #
      return "";
    }
    #
    # Replace spaces with "%20" to make it a safe URL
    #
    $safeValue=str_replace(" ","%20",$value);
    $query="";
    $bzFieldGroupCount=0;
    $pos=strpos($safeValue,"!(");
    $operator;
    $negate;
    if ($pos===false) {
      $pos=strpos($safeValue,"!");
      if ($pos===FALSE) {
        $operator="OR";
        $negate=false;        
      } else {
        $operator="AND";
        $negate=true;
        $safeValue=substr($safeValue,1);
      }
    } else {
      $safeValue=substr($safeValue,2,-1);
      $operator="AND";
      $negate=true;
    }
    foreach (explode(",", $safeValue) as $singleValue) {
      $fieldName="0-".$this->bzFieldCount."-".
        $bzFieldGroupCount;
      if ($negate) {
        $query.="&field$fieldName=$name".
          "&type$fieldName=notequals".
          "&value$fieldName=$singleValue";          
      } else {
        $query.="&field$fieldName=$name".
          "&type$fieldName=equals".
          "&value$fieldName=$singleValue";
      }
      #
      # Not operator leads to anding ...
      #
      if ($operator=="AND") {
        $this->bzFieldCount++;
      } else {
      #
      # ... otherwise it's oring ...
      #
        $bzFieldGroupCount++;
      }
    }
    if ($operator=="OR") {
      $this->bzFieldCount++;
    }   
    return $query;
  }
  
  #
  # Override formats
  #
  
  private function overrideFormats() {
    if ($this->get('modifiedformat')) {
      $this->context->debug && 
        $this->context
          ->debug("Setting modified format to ".
            $this->get('modifiedformat'));          
      $this->formats['modified']=$this->get('modifiedformat');
    }
    if ($this->get('createdformat')) {
      $this->context->debug && 
        $this->context
          ->debug("Setting modified format to ".
            $this->get('createdformat'));          
      $this->formats['created']=$this->get('createdformat');
    }
  }

  #
  # A field is identified as a custom one if 
  #
  #   1) implicitcustom field is false and
  #     a) it starts with the custom field prefix, or
  #     b) it is listed in the supportedCustomFields
  # or 2) implictcustom field is true and
  #   a) it is not in the supportParameters list
  #
  # Note that nowadays Bugzilla enforces custom fields to start with "cf_"
  #
  protected function isCustomField($column) {
    if ($this->get('implicitcustom')=="true") {
      $flag=!array_key_exists($column,$this->columnName);
      $flag && $this->context->debug && $this->context->debug("$column is an implicit custom field");
      return $flag;
    } else {
      $flag=substr($column,0,$this->customPrefixLength)==$this->get('customprefix') ||
        array_key_exists($column,$this->supportedCustomFields);
      $flag && $this->context->debug && $this->context->debug("$column is an explicit custom field");
      return $flag;
    }
  }
  
  protected function addCustomField($column) {
    array_push($this->requiredCustomFields,$column);
    $this->context->debug && 
      $this->context->debug("Custom field added $column");
  } 
  
  protected function initFieldIds($db) {
    #
    # Initialise the fieldIds
    #
    if (sizeof(BugzillaQuery::$fieldIds) <= 1) {
      $result = $this->connector->execute("select id,name from ".$this->connector->getTable("fielddefs"),$db);
      $this->context->debug &&
        $this->context->debug("Registering field ids : ".$this->connector->getRowCount($result));              
      while ($line = $this->connector->fetch($result)) {
        BugzillaQuery::$fieldIds[$line["name"]]=$line["id"];
        $this->context->debug &&
          $this->context->debug("Registering field id".$line["name"]." -> ".$line["id"]);              
      }
    } else {
      $this->context->debug &&
        $this->context->debug("Field ids already initialised : ".sizeof($this->fieldIds));                    
    }    
    return BugzillaQuery::$fieldIds;
  }
  
  
}
?>