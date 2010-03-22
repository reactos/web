/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    JavaScript file for the Index Page (parsed by PHP before)
  COPYRIGHT:  Copyright 2008-2009 Colin Finck <colin@reactos.org>

  charset=utf-8
*/

var CurrentPage;
var data;
var FullRange;
var inputbox_startrev;
var inputbox_endrev;
var PageCount;
var ResultCount;
var SelectedResults = new Object();
var SelectedResultCount = 0;

var REQUESTTYPE_FULLLOAD = 1;
var REQUESTTYPE_ADDPAGE = 2;
var REQUESTTYPE_PAGESWITCH = 3;

function SetRowColor(elem, color)
{
	tdl = elem.getElementsByTagName("td");
	
	for(var i = 0; i < tdl.length; i++)
		tdl[i].style.background = color;
}

function Result_OnMouseOver(elem)
{
	SetRowColor(elem, "#FFFFCC");
}

function Result_OnMouseOut(elem)
{
	if(elem.className == "odd")
		SetRowColor(elem, "#DDDDDD");
	else
		SetRowColor(elem, "#EEEEEE");
}

/**
 * Make sure that all checkboxes for the results in SelectedResults are checked.
 */
function UpdateAllCheckboxes()
{
	for(id in SelectedResults)
	{
		var checkbox = document.getElementById("test_" + id);
		
		if(checkbox)
			checkbox.checked = true;
	}
}

function ResultCheckbox_OnClick(checkbox)
{
	// Make sure the user doesn't select more than he's allowed to :-)
	if(checkbox.checked && SelectedResultCount == <?php echo MAX_COMPARE_RESULTS; ?>)
	{
		alert("<?php printf(addslashes($testman_langres["maxselection"]), MAX_COMPARE_RESULTS); ?>");
		checkbox.checked = false;
		return;
	}
	
	var id = checkbox.id.substr(5);

	if(checkbox.checked)
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
	document.getElementById("status").innerHTML = '<?php printf($testman_langres["status"], '<span id="selectedresultcount">\' + SelectedResultCount + \'<\/span>'); ?>';
}

function ResultCell_OnClick(elem)
{
	var IDArray = new Array();
	
	// Get the ID through the "id" attribute of the checkbox
	IDArray.push(parseInt(elem.parentNode.firstChild.firstChild.id.substr(5)));
	OpenComparePage(IDArray);
}

function SearchInputs_OnKeyPress(event)
{
	// IE vs. other browsers again
	if(window.event)
		var KeyCode = window.event.keyCode;
	else
		var KeyCode = event.which;
	
	// Submit the search form in case the user pressed the Return key
	if(KeyCode == 13)
		SearchButton_OnClick();
}

