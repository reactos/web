/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    JavaScript file for the Compare Page (parsed by PHP before)
  COPYRIGHT:  Copyright 2008-2009 Colin Finck <colin@reactos.org>
*/

var CurrentLeftDragBorder;
var CurrentRightDragBorder;
var DragColumn;
var DragX;
var DragOffset;
var MaxLeftDragBorder;
var MaxRightDragBorder;
var MouseX;
var MouseY;
var OverlappedForSwap;
var SwapColumn;
var TableRowEquiv;
var TempBlock;

var ColumnDefaultColor = "#5984C3";
var ColumnDragColor = "#8AA9D5";
var ColumnOverlapColor = "#D0DDEE";

function Cell_OnMouseOver(elem)
{
	elem.style.background = "#FFFFCC";
}

function Cell_OnMouseOut(elem)
{
	if(elem.parentNode.className == "odd")
		elem.style.background = "#F5F5F5";
	else if(elem.parentNode.className == "even")
		elem.style.background = "#FFFFFF";
	else
	    elem.style.background = "#000000";
}

function GetColumnIndex(th)
{
	var childs = th.parentNode.childNodes;
	
	for(var i = 0; i < childs.length; i++)
		if(childs[i] == th)
			return i;
}

function ProcessFilters()
{
	// Filter the results
	var filters = document.getElementsByName("filter");
	var increment = 1 + filters.length;
	var i;
	
	for(i = 0; i < FilterableRows.length; i += increment)
	{
		var value = TableRowEquiv;
		
		for(var j = 0; j < filters.length; ++j)
		{
			/* FilterableRows is an array holding the (virtual) structure:
			   
			   SuiteID,
			   Value of Filter 1,
			   Value of Filter 2,
			   ...
			   
			   If the value of a filter is true and the corresponding filter is activated, the result is
			   filtered.
			*/
			if(filters[j].checked && FilterableRows[i + 1 + j])
			{
				value = "none";
				break;
			}
		}
		
		document.getElementById("suite_" + FilterableRows[i]).style.display = value;
	}
	
	// Update the cookies for the filters
	for(i = 0; i < filters.length; ++i)
		document.cookie = "filter" + String(i) + "=" + (filters[i].checked ? "1" : "0");
	
	// Report the size change to the parent window if "Open in new window" was disabled
	if(parent.ResizeIFrame)
		parent.ResizeIFrame();
}

function HealthIndicator_OnMouseOver()
{
	document.getElementById("healthindicator_tooltip").style.display = "block";
}

function HealthIndicator_OnMouseOut()
{
	document.getElementById("healthindicator_tooltip").style.display = "none";
}

function AddDifferenceForColumn(th)
{
	var Index = GetColumnIndex(th);
	
	// Iterate through all result rows
	var trs = document.getElementById("comparetable").childNodes[1].childNodes;
	
	for(var i = 0; i < trs.length; ++i)
	{
		// Ignore empty rows (like separator rows)
		if(trs[i].childNodes.length)
		{
			// Iterate through all result values of this cell (enclosed in <div> elements)
			var divs = trs[i].childNodes[Index].getElementsByTagName("div");
			
			for(var j = 0; j < divs.length; ++j)
			{
				// If this is a comparable result value (and not e.g. the health indicator), the first subelement
				// has to be a #text element containing the result value.
				var valueElement = divs[j].firstChild;
				
				if(valueElement.nodeName == "#text")
				{
					// \u00A0 = &nbsp;
					var DiffString = "\u00A0";
					
					// Check if there is a previous value to compare with
					var PreviousDivs = trs[i].childNodes[Index - 1].getElementsByTagName("div");
					
					if(Index >= 2 && PreviousDivs.length)
					{
						// Calculate the difference between this value and the previous value.
						// Non-numeric values (like "CRASH") are interpreted as zeros.
						var CurrentValue = (isNaN(valueElement.data) ? 0 : parseInt(valueElement.data));
						var PreviousValue = (isNaN(PreviousDivs[j].firstChild.data) ? 0 : parseInt(PreviousDivs[j].firstChild.data));
						var Diff = CurrentValue - PreviousValue;
						var PercentStr = "";
						
						if(valueElement.parentNode.className == "box performancetests" && PreviousValue != 0)
						{
						    var Percent = Math.round(1000 * Diff / PreviousValue) / 10;
						    PercentStr = " | " + ((Diff > 0) ? "+" : "") + Percent + "%";
						}
						
						if(Diff > 0)
							DiffString = String("(+" + Diff + PercentStr + ")");
						else if(Diff < 0)
							DiffString = String("(" + Diff + PercentStr + ")");
				
					}
					
					// As this is a comparable result value, the next sibling of the #text element has to be a
					// <span> element, which will contain the difference value.
					valueElement.nextSibling.firstChild.data = DiffString;
				}
			}
		}
	}
}

