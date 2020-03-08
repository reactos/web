/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Easily download prebuilt ReactOS Revisions
 * COPYRIGHT:   Copyright 2007-2018 Colin Finck (colin@reactos.org)
 */

var data = new Array();

var CurrentPage;
var FileCount;
var PageCount;
var RevisionRangeStart;
var RevisionRangeEnd;

var REQUESTTYPE_FULLLOAD = 1;
var REQUESTTYPE_ADDPAGE = 2;
var REQUESTTYPE_PAGESWITCH = 3;

function SetLoading(value)
{
	document.getElementById("ajax_loading").style.visibility = (value ? "visible" : "hidden");
}

function AjaxGetFiles()
{
	SetLoading(true);
	AjaxGet("ajax-getfiles.php", "GetFilesCallback", data);
}

function GetFilesCallback(HttpRequest)
{
	// Check for an error
	if (HttpRequest.responseXML.getElementsByTagName("error").length > 0)
	{
		alert(HttpRequest.responseXML.getElementsByTagName("error")[0].firstChild.data);
		return;
	}

	var html = "";
	var RequestFileCount = parseInt(HttpRequest.responseXML.getElementsByTagName("filecount")[0].firstChild.data);
	var MoreFiles = (RequestFileCount > MAX_FILES_PER_PAGE);
	var FirstRev;
	var LastRev;

	if (RequestFileCount > 0)
	{
		FirstRev = HttpRequest.responseXML.getElementsByTagName("firstrev")[0].firstChild.data;
		LastRev = HttpRequest.responseXML.getElementsByTagName("lastrev")[0].firstChild.data;
	}

	if (data["requesttype"] == REQUESTTYPE_FULLLOAD || data["requesttype"] == REQUESTTYPE_PAGESWITCH)
	{
		// Build a new infobox
		html += '<span id="infobox">';

		if (data["requesttype"] == REQUESTTYPE_FULLLOAD)
		{
			FileCount = RequestFileCount;
			PageCount = 1;
			html += getbuilds_langres["foundfiles"].replace(/\{1\}/, FileCount);
		}
		else
		{
			html += document.getElementById("infobox").innerHTML;
		}

		html += '<\/span>';

		// Add pagination if necessary.
		if (PageCount > 1 || MoreFiles)
		{
			html += '<span id="pagesbox" class="form-inline pull-right">';

			html += '<button class="btn btn-default" ' + (CurrentPage > 1 ? 'onclick="FirstPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["firstpage_title"] + '"><i class="fa fa-angle-double-left"><\/i><\/button> ';
			html += '<button class="btn btn-default" ' + (CurrentPage > 1 ? 'onclick="PrevPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["prevpage_title"] + '"><i class="fa fa-angle-left"><\/i><\/button> ';

			html += '<select class="form-control" id="pagesel" size="1" onchange="PageSwitch(this)">';

			if (data["requesttype"] == REQUESTTYPE_FULLLOAD)
			{
				html += '<option value="' + CurrentPage + '-' + data["startrev"] + '">';
				html += shared_langres["page"] + ' ' + CurrentPage;
				html += ' - ' + FirstRev + ' ... ' + LastRev;
				html += '<\/option>';
			}
			else
			{
				html += document.getElementById("pagesel").innerHTML;
			}

			html += '<\/select> ';

			html += '<button class="btn btn-default" ' + (MoreFiles ? 'onclick="NextPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["nextpage_title"] + '"><i class="fa fa-angle-right"><\/i><\/button> ';
			html += '<button class="btn btn-default" ' + (MoreFiles ? 'onclick="LastPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["lastpage_title"] + '"><i class="fa fa-angle-double-right"><\/i><\/button>';

			html += '<\/span>';
		}

		// File table
		html += '<table class="table table-hover">';
		html += '<thead><tr class="head">';
		html += '<th class="fname">' + getbuilds_langres["filename"] + '<\/th>';
		html += '<th class="fsize">' + getbuilds_langres["size"] + '<\/th>';
		html += '<th class="fdate">' + shared_langres["date"] + '<\/th>';
		html += '<\/tr><\/thead>';
		html += '<tbody>';

		var files = HttpRequest.responseXML.getElementsByTagName("file");

		if (!files.length)
		{
			html += '<tr><td colspan="3">' + getbuilds_langres["nofiles"] + '<\/td><\/tr>';
		}
		else
		{
			for (var i = 0; i < files.length; i++)
			{
				var fname = files[i].getElementsByTagName("name")[0].firstChild.data;
				var fdir = files[i].getElementsByTagName("dir")[0].firstChild.data;
				var fsize = files[i].getElementsByTagName("size")[0].firstChild.data;
				var fdate = files[i].getElementsByTagName("date")[0].firstChild.data;
				var flink = '<a href="' + ISO_DOWNLOAD_URL + fdir + '/' + fname + '">';

				html += '<tr>';
				html += '<td>' + flink + '<i class="fa fa-file-o"></i> ' + fname + '<\/a><\/td>';
				html += '<td>' + flink + fsize + '<\/a><\/td>';
				html += '<td>' + flink + fdate + '<\/a><\/td>';
				html += '<\/tr>';
			}
		}

		html += '<\/tbody><\/table>';

		document.getElementById("filetable").innerHTML = html;

		if (data["requesttype"] == REQUESTTYPE_PAGESWITCH)
		{
			// Switch the selected page in the Page ComboBox
			document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage - 1].selected = true;
		}
	}
	else
	{
		// This is a REQUESTTYPE_ADDPAGE.
		PageCount++;

		// As always, we have to work around an IE bug
		// If I use "innerHTML" here, the first <OPTION> start tag gets dropped in the IE...
		// Therefore I have to use the DOM functions in this case.
		var OptionElem = document.createElement("option");
		var OptionText = document.createTextNode(shared_langres["page"] + ' ' + PageCount + ' - ' + FirstRev + ' ... ' + LastRev);

		OptionElem.value = PageCount + "-" + data["startrev"];
		OptionElem.appendChild(OptionText);

		document.getElementById("pagesel").appendChild(OptionElem);
	}

	if (MoreFiles && (data["requesttype"] == REQUESTTYPE_FULLLOAD || data["requesttype"] == REQUESTTYPE_ADDPAGE))
	{
		// There are more files available in the full range. Therefore we have to start another request and add a new page
		data["filelist"] = 0;
		data["startrev"] = LastRev;
		data["requesttype"] = REQUESTTYPE_ADDPAGE;
		AjaxGetFiles();
	}
	else
	{
		SetLoading(false);
	}
}

function GetRevisions()
{
	var revisions = document.getElementById("revision").value;
	var hyphen = revisions.indexOf("-");

	if (hyphen > 0)
	{
		RevisionRangeStart = revisions.substr(0, hyphen);
		RevisionRangeEnd = revisions.substr(hyphen + 1);
	}
	else
	{
		RevisionRangeStart = revisions;
		RevisionRangeEnd = revisions;
	}

	return (RevisionRangeStart && RevisionRangeEnd);
}

function SearchButton_OnClick()
{
	if (!GetRevisions())
	{
		alert(shared_langres["invalidrev"]);
		return;
	}

	// Perform the search.
	CurrentPage = 1;

	data["prefixes"] = "";
	var checkboxes = document.getElementsByName("prefixes");
	for (var i = 0; i < checkboxes.length; i++)
		if (checkboxes[i].checked)
			data["prefixes"] += checkboxes[i].id + ",";

	data["suffixes"] = "";
	var checkboxes = document.getElementsByName("suffixes");
	for (var i = 0; i < checkboxes.length; i++)
		if (checkboxes[i].checked)
			data["suffixes"] += checkboxes[i].id + ",";

	data["filelist"] = 1;
	data["startrev"] = RevisionRangeStart;
	data["endrev"] = RevisionRangeEnd;
	data["requesttype"] = REQUESTTYPE_FULLLOAD;

	AjaxGetFiles();

	// Update the Previous and Next buttons.
	document.getElementById("previous_button").disabled = true;
	document.getElementById("next_button").disabled = true;

	if (RevisionRangeStart.match(/^[0-9]{5}$/) && RevisionRangeEnd.match(/^[0-9]{5}$/))
	{
		// The user wants to find old SVN builds.
		// Just count one revision down and up in the previous and next buttons.
		UpdateButton(document.getElementById("previous_button"), parseInt(RevisionRangeStart) - 1);
		UpdateButton(document.getElementById("next_button"), parseInt(RevisionRangeEnd) + 1);
	}
	else
	{
		// The user wants to find GIT builds.
		// Determine the previous and next revisions in the master branch.
		var gitinfo = Array();
		gitinfo["short"] = 1;

		gitinfo["f"] = "prev";
		gitinfo["r"] = RevisionRangeStart;
		AjaxGet("/rosweb/ajax-gitinfo.php", "UpdatePrevButtonCallback", gitinfo);

		gitinfo["f"] = "next";
		gitinfo["r"] = RevisionRangeEnd;
		AjaxGet("/rosweb/ajax-gitinfo.php", "UpdateNextButtonCallback", gitinfo);
	}
}

function UpdateButton(btn, rev)
{
	btn.disabled = false;
	btn.onclick = function()
	{
		document.getElementById("revision").value = rev;
		SearchButton_OnClick();
	};
}

function UpdateButtonCallback(HttpRequest, button_id)
{
	// Check for an error
	if (HttpRequest.responseXML.getElementsByTagName("error").length > 0)
	{
		alert(HttpRequest.responseXML.getElementsByTagName("message")[0].firstChild.data);
		return;
	}

	var child = HttpRequest.responseXML.getElementsByTagName("gitinfo")[0].firstChild;
	if (child)
		UpdateButton(document.getElementById(button_id), child.data);
}

function UpdatePrevButtonCallback(HttpRequest)
{
	UpdateButtonCallback(HttpRequest, "previous_button");
}

function UpdateNextButtonCallback(HttpRequest)
{
	UpdateButtonCallback(HttpRequest, "next_button");
}

function Load()
{
	// React on Return key presses.
	document.getElementById("revision").onkeypress = function(keyevent)
	{
		// keyevent.which - supported under NS 4.0, Opera 5.12, Firefox, Konqueror 3.3, Safari
		// window.event - for IE Browsers
		if((keyevent && keyevent.which == 13) || (window.event && window.event.keyCode == 13))
			SearchButton_OnClick();
	};

	SearchButton_OnClick();
}

function PageSwitch(option)
{
	var info = option.value.split("-");

	CurrentPage = info[0];
	data["filelist"] = 1;
	data["startrev"] = info[1];
	data["requesttype"] = REQUESTTYPE_PAGESWITCH;

	AjaxGetFiles();
}

function FirstPage_OnClick()
{
	var options = document.getElementById("pagesel").getElementsByTagName("option");
	PageSwitch(options[0]);
}

function PrevPage_OnClick()
{
	var options = document.getElementById("pagesel").getElementsByTagName("option");
	PageSwitch(options[CurrentPage - 2]);
}

function NextPage_OnClick()
{
	var options = document.getElementById("pagesel").getElementsByTagName("option");
	PageSwitch(options[CurrentPage]);
}

function LastPage_OnClick()
{
	var options = document.getElementById("pagesel").getElementsByTagName("option");
	PageSwitch(options[options.length - 1]);
}
