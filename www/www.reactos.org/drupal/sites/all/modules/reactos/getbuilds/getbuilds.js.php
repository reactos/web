<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
*/
?>

var data = new Array();

var CurrentPage;
var FileCount;
var FullRange;
var inputbox_startrev;
var inputbox_endrev;
var PageCount;

var REQUESTTYPE_FULLLOAD = 1;
var REQUESTTYPE_ADDPAGE = 2;
var REQUESTTYPE_PAGESWITCH = 3;

function SetLoading(value)
{
	document.getElementById("ajax_loading").style.visibility = (value ? "visible" : "hidden");
}

function AjaxCall()
{
	SetLoading(true);
	AjaxGet("/sites/all/modules/reactos/getbuilds/ajax-getfiles.php", "GetFilesCallback", data);
}

function GetFilesCallback(HttpRequest)
{
	// Check for an error
	if(HttpRequest.responseXML.getElementsByTagName("error").length > 0)
	{
		// For some errors, we show a localized error message
		if(HttpRequest.responseXML.getElementsByTagName("message")[0].firstChild.data == "LIMIT")
			alert('<?php printf(addslashes($getbuilds_langres["rangelimitexceeded"]), "' + HttpRequest.responseXML.getElementsByTagName(\"limit\")[0].firstChild.data + '"); ?>');
		else
			alert(HttpRequest.responseXML.getElementsByTagName("message")[0].firstChild.data);
		
		return;
	}
	
	var html = "";
	
	if(data["filelist"])
	{
		// Build a new infobox
		html += '<table id="infotable" cellspacing="0" cellpadding="0"><tr><td id="infobox">';
		
		if(data["requesttype"] == REQUESTTYPE_FULLLOAD)
		{
			FileCount = parseInt(HttpRequest.responseXML.getElementsByTagName("filecount")[0].firstChild.data);
			html += '<?php printf(addslashes($getbuilds_langres["foundfiles"]), "<span id=\"filecount\">' + FileCount + '<\/span>"); ?>';
		}
		else
		{
			html += document.getElementById("infobox").innerHTML;
		}
		
		html += '<\/td>';
		
		// Page number boxes
		html += '<td id="pagesbox">';
		
		html += '<a href="javacsript:void(0)" onclick="PrevRev();">&lsaquo;&nbsp;<?php echo addslashes($getbuilds_langres["prevrev"]); ?></a>';
		html += "&nbsp;&nbsp;&nbsp;";
		html += '<a href="javacsript:void(0)" onclick="NextRev();"><?php echo addslashes($getbuilds_langres["nextrev"]); ?>&nbsp;&rsaquo;</a>';
		html += '<\/td><\/tr><\/table>';

		// File table
		html += '<table class="datatable" cellspacing="0" cellpadding="0">';
		html += '<thead><tr class="head"><th class="fname"><?php echo addslashes($getbuilds_langres["filename"]); ?><\/th><th class="fsize"><?php echo addslashes($getbuilds_langres["filesize"]); ?><\/th><th class="fdate"><?php echo addslashes($getbuilds_langres["filedate"]); ?><\/th><\/tr><\/thead>';
		html += '<tbody>';
		
		var files = HttpRequest.responseXML.getElementsByTagName("file");
	
		if(!files.length)
		{
			html += '<tr class="even"><td><?php printf(addslashes($getbuilds_langres["nofiles"]), "' + FullRange + '"); ?><\/td><td>&nbsp;<\/td><td>&nbsp;<\/td><\/tr>';
		}
		else
		{
			var oddeven = false;
			
			for(var i = 0; i < files.length; i++)
			{
				var fname = files[i].getElementsByTagName("name")[0].firstChild.data;
				var fsize = files[i].getElementsByTagName("size")[0].firstChild.data;
				var fdate = files[i].getElementsByTagName("date")[0].firstChild.data;
				var flink = '<a href="<?php echo $ISO_DOWNLOAD_URL; ?>' + fname.substr(0, 6) + "/" + fname + '">';
				
				html += '<tr class="' + (oddeven ? "odd" : "even") + '" onmouseover="tr_mouseover(this);" onmouseout="tr_mouseout(this);">';
				html += '<td>' + flink + '<img src="/sites/all/modules/reactos/getbuilds/images/cd.png" alt=""> ' + fname + '<\/a><\/td>';
				html += '<td>' + flink + fsize + '<\/a><\/td>';
				html += '<td>' + flink + fdate + '<\/a><\/td>';
				html += '<\/tr>';
				
				oddeven = !oddeven;
			}
		}
		
		html += '<\/tbody><\/table>';
		
		document.getElementById("filetable").innerHTML = html;
		
		if(data["requesttype"] == REQUESTTYPE_PAGESWITCH)
		{
			// Switch the selected page in the Page ComboBox
			document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage - 1].selected = true;
		}
	}
	else
	{
		// Just add a new page to the Page combo box and the information for it
		PageCount++;
		FileCount += parseInt(HttpRequest.responseXML.getElementsByTagName("filecount")[0].firstChild.data);
		
		document.getElementById("filecount").firstChild.data = FileCount;
		
		// As always, we have to work around an IE bug
		// If I use "innerHTML" here, the first <OPTION> start tag gets dropped in the IE...
		// Therefore I have to use the DOM functions in this case.
		var OptionElem = document.createElement("option");
		var OptionText = document.createTextNode('<?php echo addslashes($shared_langres["page"]); ?> ' + PageCount + ' - ' + HttpRequest.responseXML.getElementsByTagName("firstrev")[0].firstChild.data + ' ... ' + HttpRequest.responseXML.getElementsByTagName("lastrev")[0].firstChild.data);
		
		OptionElem.value = PageCount + "-" + data["startrev"];
		OptionElem.appendChild(OptionText);
		
		document.getElementById("pagesel").appendChild(OptionElem);
	}
	
	if(HttpRequest.responseXML.getElementsByTagName("morefiles")[0].firstChild.data == 1 && (data["requesttype"] == REQUESTTYPE_FULLLOAD || data["requesttype"] == REQUESTTYPE_ADDPAGE))
	{
		// There are more files available in the full range. Therefore we have to start another request and add a new page
		data["filelist"] = 0;
		data["startrev"] = HttpRequest.responseXML.getElementsByTagName("lastrev")[0].firstChild.data;
		data["requesttype"] = REQUESTTYPE_ADDPAGE;
		AjaxCall();
		return;
	}
	
	SetLoading(false);
}

