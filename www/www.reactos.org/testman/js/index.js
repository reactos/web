/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     JavaScript file for the Testman Front Page
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 *              Copyright 2014 Kamil Hornicek (kamil.hornicek@reactos.org)
 */

var CurrentPage;
var data;
var RevisionRangeStart;
var RevisionRangeEnd;
var PageCount;
var ResultCount;
var SelectedResults = new Object();
var SelectedResultCount = 0;

var REQUESTTYPE_FULLLOAD = 1;
var REQUESTTYPE_ADDPAGE = 2;
var REQUESTTYPE_PAGESWITCH = 3;

function SetLoading(value)
{
	document.getElementById("ajax_loading_search").style.visibility = (value ? "visible" : "hidden");
}

/**
 * Make sure that all checkboxes for the results in SelectedResults are checked.
 */
function UpdateAllCheckboxes()
{
	for (id in SelectedResults)
	{
		var checkbox = document.getElementById("test_" + id);

		if (checkbox)
			checkbox.checked = true;
	}
}

function ResultCheckbox_OnClick(checkbox)
{
	// Make sure the user doesn't select more than he's allowed to :-)
	if (checkbox.checked && SelectedResultCount == MAX_COMPARE_RESULTS)
	{
		alert(testman_langres["maxselection"].replace(/\{1\}/, MAX_COMPARE_RESULTS));
		checkbox.checked = false;
		return;
	}

	var id = checkbox.id.substr(5);

	if (checkbox.checked)
	{
		SelectedResults[id] = true;
		SelectedResultCount++;
	}
	else
	{
		delete SelectedResults[id];
		SelectedResultCount--;
	}

	// Update the status message
	document.getElementById("selectedresultcount").innerHTML = SelectedResultCount;
}

function ResultCell_OnClick(elem)
{
	var IDArray = new Array();

	// Get the ID through the "id" attribute of the checkbox
	IDArray.push(parseInt(elem.parentNode.firstChild.firstChild.id.substr(5)));
	OpenComparePage(IDArray);
}

