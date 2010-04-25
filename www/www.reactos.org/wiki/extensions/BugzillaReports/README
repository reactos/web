{{extension
|name=BugzillaReports
|author=[[User:Ian Homer|Ian Homer]]
|type=parser function
|version=1.1
|update=July 7th, 2009
|status=stable
|mediawiki=1.13
|license=GPLv2
|description=Generate bugzilla reports
|download=[http://blog.bemoko.com/bugzillareports/ BugzillaReports]
}}
'''BugzillaReports''' generates great looking reports from [[Bugzilla]] which you can include in your [[MediaWiki]] pages (or in fact any PHP application). Great to provide access to Bugzilla info, for example:

# Generate release notes when you release
# Generate roadmap reports for what's coming in a future release
# Generate your personal task radar - what should you be doing next
# Access controlled reports - if you want to expose bugzilla summaries to those who don't have access to Bugzilla
# Provide reports easy for non-techies to read. 

Displays dependency reports, last comments on bug on hover over, supports interactions with voting & flagging and helps you to see what needs to be done next.  Read below for more bells and whistles.  Makes reporting on your bugs much easier than through the standard Bugzilla search UI.  It's your controlled window onto Bugzilla ...

[[Category:Bugzilla]]

See [http://blog.bemoko.com/2008/06/28/bugzilla-reports-for-mediawiki here] for an active discussion thread on this extension.

''I expect to release [[#Roadmap|v0.9.8]] within the next week.  If you have requests for what will be included in the release after this one then email me at bugzillareports -at- bemoko.com if you want to add anything to this list (or ... find any bugs).  I'm also preparing the v1.0 (stable) release.  For this v1.0 release I'd welcome any corrections updates to this page to get these docs up to date - lots of features have gone in the past few months that documented in the release notes at the bottom of this page, but not in the "learn by examples" below.  Anyone who does some updates to the docs will get in the credits.''  --[[User:Ian.homer|Ian Homer]] 22:20, 29 November 2008 (UTC)

=Pre-requisites=

* Bugzilla 3.0.x
* MediaWiki 1.13
* MySQL or PostgreSQL

=Installation=

# Download the extension bundle from [http://blog.bemoko.com/bugzillareports/ BugzillaReports]
# Unpack bundle into your '''extensions''' directory.  This should give you
#: BugzillaReports/BugzillaReports.i18n.php
#: BugzillaReports/BugzillaReports.php
#: BugzillaReports/skins/bz_main.css
#: etc

Add the following to your LocalSettings.php file:

<source lang="php">
require_once("$IP/extensions/BugzillaReports/BugzillaReports.php");
$wgBugzillaReports = array(
  'host'        => "localhost", 
  'database'    => "bugzilla",
  'user'        => "user",
  'password'    => "(your password)",
  'bzserver'    => "http://host"
);
</source>

or if you want to use [[interwiki]] links (which is recommended and worth the extra effort of setting up)

<source lang="php">
...
  'interwiki'   => "bugzilla"
...
</source>

where parameters are defined as follows:

# '''host''' &rArr; defaults to localhost, but if Bugzilla not on same machine as your mediawiki install then set the hostname here
# '''user''' and '''password''' of the database user with read access to the bugzilla '''database'''
# To get the bugs to link through to Bugzilla server, use one of:
## '''bzserver''' &rArr; the URL of the bugzilla server for which the click through links should point to e.g. http://host".  Note that the path "/show_bug.cgi?id=" is automatically added for you by the extension
## '''interwiki''' &rArr; [[interwiki]] prefix linking to bugzilla instance
##: For example set up interwiki prefix of '''bugzilla''' to point to URL http://host/show_bug.cgi?id=$1
# '''maxrows''' &rArr; set maximum number of rows to display (defaults to 200)

==PostgreSQL==

<source lang="php">
$wgBugzillaReports = array(
  'host'      => "localhost" 
  'dbdriver'  => "pg",
  'database'  => "bugzilla",
  'user'      => "bugs",
  'password'  => "password",
  ...
);
</source>

=Example Output=

[[Image:bugzilla-reports-screenshot3.png|Bugzilla Report]]

Note that the bubble appears as you roll over a bug that has a last comment set.

=Usage=

: ''Note that several features are described in the release notes below and have not yet been documented in this section.  I anticipate reflecting these changes in the documentation prior to the v1 release.  Apologies for this gap in information, it should only be temporary'' --[[User:Ian.homer|Ian Homer]] 22:10, 21 October 2008 (UTC)

==By Example==
Generate a report from Bugzilla based on search criteria, e.g.

[[Image:bugzilla-reports-screenshot1.png|Bugzilla Report|right]]

List all open bugs - note that status defaults to NEW,ASSIGNED,UNCONFIRMED,REOPENED and maximum of 200 rows (by default) are returned. Results are sorted by priority. 

<source lang="php">
{{#bugzilla:}}
</source>

Report on P3 and higher bugs

<source lang="php">
{{#bugzilla:
  |priority=P1,P2,P3
}}
</source>

Report on a particular product version

<source lang="php">
{{#bugzilla:
  |product=myproduct
  |version=1.3
  |lastcomment=1
}}
</source>

Report on specific bug ids
<source lang="php">
{{#bugzilla:id=30,56,78,93}}
</source>

[[Image:bugzilla-reports-screenshot2.png|Last Comment Bubbles|right]]
Report on all enhancements with the text wiki in the summary with last comment bubbles

<source lang="php">
{{#bugzilla:
  |search=wiki
  |severity=enhancement
  |header=hide
  |lastcomment=1
}}
</source>

Setting the '''lastcomment''' parameter will generate a report which renders the last comment in bundles in bubbles as you hover each row (see image left)  This has been tested on Firefox 3 and Safari 3, but this option may have issues with other and older browser.  I'd be happy to hear feedback on this feature.

Report on all bugs that are not new

<source lang="php">
{{#bugzilla:status=!NEW}}
</source>

Everything except P1 and P2 bugs

<source lang="php">
{{#bugzilla:
  |priority=!(P1,P2)
  |status=*
}}
</source>

Set the message when no results are returned

<source lang="php">
{{#bugzilla:
  |product=doesntexist
  |noresultsmessage=all tasks complete
}}
</source>

Tasks with votes against them

<source lang="php">
{{#bugzilla:columns=+votes|votes=+}}
</source>

[[Image:bugzilla-reports-screenshot4.png]]

<source lang="php">
{{#bugzilla:
  |group=deadline
  |groupformat=radar
}}
</source>

[[Image:bugzilla-reports-screenshot5.png]]

<source lang="php">
{{#bugzilla:
  |group=version
  |bar=status
}}
</source>

All tasks created by me but not assigned to me

<source lang="php">
{{#bugzilla:columns=+to|from=me@bemoko.com|to=!me@bemoko.com}}
</source>

All tasks I'm cc'd on but not created by me and not assigned to me

<source lang="php">
{{#bugzilla:columns=+to,+from
  |to=!me@bemoko.com
  |from=!me@bemoko.com
  |cc=me@bemoko.com}}
</source>

Display list in a format that's handy for cutting and pasting into emails

<source lang="php">
{{#bugzilla:format=list}}
</source>

for example:

: [IHO] (2008-07-22) Do something (#19)
: [IHO] (2008-07-25) Do something else (#45)
: [JBL] Don't forget this (#54)

===Task Radar===

<source lang="php">
{{task radar|me@bemoko.com}}
</source>

where task radar is defined as:

<source lang="php">
=Flagged=
{{#bugzilla:flag={{{1}}}|lastcomment=1|noresultsmessage=No tasks flagged}}
=Up & Coming=
{{#bugzilla:to={{{1}}}|columns=-version,+deadline|deadline=+|group=deadline|groupformat=radar|lastcomment=1|noresultsmessage=Nothing up & coming}}
=My Product Priority Radar=
{{#bugzilla:to={{{1}}}|lastcomment=1|product=myproduct|noresultsmessage=Nothing to do on myproduct}}
=Voted Tasks=
{{#bugzilla:to={{{1}}}|columns=+deadline|group=product|votes=+|noresultsmessage=None of your tasks have received votes}}
=Raised=
{{#bugzilla:from={{{1}}}|to=!{{{1}}}|noresultsmessage=You have not raised anything}}
=CC=
{{#bugzilla:to=!{{{1}}}|from=!{{{1}}}|cc={{{1}}}|noresultsmessage=No ccs}}
=Other Priority Radar=
{{#bugzilla:to={{{1}}}|product=!myproduct|group=product|noresultsmessage=Nothing else to do}}
</source>

==Parameter Usage==

{| style="-moz-border-radius:8px;border: 1px solid #f0f0f0;border-spacing:0px;width: 80%;margin:auto"
|- style="vertical-align:top; background-color: #c0c0c0;"
! parameter
! style="width:30%" |values
! description
|- style="vertical-align:top;"
| '''alias'''
| alias value(s)
| alias query field
|- style="vertical-align:top; background-color: #f0f0f0;"
| '''bar'''
| column name
| field to summarise in a bar chart - note that this also works in conjunction with the group parameter to provide a set of bar charts.
|- style="vertical-align:top;"
| '''blocks'''
| id of blocking task (or "*" to include blocking tasks inline)
| blocks query field
|- style="vertical-align:top; background-color: #f0f0f0;"
| '''cc'''
|  single username
| Query for any task cc'd to the specified username, only supports single value
|- style="vertical-align:top;"
| '''columns'''
|  id, cc, deadline, modified, priority, product, severity, status, summary, to, version, estimated, remaining
| comma separated list of columns to display in the specified order
|- style="vertical-align:top; background-color: #f0f0f0;"
| '''component'''
| component name
| component query field
|- style="vertical-align:top;"
| '''deadline'''
| "*" &rArr; (any), "+" &rArr; (set)
| deadline query field
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''debug'''
| true
| Set to enable debugging - outputs SQL at end of table
|- style="vertical-align:top;"
| '''depends'''
| id of dependent task (or "*" to include dependent tasks inline)
| dependent query field
|- style="vertical-align:top;"
| '''dependsstatus'''
| status query field
| Specify criteria for display depends (and blocks rows), e.g. dependsstatus=!(CLOSED,VERIFIED) will not display CLOSED and VERIFIED tickets in dependency or blocks report.  It defaults to !(CLOSED,VERIFIED,RESOLVED)
|- style="vertical-align:top; background-color: #f0f0f0;"
| '''detailsrow'''
| ''same as values for columns''
| comma separated list of columns to display in the specified order on a second row
|- style="vertical-align:top;"
| '''flag'''
| username, e.g. me@bemoko.com
| search for all tasks flag for the specified user
|- style="vertical-align:top;"
| '''group'''
| any column name as described in the columns field
| field to group report on
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''groupformat'''
| radar (headings set to relative date names, e.g. today, tomorrow, next week)
| format to be applied to group headings
|- style="vertical-align:top;"
| '''grouporder'''
| (same as order parameter)
| order for group sorting
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''heading'''
| any text
| Heading to display above table (if there are tasks displayed in the report)
|- style="vertical-align:top;"
| '''headers'''
| hide
| Set to '''"hide"''' to hide the header row
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''hide'''
| true
| Hide all detail rows, useful in conjunction with totals (and perhaps group) to just display sub-totals
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''id'''
| ''bugzilla id''
| ID query field
|- style="vertical-align:top;"
| '''lastcomment'''
| 1
| display the last comment for each bug
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''maxrows'''
| any integer less than that configure in the LocalSettings.php configuration
| Maximum number of rows to return
|- style="vertical-align:top;"
| '''maxrowsbar'''
| any integer less than that configure in the LocalSettings.php configuration
| Maximum number of rows to return in calculation of bar reports
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''milestone'''
| milestone value(s)
| milestone query field
|- style="vertical-align:top;"
| '''noresultsmessage'''
| any text messag
| Set the message when there are no results matching the query
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''nameformat'''
| "real" (default), "login" or "tla"
| format of names, either real name, e.g. Ian Homer, login name, e.g. blah@blah.com, or three letter acronym, e.g. IHO
|- style="vertical-align:top;"
| '''order'''
| desc (or asc)
| sort order, defaults to asc
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''priority'''
| P1,P2,P3,P4,P5
| priority query field
|- style="vertical-align:top;"
| '''product'''
| ''bugzilla product names''
| product name query field
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''quickflag'''
| 1
| If flag is set against task then identify with a small "?" next to the ID which displays more info on hover over
|- style="vertical-align:top;"
| '''search'''
| ''anything''
| free text search - only searches short_desc at the moment
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''severity'''
| blocker, critical, major, normal, minor, trivial, enhancement
| severity query field
|- style="vertical-align:top;"
| '''sort'''
| any column name (or comma separated list of column names) as described in the columns field
| field to sort on 
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''status'''
| NEW,ASSIGNED,UNCONFIRMED,REOPENED,RESOLVED,VERIFIED,CLOSED
| status query field, note that this defaults to !CLOSED
|- style="vertical-align:top;"
| '''to'''
| a valid username, e.g. me@bemoko.com
| assigned to query field
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''total'''
| any column name (or comma separate list of column names)
| columns to display a total at the bottom.  For non numberic columns it just displays a count of the rows
|- style="vertical-align:top;background-color: #f0f0f0;"
| '''version'''
| ''bugzilla version name/number''
| version query field
|- style="vertical-align:top;"
| '''votes'''
| "+" &rArr; display any task with votes against it
| votes query field
|}


All query fields can take the following constructs

* value - single value to match 
* value1,value2, value3 - comma separate list of value to match
* !value - match on everything except value
* !(value1, value2, value3) - match on everything except the listed values
* "*" - match on everything (useful to override inbuilt default of status)
* "+" - match on not null
* "-" - match on not set

==With Semantic MediaWiki==

This extension works well with the [http://semantic-mediawiki.org/wiki/Semantic_MediaWiki Semantic MediaWiki] by 

# tagging your page with a property, e.g. <nowiki>[[task::52]]</nowiki>
# and then passing the results of semantic search into the bugzilla reports function, e.g.

<nowiki>{{#bugzilla:|headers=hide|id={{#ask: [[{{PAGENAME}}]] [[task::+]] | ? task | link=none | headers=hide}}}}</nowiki>

=Troubleshooting=

If you are having any issues with the use of this extension please 

<ol>
<li>include the following in your '''LocalSettings.php''' file

<source lang="php">
$wgDebugLogGroups  = array(
    'BMWExtension'      => '/tmp/logs-mediawiki-BMWExtension.log'
);
</source>

(Feel free to use any other location for your logs if /tmp is not appropriate)</li>

<li start="2">Include '''debug=1''' in your bugzilla function call

<source lang="php">
{{#bugzilla:
|product=live
|status=!RESOLVED
|maxrows=10
|heading=test 2
|debug=1
}}
</source></li>
<li start="3">If the error is related to a SQL failure then you might want to try the SQL command (as shown with the debug=1 enabled) directly in the SQL command line and observe the behaviour</li>
<li>Send to [http://blog.bemoko.com/bugzillareports/ me], along with a description of the issue, the output of this log, a copy of the <nowiki>{{#bugzilla:}}</nowiki> call and the relevant output from the wiki page.</li>
</ol>

=Roadmap=

: v0.9.8, with the features described below, is currently undergoing regression testing on our company environment, expect a release in the coming week --[[User:Ian.homer|Ian Homer]] 22:17, 29 November 2008 (UTC)

# Support less than and greater than version number and milestone (#544) - will be in v0.9.8
# Support for first comment and multiple comments (over and above last comments) (#748) - will be in v0.9.8
# Wildcard support, e.g. 2.0.% (#776) - will be in v0.9.8
# Align sort naming with columns naming, e.g. assignedto vs to (#781) - will be in v0.9.8
# Support custom fields that don't start with "cf_" (#782) - will be in v0.9.8
# Support filters and sorting on custom fields (#783) - will be in v0.9.8
# Make disable cache a LocalSettings configuration element (#820) - will be in v0.9.8