function SetRowColor(elem, color)
{
	tdl = elem.getElementsByTagName("td");
	
	for(var i = 0; i < tdl.length; i++)
		tdl[i].style.background = color;
}

function tr_mouseover(elem)
{
	SetRowColor(elem, "#FFFFCC");
}

function tr_mouseout(elem)
{
	if(elem.className == "odd")
		SetRowColor(elem, "#DDDDDD");
	else
		SetRowColor(elem, "#EEEEEE");
}

function GetRevNums()
{
	var rev = document.getElementById("revnum").value;
	
	if(isNaN(rev) || rev < 1)
	{
		// Maybe the user entered a revision range
		var hyphen = rev.indexOf("-");
		
		if(hyphen > 0)
		{
			inputbox_startrev = rev.substr(0, hyphen);
			inputbox_endrev = rev.substr(hyphen + 1);
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

function PrevRev()
{
	if(!GetRevNums())
		return;
		
	inputbox_startrev--;
	
	// 25700 is the lowest rev on the server at the time, when this script has been written
	// There is no harm if this rev does not exist anymore on the FTP server, it's just a min value
	if(inputbox_startrev < 25700)
		return;
	
	document.getElementById("revnum").value = inputbox_startrev;
	ShowRev();
}

function NextRev()
{
	if(!GetRevNums())
		return;
	
	inputbox_startrev++;
	document.getElementById("revnum").value = inputbox_startrev;
	ShowRev();
}

function ShowRev()
{
	if(!GetRevNums())
		return;
	
	CurrentPage = 1;
	FullRange = document.getElementById("revnum").value;
	
	data["bootcd-dbg"] = (document.getElementById("bootcd-dbg").checked ? 1 : 0);
	data["livecd-dbg"] = (document.getElementById("livecd-dbg").checked ? 1 : 0);
	data["bootcd-rel"] = (document.getElementById("bootcd-rel").checked ? 1 : 0);
	data["livecd-rel"] = (document.getElementById("livecd-rel").checked ? 1 : 0);
	
	data["filelist"] = 1;
	data["startrev"] = inputbox_startrev;
	data["endrev"] = inputbox_endrev;
	data["requesttype"] = REQUESTTYPE_FULLLOAD;
	
	AjaxCall();
}

function CheckForReturn(keyevent)
{
	// keyevent.which - supported under NS 4.0, Opera 5.12, Firefox, Konqueror 3.3, Safari
	// window.event - for IE Browsers
	if((keyevent && keyevent.which == 13) || (window.event && window.event.keyCode == 13))
		ShowRev();
}

function CheckRevNum(elem)
{
	var val = elem.value.replace(/[^[0-9-]/g, "");
	
	// First check if something was changed by the replace function.
	// If not, don't set elem.value = val. Otherwise the cursor would always jump to the last character in IE, when you press any key.
	if(elem.value != val)
		elem.value = val;
}

function Load()
{
	document.getElementById("revnum").onkeypress = CheckForReturn;
	
	// Show latest files
	CurrentPage = 1;
	FullRange = <?php echo $rev; ?>;
	
	data["filelist"] = 1;
	data["startrev"] = <?php echo $rev; ?>;
	data["endrev"] = <?php echo $rev; ?>;
	data["bootcd-dbg"] = 1;
	data["livecd-dbg"] = 1;
	data["bootcd-rel"] = 1;
	data["livecd-rel"] = 1;
	data["requesttype"] = REQUESTTYPE_FULLLOAD;
	
	AjaxCall();
}

function PageSwitch(new_page, new_startrev)
{
	CurrentPage = new_page;
	data["filelist"] = 1;
	data["startrev"] = new_startrev;
	data["requesttype"] = REQUESTTYPE_PAGESWITCH;
	
	AjaxCall();
}

function FirstPage()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[0].value.split("-");
	PageSwitch(info[0], info[1]);
}

function PrevPage()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage - 2].value.split("-");
	PageSwitch(info[0], info[1]);
}

function PageboxChange(obj)
{
	var info = obj.value.split("-");
	PageSwitch(info[0], info[1]);
}

function NextPage()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[CurrentPage].value.split("-");
	PageSwitch(info[0], info[1]);
}

function LastPage()
{
	var info = document.getElementById("pagesel").getElementsByTagName("option")[ document.getElementById("pagesel").getElementsByTagName("option").length - 1 ].value.split("-");
	PageSwitch(info[0], info[1]);
}