function GetAbsoluteOffsetLeft(elem)
{
	var left = 0;
	
	while(elem)
	{
		left += elem.offsetLeft;
		elem = elem.offsetParent;
	}
	
	return left;
}

function GetAbsoluteOffsetTop(elem)
{
	var top = 0;
	
	while(elem)
	{
		top += elem.offsetTop;
		elem = elem.offsetParent;
	}
	
	return top;
}

function DragCurrentColumn()
{
	// Drag if there's something to do
	if(!DragColumn)
		return;

	var PosX = MouseX - DragOffset;
	
	// Check whether the user is allowed to move anything to the current mouse position
	if(PosX < CurrentLeftDragBorder || PosX > CurrentRightDragBorder)
		return;
	
	// Check whether the user is moving to left or right
	if(MouseX - DragX > 0)
		var NewSwapColumn = DragColumn.nextSibling;
	else if(MouseX - DragX < 0)
		var NewSwapColumn = DragColumn.previousSibling;
	
	// If we have any other swap column, reset it to the default color
	if(SwapColumn && NewSwapColumn != SwapColumn)
		SwapColumn.style.background = ColumnDefaultColor;
	
	SwapColumn = NewSwapColumn;
	
	if(!SwapColumn)
		return;
	
	SwapColumn.style.background = ColumnDragColor;
	
	if(!TempBlock)
	{
		// The only way we can "move the column header" flawlessy and compatible with all major browsers is emulating the behaviour :-)
		// Therefore we create a <div> element for moving and set the column header to move invisible
		TempBlock = document.createElement("div");
		
		for(var i = 0; i < DragColumn.childNodes.length; i++)
			TempBlock.appendChild(DragColumn.childNodes[i].cloneNode(true));
		
		TempBlock.id = "TempBlock";
		TempBlock.style.top = GetAbsoluteOffsetTop(DragColumn) + "px";
		
		document.body.insertBefore(TempBlock, document.getElementById("comparetable"));
		DragColumn.style.visibility = "hidden";
	}
	
	// Move the block
	TempBlock.style.left = PosX + "px";
	
	var TempOffsetLeft = GetAbsoluteOffsetLeft(TempBlock);
	var SwapOffsetLeft = GetAbsoluteOffsetLeft(SwapColumn);

	// Check if the dragged column overlaps the swap column by at least the half
	OverlappedForSwap = (NewSwapColumn == DragColumn.nextSibling)
		? (TempOffsetLeft + TempBlock.offsetWidth > SwapOffsetLeft + SwapColumn.offsetWidth / 2)
		: (TempOffsetLeft < SwapOffsetLeft + SwapColumn.offsetWidth / 2);

	// Set the swap column to the overlap color in this case
	if(OverlappedForSwap)
		SwapColumn.style.background = ColumnOverlapColor;
}

function MoveHealthIndicatorTooltip()
{
	var tooltip = document.getElementById("healthindicator_tooltip");
	
	tooltip.style.left = String(MouseX + 10) + "px";
	tooltip.style.top = String(MouseY + 10) + "px";
}

function Document_OnMouseMove(event)
{
	// IE stores the event in window.event...
	if(!event)
		event = window.event;
	
	MouseX = event.clientX;
	MouseY = event.clientY;
	
	DragCurrentColumn();
	MoveHealthIndicatorTooltip();
}

