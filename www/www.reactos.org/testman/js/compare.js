/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    JavaScript file for the Compare Page (parsed by PHP before)
  COPYRIGHT:  Copyright 2008-2016 Colin Finck <colin@reactos.org>
*/

var MouseX;
var MouseY;

function ProcessFilters()
{
	// Filter the results
	var filters = document.getElementsByName("filter");
	var increment = 1 + filters.length;
	var i;
	
	for(i = 0; i < FilterableRows.length; i += increment)
	{
		var value = "table-row";
		
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
	
	MoveHealthIndicatorTooltip();
}

function Load()
{
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
