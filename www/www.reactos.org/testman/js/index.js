/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     JavaScript file for the Testman Front Page
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 *              Copyright 2014 Kamil Hornicek (kamil.hornicek@reactos.org)
 *              Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

// The filters of api/runs.php, mapped to the form fields that hold them. The whole
// search state lives in the query string, so every search is a shareable URL.
var FILTER_FIELDS = {
	from: "search_from",
	to: "search_to",
	rev: "search_revision",
	rev_from: "search_rev_from",
	rev_to: "search_rev_to",
	pr: "search_pr",
	source: "search_source",
	platform: "search_platform",
	min_failures: "search_min_failures"
};

// What a field shows when the query string does not mention it. The form starts on
// master-only, but a URL that leaves "pr" out really does mean every build, so the
// dropdown has to say so rather than silently disagreeing with the results below it.
var FILTER_DEFAULTS = {
	pr: "all"
};

// The response of the page that is currently shown, for the Newer/Older buttons.
var CurrentQuery = null;
var CurrentResponse = null;

var SelectedResults = new Object();
var SelectedResultCount = 0;

function SetLoading(value)
{
	document.getElementById("ajax_loading_search").style.visibility = (value ? "visible" : "hidden");
}

function Escape(value)
{
	if (value === null || value === undefined)
		return "";

	return String(value).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
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

/**
 * Collects the filters from the form, leaving out the ones that were not filled in.
 */
function ReadFilters()
{
	var filters = new Object();

	for (var name in FILTER_FIELDS)
	{
		var value = document.getElementById(FILTER_FIELDS[name]).value.trim();

		if (value)
			filters[name] = value;
	}

	return filters;
}

function WriteFilters(query)
{
	// "pr" can also be a single pull request number, which is not one of the two options
	// the dropdown ships with. Give it one, or pressing Search would quietly widen the
	// view back to every build.
	var select = document.getElementById(FILTER_FIELDS["pr"]);
	var pr = query["pr"];

	for (var i = select.options.length - 1; i >= 0; i--)
	{
		if (select.options[i].dataset.onepr)
			select.remove(i);
	}

	if (pr && /^[0-9]+$/.test(pr))
	{
		var option = document.createElement("option");

		option.value = pr;
		option.text = testman_langres["pullrequest"].replace(/\{1\}/, pr);
		option.dataset.onepr = "1";
		select.add(option);
	}

	for (var name in FILTER_FIELDS)
	{
		var fallback = (name in FILTER_DEFAULTS) ? FILTER_DEFAULTS[name] : "";
		document.getElementById(FILTER_FIELDS[name]).value = (name in query) ? query[name] : fallback;
	}
}

function BuildQueryString(query)
{
	var parts = new Array();

	for (var name in query)
	{
		if (query[name] !== null && query[name] !== "")
			parts.push(encodeURIComponent(name) + "=" + encodeURIComponent(query[name]));
	}

	return parts.join("&");
}

function ParseQueryString(search)
{
	var query = new Object();
	var parts = search.replace(/^\?/, "").split("&");

	for (var i = 0; i < parts.length; i++)
	{
		if (!parts[i])
			continue;

		var pair = parts[i].split("=");
		query[decodeURIComponent(pair[0])] = decodeURIComponent((pair[1] || "").replace(/\+/g, " "));
	}

	return query;
}

/**
 * Runs the query against api/runs.php and renders the result.
 *
 * @param query
 * The filters plus the optional "cursor" and "dir" of the page to show.
 *
 * @param push
 * Whether to add the query to the browser history. False when the query came from the
 * history in the first place, i.e. on page load and when going back.
 */
function Search(query, push)
{
	var querystring = BuildQueryString(query);

	CurrentQuery = query;
	SetLoading(true);

	// Paging is a seek on the run id, so there is exactly one request per page and no
	// total count. Nothing walks the result set any more.
	fetch("api/runs.php?" + querystring)
		.then(function(response) { return response.json(); })
		.then(function(data)
		{
			SetLoading(false);

			if (data.error)
			{
				alert(data.error);
				return;
			}

			CurrentResponse = data;
			RenderResults(data);

			document.getElementById("overview").style.display = "none";

			if (push)
				history.pushState(query, "", querystring ? "?" + querystring : location.pathname);
		})
		.catch(function(error)
		{
			SetLoading(false);
			alert(testman_langres["loadfailed"] + "\n\n" + error);
		});
}

/**
 * What the run was built on top of, which for a pull request build is not the commit it
 * built. A master run is its own base, so saying so again in its own column would be
 * noise; it gets an empty cell.
 */
function RenderAnchor(run)
{
	var html = "";

	if (run.pr_number !== null)
	{
		html += '<a href="' + GITHUB_PR_URL + run.pr_number + '" target="_blank" rel="noopener">';
		html += Escape(testman_langres["pullrequest"].replace(/\{1\}/, run.pr_number)) + '<\/a>';
		html += ' <a href="?pr=' + run.pr_number + '" title="' + Escape(testman_langres["allrunsforpr"]) + '">&#9776;<\/a>';
	}

	if (run.base_revision !== null && run.base_revision !== run.revision)
		html += ' <span class="anchor">' + Escape(run.base_revision_short) + '<\/span>';

	if (!run.base_exact && run.base_order !== null)
		html += ' <span class="approx" title="' + Escape(testman_langres["approximatehint"]) + '">' + Escape(testman_langres["approximate"]) + '<\/span>';

	if (run.base_order === null && run.pr_number !== null)
		html += ' <span class="approx">' + Escape(testman_langres["unanchored"]) + '<\/span>';

	return html;
}

function RenderResults(data)
{
	// has_more only speaks about the direction that was asked for. In the other one we
	// either came from a page (so it exists) or we are at the newest run (so it does not).
	var newer = (CurrentQuery["dir"] == "newer");
	var HasOlder = newer ? true : data.has_more;
	var HasNewer = newer ? data.has_more : !!CurrentQuery["cursor"];

	var html = "";

	html += '<div class="row"><div id="infobox" class="col-sm-3">';
	html += testman_langres["showingresults"].replace(/\{1\}/, data.runs.length);
	html += '<\/div>';

	html += '<div class="col-sm-4">';
	html += testman_langres["status"].replace(/\{1\}/, '<span id="selectedresultcount">' + SelectedResultCount + '<\/span>');
	html += ' <button class="btn btn-default" onclick="ClearSelected_OnClick()">' + testman_langres["clearselected"] + '<\/button>';
	html += '<\/div>';

	html += '<div id="pagesbox" class="form-inline pull-right">';
	html += '<button class="btn btn-default" ' + (HasNewer ? 'onclick="NewerPage_OnClick()"' : 'disabled="disabled"') + '><i class="fa fa-angle-left"><\/i> ' + testman_langres["newer"] + '<\/button> ';
	html += '<button class="btn btn-default" ' + (HasOlder ? 'onclick="OlderPage_OnClick()"' : 'disabled="disabled"') + '>' + testman_langres["older"] + ' <i class="fa fa-angle-right"><\/i><\/button>';
	html += '<\/div>';

	html += '<\/div>';

	html += '<table class="table table-hover" id="resulttable">';

	html += '<thead><tr class="head">';
	html += '<th class="TestCheckbox"><\/th>';
	html += '<th>' + shared_langres["revision"] + '<\/th>';
	html += '<th>' + testman_langres["anchor"] + '<\/th>';
	html += '<th>' + shared_langres["date"] + '<\/th>';
	html += '<th>' + testman_langres["totaltests"] + '<\/th>';
	html += '<th>' + testman_langres["failedtests"] + '<\/th>';
	html += '<th>' + testman_langres["source"] + '<\/th>';
	html += '<th>' + testman_langres["platform"] + '<\/th>';
	html += '<th>' + testman_langres["comment"] + '<\/th>';
	html += '<\/tr><\/thead>';
	html += '<tbody>';

	if (!data.runs.length)
	{
		html += '<tr><td colspan="9">' + testman_langres["noresults"] + '<\/td><\/tr>';
	}
	else
	{
		for (var i = 0; i < data.runs.length; i++)
		{
			var run = data.runs[i];

			html += '<tr' + (run.pr_number !== null ? ' class="prrun"' : '') + '>';
			html += '<td><input onclick="ResultCheckbox_OnClick(this)" type="checkbox" id="test_' + run.id + '" \/><\/td>';
			html += '<td onclick="ResultCell_OnClick(this)">' + Escape(run.revision_short) + '<\/td>';
			html += '<td>' + RenderAnchor(run) + '<\/td>';
			html += '<td onclick="ResultCell_OnClick(this)">' + Escape(run.date) + '<\/td>';
			html += '<td onclick="ResultCell_OnClick(this)">' + run.count + '<\/td>';
			html += '<td onclick="ResultCell_OnClick(this)">' + run.failures + '<\/td>';
			html += '<td onclick="ResultCell_OnClick(this)">' + Escape(run.source) + '<\/td>';
			html += '<td onclick="ResultCell_OnClick(this)">' + Escape(run.platform_name) + '<\/td>';
			html += '<td onclick="ResultCell_OnClick(this)">' + Escape(run.comment) + '<\/td>';
			html += '<\/tr>';
		}
	}

	html += '<\/tbody><\/table>';

	document.getElementById("searchtable").innerHTML = html;
	UpdateAllCheckboxes();
}

function SearchButton_OnClick()
{
	// A new search always starts at the newest matching run, so no cursor.
	Search(ReadFilters(), true);
}

function ResetButton_OnClick()
{
	location.href = location.pathname;
}

/**
 * Continues from the page that is on screen. The filters come from the query that
 * produced it, not from the form: a cursor only means anything within the result set it
 * was taken from, so edits made without pressing Search must not leak into it.
 */
function PageFrom(cursor, dir)
{
	var query = new Object();

	for (var name in FILTER_FIELDS)
	{
		if (name in CurrentQuery)
			query[name] = CurrentQuery[name];
	}

	query["cursor"] = cursor;
	query["dir"] = dir;
	Search(query, true);
}

function OlderPage_OnClick()
{
	PageFrom(CurrentResponse.last_id, "older");
}

function NewerPage_OnClick()
{
	PageFrom(CurrentResponse.first_id, "newer");
}

/**
 * Renders whatever the query string asks for. Without one, the server-rendered overview
 * of the latest run per source is what the visitor gets.
 */
function ShowQuery(query, push)
{
	WriteFilters(query);

	var filtered = false;

	for (var name in query)
	{
		if (query[name] !== "")
			filtered = true;
	}

	if (filtered)
	{
		Search(query, push);
	}
	else
	{
		CurrentQuery = null;
		CurrentResponse = null;
		document.getElementById("searchtable").innerHTML = "";
		document.getElementById("overview").style.display = "";
	}
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

	for (var name in FILTER_FIELDS)
		document.getElementById(FILTER_FIELDS[name]).onkeypress = f;

	if (window.localStorage)
		document.getElementById("opennewwindow").checked = parseInt(window.localStorage.getItem("testman_opennewwindow"));

	window.onpopstate = function(event)
	{
		ShowQuery(event.state ? event.state : ParseQueryString(location.search), false);
	};

	ShowQuery(ParseQueryString(location.search), false);
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

function ResizeIFrame()
{
	var iframe = document.getElementById("comparepage_frame");
	iframe.height = iframe.contentDocument.body.offsetHeight + 40;
}

function CompareFirstTwoButton_OnClick()
{
	var IDArray;
	var table = document.getElementById("resulttable");

	if (!table)
		return;

	var trs = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

	if (trs[0].firstChild.firstChild.nodeName != "INPUT")
		return;

	// Get the IDs through the "id" attribute of the checkboxes
	IDArray = new Array();
	IDArray.push(parseInt(trs[0].firstChild.firstChild.id.substr(5)));

	if (trs[1])
		IDArray.push(parseInt(trs[1].firstChild.firstChild.id.substr(5)));

	OpenComparePage(IDArray);
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