function SearchRevisionInput_OnKeyUp(elem)
{
	var val = elem.value.replace(/[^[0-9-]/g, "");
	
	// First check if something was changed by the replace function.
	// If not, don't set elem.value = val. Otherwise the cursor would always jump to the last character in IE, when you press any key.
	if(elem.value != val)
		elem.value = val;
}

function GetRevNums()
{
	var rev = document.getElementById("search_revision").value;
	
	// If the user didn't enter any revision number at all, he doesn't want to search for a specific revision
	if(!rev)
	{
		inputbox_startrev = "";
		inputbox_endrev = "";
		return true;
	}
	
	if(isNaN(rev) || rev < 1)
	{
		// Maybe the user entered a revision range
		var hyphen = rev.indexOf("-");
		
		if(hyphen > 0)
		{
			inputbox_startrev = rev.substr(0, hyphen)*1;
			inputbox_endrev = rev.substr(hyphen + 1)*1;

			// exchange start/end when wrong order was given
			if (inputbox_startrev > inputbox_endrev) {
				var tmp=inputbox_startrev;
				inputbox_startrev=inputbox_endrev;
				inputbox_endrev=tmp;
			}
		}
		
		if(hyphen <= 0 || isNaN(inputbox_startrev) || isNaN(inputbox_endrev))
		{
			alert("Invalid revision number!");
			return false;
		}
	}
	else
	{
		inputbox_startrev = rev;
		inputbox_endrev = rev;
	}
	
	return true;
}

function SearchCall()
{
	document.getElementById("ajax_loading_search").style.visibility = "visible";
	AjaxGet("ajax-search.php", "SearchCallback", data);
}

function SearchButton_OnClick()
{
	if(!GetRevNums())
		return;
	
	data = new Array();
	
	CurrentPage = 1;
	FullRange = document.getElementById("search_revision").value;
	
	data["startrev"] = inputbox_startrev;
	data["endrev"] = inputbox_endrev;
	data["user"] = document.getElementById("search_user").value;
	data["platform"] = document.getElementById("search_platform").value;
	
	data["resultlist"] = 1;
	data["requesttype"] = REQUESTTYPE_FULLLOAD;
	
	SearchCall();
}

function DetectObsoleteIE()
{
	var position = navigator.userAgent.indexOf("MSIE");
	
	if(position >= 0)
	{
		var version = navigator.userAgent.substr(position + 5, 1);
		return (version < 8);
	}
	
	return false;
}

function ResizeIFrame()
{
	if(DetectObsoleteIE())
		return;
	
	var iframe = document.getElementById("comparepage_frame");
	iframe.height = iframe.contentDocument.body.offsetHeight + 16;
}

function Load()
{
	// General settings
	var iframe = document.getElementById("comparepage_frame");
	
	if(DetectObsoleteIE())
	{
		document.getElementById("opennewwindow").checked = true;
		document.getElementById("opennewwindow").disabled = true;
	}
	else
	{
		document.getElementById("opennewwindow").checked = parseInt(GetCookieValue("opennewwindow"));
	}
	
	// Show the last revisions
	data = new Array();
	
	CurrentPage = 1;
	
	data["desc"] = 1;
	data["limit"] = <?php echo DEFAULT_SEARCH_LIMIT; ?>;
	data["user"] = "<?php echo DEFAULT_SEARCH_USER; ?>";
	
	data["resultlist"] = 1;
	data["requesttype"] = REQUESTTYPE_FULLLOAD;
	
	SearchCall();
}

function GetTagData(RootElement, TagName)
{
	var Child = RootElement.getElementsByTagName(TagName)[0].firstChild;
	
	if(!Child)
		return "";
	
	return Child.data;
}

function SearchCallback(HttpRequest)
{
	// Check for an error
	if(HttpRequest.responseXML.getElementsByTagName("error").length > 0)
	{
		alert(HttpRequest.responseXML.getElementsByTagName("error")[0].firstChild.data)
		return;
	}
	
	var html = "";
	
	if(data["resultlist"])
	{
		// Build a new infobox
		html += '<table id="infotable" cellspacing="0" cellpadding="0"><tr><td id="infobox">';
		
		if(data["requesttype"] == REQUESTTYPE_FULLLOAD)
		{
			ResultCount = parseInt(HttpRequest.responseXML.getElementsByTagName("resultcount")[0].firstChild.data);
			html += '<?php printf(addslashes($testman_langres["foundresults"]), "<span id=\"resultcount\">' + ResultCount + '<\/span>"); ?>';
		}
		else
		{
			html += document.getElementById("infobox").innerHTML;
		}
		
		html += '<\/td>';
		
		html += '<td id="status">';
		html += '<?php printf(addslashes($testman_langres["status"]), '<span id="selectedresultcount">0<\/span>'); ?>';
		html += '<\/td>';
		
		// Page number boxes
		html += '<td id="pagesbox">';
		
		if(CurrentPage == 1)
		{
			html += '&laquo; ';
			html += '&lsaquo; <?php echo addslashes($shared_langres["prevpage"]); ?> ';
		}
		else
		{
			html += '<a href="javascript:FirstPage_OnClick()" title="<?php echo addslashes($shared_langres["firstpage_title"]); ?>">&laquo;<\/a> ';
			html += '<a href="javascript:PrevPage_OnClick()" title="<?php echo addslashes($shared_langres["prevpage_title"]); ?>">&lsaquo; <?php echo addslashes($shared_langres["prevpage"]); ?><\/a> ';
		}
		
		html += '<select id="pagesel" size="1" onchange="PageBox_OnChange(this)">';
		
		if(data["requesttype"] == REQUESTTYPE_FULLLOAD)
		{
			PageCount = 1;
			
			html += '<option value="' + CurrentPage + '-' + HttpRequest.responseXML.getElementsByTagName("firstid")[0].firstChild.data + '"><?php echo addslashes($shared_langres["page"]); ?> ' + CurrentPage;
			
			if(HttpRequest.responseXML.getElementsByTagName("resultcount")[0].firstChild.data > 0)
				html += ' - ' + HttpRequest.responseXML.getElementsByTagName("firstrev")[0].firstChild.data + ' ... ' + HttpRequest.responseXML.getElementsByTagName("lastrev")[0].firstChild.data + '<\/option>';
		}
		else
		{
			html += document.getElementById("pagesel").innerHTML;
		}
		
		html += '<\/select> ';
		
		if(HttpRequest.responseXML.getElementsByTagName("moreresults")[0].firstChild.data == 0)
		{
			html += '<?php echo addslashes($shared_langres["nextpage"]); ?> &rsaquo; ';
			html += '&raquo;';
		}
		else
		{
			html += '<a href="javascript:NextPage_OnClick()" title="<?php echo addslashes($shared_langres["nextpage_title"]); ?>"><?php echo addslashes($shared_langres["nextpage"]); ?> &rsaquo;<\/a> ';
			html += '<a href="javascript:LastPage_OnClick()" title="<?php echo addslashes($shared_langres["lastpage_title"]); ?>">&raquo;<\/a>';
		}
		
		html += '<\/td><\/tr><\/table>';

		// File table
		html += '<table id="resulttable" class="datatable" cellspacing="0" cellpadding="0">';
		
		html += '<thead><tr class="head">';
		html += '<th class="TestCheckbox"><\/th>';
		html += '<th><?php echo addslashes($testman_langres["revision"]); ?><\/th>';
		html += '<th><?php echo addslashes($testman_langres["date"]); ?><\/th>';
		html += '<th><?php echo addslashes($testman_langres["totaltests"]); ?><\/th>';
		html += '<th><?php echo addslashes($testman_langres["failedtests"]); ?><\/th>';
		html += '<th><?php echo addslashes($testman_langres["user"]); ?><\/th>';
		html += '<th><?php echo addslashes($testman_langres["platform"]); ?><\/th>';
		html += '<th><?php echo addslashes($testman_langres["comment"]); ?><\/th>';
		html += '<\/tr><\/thead>';
		html += '<tbody>';
		
		var results = HttpRequest.responseXML.getElementsByTagName("result");
	
		if(!results.length)
		{
			html += '<tr class="even"><td colspan="8"><?php echo addslashes($testman_langres["noresults"]); ?><\/td><\/tr>';
		}
		else
		{
			var oddeven = false;
			
			for(var i = 0; i < results.length; i++)
			{
				html += '<tr class="' + (oddeven ? "odd" : "even") + '" onmouseover="Result_OnMouseOver(this)" onmouseout="Result_OnMouseOut(this)">';
				html += '<td><input onclick="ResultCheckbox_OnClick(this)" type="checkbox" id="test_' + GetTagData(results[i], "id") + '" \/><\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "revision") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "date") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "count") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "failures") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "user") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "platform") + '<\/td>';
				html += '<td onclick="ResultCell_OnClick(this)">' + GetTagData(results[i], "comment") + '<\/td>';
				html += '<\/tr>';

				oddeven = !oddeven;
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
		ResultCount += parseInt(HttpRequest.responseXML.getElementsByTagName("resultcount")[0].firstChild.data);
		
		document.getElementById("resultcount").firstChild.data = ResultCount;
		
		// As always, we have to work around an IE bug
		// If I use "innerHTML" here, the first <OPTION> start tag gets dropped in the IE...
		// Therefore I have to use the DOM functions in this case.
		var OptionElem = document.createElement("option");
		var OptionText = document.createTextNode('<?php echo addslashes($shared_langres["page"]); ?> ' + PageCount + ' - ' + HttpRequest.responseXML.getElementsByTagName("firstrev")[0].firstChild.data + ' ... ' + HttpRequest.responseXML.getElementsByTagName("lastrev")[0].firstChild.data);
		
		OptionElem.value = PageCount + "-" + HttpRequest.responseXML.getElementsByTagName("firstid")[0].firstChild.data;
		OptionElem.appendChild(OptionText);
		
		document.getElementById("pagesel").appendChild(OptionElem);
	}
	
	if(HttpRequest.responseXML.getElementsByTagName("moreresults")[0].firstChild.data == 1 && (data["requesttype"] == REQUESTTYPE_FULLLOAD || data["requesttype"] == REQUESTTYPE_ADDPAGE))
	{
		// There are more results available in the full range. Therefore we have to start another request and add a new page.
		data["resultlist"] = 0;
		data["startid"] = HttpRequest.responseXML.getElementsByTagName("nextid")[0].firstChild.data;
		data["requesttype"] = REQUESTTYPE_ADDPAGE;
		SearchCall();
		return;
	}
	
	document.getElementById("ajax_loading_search").style.visibility = "hidden";
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
	
	for(i = 0; i < ResultArray.length; i++)
	{
		if(!i)
		{
			parameters += ResultArray[i];
			continue;
		}
		
		parameters += "," + ResultArray[i];
	}
	
	if(document.getElementById("opennewwindow").checked || DetectObsoleteIE())
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
	
	if(trs[0].firstChild.firstChild.nodeName != "INPUT")
		return;
	
	// Get the IDs through the "id" attribute of the checkboxes
	IDArray = new Array();
	IDArray.push(parseInt(trs[0].firstChild.firstChild.id.substr(5)));
	
	if(trs[1])
		IDArray.push(parseInt(trs[1].firstChild.firstChild.id.substr(5)));
	
	OpenComparePage(IDArray);
}

function PageSwitch(NewPage, StartID)
{
	CurrentPage = NewPage;
	data["resultlist"] = 1;
	data["startid"] = StartID;
	data["requesttype"] = REQUESTTYPE_PAGESWITCH;
	
	SearchCall();
}

function FirstPage_OnClick()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[0].value.split("-");
	PageSwitch(info[0], info[1]);
}

function PrevPage_OnClick()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage - 2].value.split("-");
	PageSwitch(info[0], info[1]);
}

function PageBox_OnChange(elem)
{
	var info = elem.value.split("-");
	PageSwitch(info[0], info[1]);
}

function NextPage_OnClick()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage].value.split("-");
	PageSwitch(info[0], info[1]);
}

function LastPage_OnClick()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[ document.getElementById("pagesel").getElementsByTagName("option").length - 1 ].value.split("-");
	PageSwitch(info[0], info[1]);
}

function NumericComparison(a, b)
{
	return a - b;
}

function CompareSelectedButton_OnClick()
{
	var IDArray = new Array();
	
	// Sort the selected IDs
	for(id in SelectedResults)
		IDArray.push(parseInt(id));
	
	if(!IDArray.length)
	{
		alert("<?php echo addslashes($testman_langres["noselection"]); ?>");
		return;
	}
	else if(IDArray.length < 2)
	{
		alert("<?php printf(addslashes($testman_langres["selectatleast"]), 2); ?>");
		return;
	}
	
	OpenComparePage(IDArray);
}

function OpenNewWindowCheckbox_OnClick(checkbox)
{
	document.cookie = "opennewwindow=" + (checkbox.checked ? "1" : "0");
	document.getElementById("comparepage_frame").style.display = "none";
}