function GetRevisions()
{
	var revisions = document.getElementById("search_revision").value;

	// If the user didn't enter any revision number at all, he doesn't want to search for a specific revision
	if (!revisions)
	{
		RevisionRangeStart = "";
		RevisionRangeEnd = "";
		return true;
	}

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

function SearchCall()
{
	SetLoading(true);
	AjaxGet("ajax-search.php", "SearchCallback", data);
}

function SearchButton_OnClick()
{
	if (!GetRevisions())
	{
		alert(shared_langres["invalidrev"]);
		return;
	}

	CurrentPage = 1;
	data = new Array();
	data["startrev"] = RevisionRangeStart;
	data["endrev"] = RevisionRangeEnd;
	data["source"] = document.getElementById("search_source").value;
	data["platform"] = document.getElementById("search_platform").value;
	data["page"] = CurrentPage;
	data["resultlist"] = 1;
	data["requesttype"] = REQUESTTYPE_FULLLOAD;

	if (window.localStorage)
		localStorage.setItem("testman_source", data["source"]);

	SearchCall();
}

function ResizeIFrame()
{
	var iframe = document.getElementById("comparepage_frame");
	iframe.height = iframe.contentDocument.body.offsetHeight + 40;
}

function Load()
{
	// React on Return key presses.
	var f = function(keyevent)
	{
		// keyevent.which - supported under NS 4.0, Opera 5.12, Firefox, Konqueror 3.3, Safari
		// window.event - for IE Browsers
		if((keyevent && keyevent.which == 13) || (window.event && window.event.keyCode == 13))
			SearchButton_OnClick();
	};
	document.getElementById("search_revision").onkeypress = f;
	document.getElementById("search_source").onkeypress = f;
	document.getElementById("search_platform").onkeypress = f;

	// Load the settings.
	if (window.localStorage)
	{
		document.getElementById("opennewwindow").checked = parseInt(window.localStorage.getItem("testman_opennewwindow"));
		document.getElementById("search_source").value = window.localStorage.getItem("testman_source") ? window.localStorage.getItem("testman_source") : DEFAULT_SEARCH_SOURCE;
	}

	// Search for the 10 last results, sorted with the newest on top.
	// Descending order and limiting is not doable with the regular Search function, so we have to do the call ourselves.
	CurrentPage = 1;
	data = new Array();
	data["desc"] = 1;
	data["limit"] = DEFAULT_SEARCH_LIMIT;
	data["source"] = document.getElementById("search_source").value;
	data["page"] = CurrentPage;
	data["resultlist"] = 1;
	data["requesttype"] = REQUESTTYPE_FULLLOAD;

	SearchCall();
}

function GetTagData(RootElement, TagName)
{
	var Child = RootElement.getElementsByTagName(TagName)[0].firstChild;
	return Child ? Child.data : "";
}

function SearchCallback(HttpRequest)
{
	// Check for an error
	if (HttpRequest.responseXML.getElementsByTagName("error").length > 0)
	{
		alert(HttpRequest.responseXML.getElementsByTagName("error")[0].firstChild.data)
		return;
	}

	var html = "";
	var RequestResultCount = parseInt(HttpRequest.responseXML.getElementsByTagName("resultcount")[0].firstChild.data);
	var MoreResults = (RequestResultCount > RESULTS_PER_PAGE);
	var FirstRev = "";
	var LastRev = "";

	if (RequestResultCount > 0)
	{
		FirstRev = HttpRequest.responseXML.getElementsByTagName("firstrev")[0].firstChild.data;
		LastRev = HttpRequest.responseXML.getElementsByTagName("lastrev")[0].firstChild.data;
	}

	if (data["requesttype"] == REQUESTTYPE_FULLLOAD || data["requesttype"] == REQUESTTYPE_PAGESWITCH)
	{
		// Build a new infobox
		html += '<div class="row"><div id="infobox" class="col-sm-2">';

		if(data["requesttype"] == REQUESTTYPE_FULLLOAD)
		{
			ResultCount = RequestResultCount;
			PageCount = 1;
			html += testman_langres["foundresults"].replace(/\{1\}/, ResultCount);
		}
		else
		{
			html += document.getElementById("infobox").innerHTML;
		}

		html += '<\/div>';

		html += '<div class="col-sm-4">';
		html += testman_langres["status"].replace(/\{1\}/, '<span id="selectedresultcount">0<\/span>');
		html += ' <button class="btn btn-default" onclick="ClearSelected_OnClick()">' + testman_langres["clearselected"] + '<\/button>';
		html += '<\/div>';

		if (PageCount > 1 || MoreResults)
		{
			// Page number boxes
			html += '<div id="pagesbox" class="form-inline pull-right">';

			html += '<button class="btn btn-default" ' + (CurrentPage > 1 ? 'onclick="FirstPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["firstpage_title"] + '"><i class="icon icon-angle-double-left"><\/i><\/button> ';
			html += '<button class="btn btn-default" ' + (CurrentPage > 1 ? 'onclick="PrevPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["prevpage_title"] + '"><i class="icon icon-angle-left"><\/i><\/button> ';

			html += '<select class="form-control" id="pagesel" size="1" onchange="PageBox_OnChange(this)">';

			if (data["requesttype"] == REQUESTTYPE_FULLLOAD)
			{
				html += '<option value="' + CurrentPage + '">';
				html += shared_langres["page"] + ' ' + CurrentPage;
				html += ' - ' + FirstRev + ' ... ' + LastRev;
				html += '<\/option>';
			}
			else
			{
				html += document.getElementById("pagesel").innerHTML;
			}

			html += '<\/select> ';

			html += '<button class="btn btn-default" ' + (MoreResults ? 'onclick="NextPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["nextpage_title"] + '"><i class="icon icon-angle-right"><\/i><\/button> ';
			html += '<button class="btn btn-default" ' + (MoreResults ? 'onclick="LastPage_OnClick()"' : 'disabled="disabled"') + ' title="' + shared_langres["lastpage_title"] + '"><i class="icon icon-angle-double-right"><\/i><\/button>';

			html += '<\/div>';
		}

		html += '<\/div><\/div>';

		// File table
		html += '<table class="table table-hover" id="resulttable">';

		html += '<thead><tr class="head">';
		html += '<th class="TestCheckbox"><\/th>';
		html += '<th>' + shared_langres["revision"] + '<\/th>';
		html += '<th>' + shared_langres["date"] + '<\/th>';
		html += '<th>' + testman_langres["totaltests"] + '<\/th>';
		html += '<th>' + testman_langres["failedtests"] + '<\/th>';
		html += '<th>' + testman_langres["source"] + '<\/th>';
		html += '<th>' + testman_langres["platform"] + '<\/th>';
		html += '<th>' + testman_langres["comment"] + '<\/th>';
		html += '<\/tr><\/thead>';
		html += '<tbody>';

		var results = HttpRequest.responseXML.getElementsByTagName("result");

		if (!results.length)
		{
			html += '<tr><td colspan="8">' + testman_langres["noresults"] + '<\/td><\/tr>';
		}
		else
		{
			for (var i = 0; i < results.length; i++)
			{
				html += '<tr>';
				html += '<td><input onclick="ResultCheckbox_OnClick(this)" type="checkbox" id="test_' + GetTagData(results[i], "id") + '" \/><\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "revision") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "date") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "count") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "failures") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "source") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "platform") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "comment") + '<\/td>';
				html += '<\/tr>';
			}
		}

		html += '<\/tbody><\/table>';

		document.getElementById("searchtable").innerHTML = html;

		if(data["requesttype"] == REQUESTTYPE_PAGESWITCH)
		{
			// Switch the selected page in the Page ComboBox
			document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage - 1].selected = true;
		}

		UpdateAllCheckboxes();
	}
	else
	{
		// Just add a new page to the Page combo box and the information for it
		PageCount++;

		// As always, we have to work around an IE bug
		// If I use "innerHTML" here, the first <OPTION> start tag gets dropped in the IE...
		// Therefore I have to use the DOM functions in this case.
		var OptionElem = document.createElement("option");
		var OptionText = document.createTextNode(shared_langres["page"] + ' ' + PageCount + ' - ' + FirstRev + ' ... ' + LastRev);

		OptionElem.value = PageCount;
		OptionElem.appendChild(OptionText);

		document.getElementById("pagesel").appendChild(OptionElem);
	}

	if (MoreResults && (data["requesttype"] == REQUESTTYPE_FULLLOAD || data["requesttype"] == REQUESTTYPE_ADDPAGE))
	{
		// There are more results available in the full range. Therefore we have to start another request and add a new page.
		data["resultlist"] = 0;
		data["page"] = PageCount + 1;
		data["requesttype"] = REQUESTTYPE_ADDPAGE;
		SearchCall();
	}
	else
	{
		// If data["desc"] is set, this is the initial search performed in Load().
		// In this case, set the search_revision field to the range we got.
		if (data["desc"] && FirstRev && LastRev)
			document.getElementById("search_revision").value = LastRev + "-" + FirstRev;

		SetLoading(false);
	}
}

/**
 * Open the Compare page in the user-defined area
 *
 * @param ResultArray
 * Array containing the result IDs to pass to the Compare page.
 * The array will be sorted ascending before.
 */
function OpenComparePage(ResultArray)
{
	var parameters = "ids=";

	ResultArray.sort(NumericComparison);

	for (var i = 0; i < ResultArray.length; i++)
	{
		if (i == 0)
		{
			parameters += ResultArray[i];
			continue;
		}

		parameters += "," + ResultArray[i];
	}

	if (document.getElementById("opennewwindow").checked)
	{
		window.open("compare.php?" + parameters);
	}
	else
	{
		var iframe = document.getElementById("comparepage_frame");

		iframe.src = "compare.php?" + parameters;
		iframe.style.display = "block";
	}
}

function CompareFirstTwoButton_OnClick()
{
	var IDArray;
	var trs = document.getElementById("resulttable").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

	if (trs[0].firstChild.firstChild.nodeName != "INPUT")
		return;

	// Get the IDs through the "id" attribute of the checkboxes
	IDArray = new Array();
	IDArray.push(parseInt(trs[0].firstChild.firstChild.id.substr(5)));

	if (trs[1])
		IDArray.push(parseInt(trs[1].firstChild.firstChild.id.substr(5)));

	OpenComparePage(IDArray);
}

function PageSwitch(NewPage)
{
	CurrentPage = NewPage;
	data["page"] = NewPage;
	data["resultlist"] = 1;
	data["requesttype"] = REQUESTTYPE_PAGESWITCH;

	SearchCall();
}

function FirstPage_OnClick()
{
	PageSwitch(document.getElementById("pagesel").getElementsByTagName("option")[0].value);
}

function PrevPage_OnClick()
{
	PageSwitch(document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage - 2].value);
}

function PageBox_OnChange(elem)
{
	PageSwitch(elem.value);
}

function NextPage_OnClick()
{
	PageSwitch(document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage].value);
}

function LastPage_OnClick()
{
	PageSwitch(document.getElementById("pagesel").getElementsByTagName("option")[PageCount - 1].value);
}

function NumericComparison(a, b)
{
	return a - b;
}

function CompareSelectedButton_OnClick()
{
	var IDArray = new Array();

	// Sort the selected IDs
	for (id in SelectedResults)
		IDArray.push(parseInt(id));

	if (!IDArray.length)
	{
		alert(testman_langres["noselection"]);
		return;
	}
	else if (IDArray.length < 2)
	{
		alert(testman_langres["selectatleast"].replace(/\{1\}/, 2));
		return;
	}

	OpenComparePage(IDArray);
}

function OpenNewWindowCheckbox_OnClick(checkbox)
{
	if (window.localStorage)
		window.localStorage.setItem("testman_opennewwindow", checkbox.checked ? '1' : '0');

	document.getElementById("comparepage_frame").style.display = "none";
}

function ClearSelected_OnClick()
{
	document.getElementById("selectedresultcount").innerHTML = '0';

	for (id in SelectedResults)
		document.getElementById('test_' + id).checked = false;

	SelectedResults = new Object();
	SelectedResultCount = 0;
}