function SwapElements(elem1, elem2)
{
	// outerHTML is too unsupported, so we have to copy all column's attributes one after another
	var TempClass = elem1.className;
	var TempHTML = elem1.innerHTML;
	var TempOnClick = elem1.onclick;
	var TempOnMouseOver = elem1.onmouseover;
	var TempOnMouseOut = elem1.onmouseout;
	
	elem1.className = elem2.className;
	elem1.innerHTML = elem2.innerHTML;
	elem1.onclick = elem2.onclick;
	elem1.onmouseover = elem2.onmouseover;
	elem1.onmouseout = elem2.onmouseout;
	
	elem2.className = TempClass;
	elem2.innerHTML = TempHTML;
	elem2.onclick = TempOnClick;
	elem2.onmouseover = TempOnMouseOver;
	elem2.onmouseout = TempOnMouseOut;
}

function Document_OnMouseUp()
{
	if(!DragColumn)
		return;
	
	// This marks the end of a Drag & Drop operation
	if(SwapColumn)
	{
		if(OverlappedForSwap)
		{
			// Swap the column headers
			SwapElements(DragColumn, SwapColumn);
			
			// Swap all cells of these columns
			var DragColumnIndex = GetColumnIndex(DragColumn);
			var SwapColumnIndex = GetColumnIndex(SwapColumn);
			var tbody_trs = document.getElementById("comparetable").childNodes[1].childNodes;
			
			for(var i = 0; i < tbody_trs.length; i++)
				if(tbody_trs[i].childNodes.length)
					SwapElements(tbody_trs[i].childNodes[DragColumnIndex], tbody_trs[i].childNodes[SwapColumnIndex]);
			
			AddDifferenceForColumn(DragColumn);
			AddDifferenceForColumn(SwapColumn);
			
			if(DragColumnIndex > SwapColumnIndex)
				var NextColumn = DragColumn.nextSibling;
			else
				var NextColumn = SwapColumn.nextSibling;
			
			if(NextColumn)
				AddDifferenceForColumn(NextColumn);
		}
		
		// Reset everything
		DragColumn.style.visibility = "visible";
		document.body.removeChild(TempBlock);
		SwapColumn.style.background = ColumnDefaultColor;
	}
	
	// Cleanup
	DragColumn = null;
	SwapColumn = null;
	TempBlock = null;
}

function ResultHead_OnMouseDown(th)
{
	DragColumn = th;
	DragX = MouseX;
	DragOffset = DragX - GetAbsoluteOffsetLeft(th);
	
	// The drag borders are set to the previous and next "real" columns
	// If there are no more "real" columns, they are set to the maximum borders
	CurrentLeftDragBorder = Math.max(GetAbsoluteOffsetLeft(th.previousSibling), MaxLeftDragBorder);
	
	if(th.nextSibling)
		CurrentRightDragBorder = Math.min(GetAbsoluteOffsetLeft(th.nextSibling), MaxRightDragBorder);
	else
		CurrentRightDragBorder = MaxRightDragBorder;
}

function Load()
{
	// Prepare the Drag & Drop feature
	document.onmousemove = Document_OnMouseMove;
	document.onmouseup = Document_OnMouseUp;
	
	var ths = document.getElementById("comparetable").firstChild.firstChild.childNodes;
	MaxLeftDragBorder = GetAbsoluteOffsetLeft(ths[1]);
	MaxRightDragBorder = GetAbsoluteOffsetLeft(ths[ths.length - 1]);
	
	// As always, IE needs a special handling (this time for the style of table rows)
	if((navigator.appName == "Microsoft Internet Explorer") && (parseFloat(navigator.appVersion.split("MSIE")[1])) < 10)
		TableRowEquiv = "block";
	else
		TableRowEquiv = "table-row";
	
	// Get the filter values from the cookies, apply them and associate the click handler
	var filters = document.getElementsByName("filter");
	
	for(var i = 0; i < filters.length; ++i)
	{
		filters[i].checked = parseInt(GetCookieValue("filter" + String(i)));
		filters[i].onclick = ProcessFilters;
	}
	
	ProcessFilters();
}

function Result_OnClick(id, prev_id)
{
	window.open("detail.php?id=" + id + "&prev=" + prev_id);
}
