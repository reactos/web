/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     JavaScript file for the Testman Compare Page
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 *              Copyright 2012 Kamil Hornicek (kamil.hornicek@reactos.org)
 */

var MouseX;
var MouseY;

function ProcessFilters()
{
	// Filter the results
	var filters = document.getElementsByName("filter");
	var increment = 1 + filters.length;

	for (var i = 0; i < FilterableRows.length; i += increment)
	{
		var value = "table-row";

		for (var j = 0; j < filters.length; ++j)
		{
			/* FilterableRows is an array holding the (virtual) structure:

			   SuiteID,
			   Value of Filter 1,
			   Value of Filter 2,
			   ...

			   If the value of a filter is true and the corresponding filter is activated, the result is
			   filtered.
			*/
			if (filters[j].checked && FilterableRows[i + 1 + j])
			{
				value = "none";
				break;
			}
		}

		document.getElementById("suite_" + FilterableRows[i]).style.display = value;
	}

	if (window.localStorage)
	{
		// Update the settings for the filters.
		for (var i = 0; i < filters.length; i++)
			window.localStorage.setItem("filter" + String(i), filters.checked ? "1" : "0");
	}

	// Report the size change to the parent window if "Open in new window" was disabled
	if (parent.ResizeIFrame)
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
	if (!event)
		event = window.event;

	MouseX = event.clientX;
	MouseY = event.clientY;

	MoveHealthIndicatorTooltip();
}

function Load()
{
	document.onmousemove = Document_OnMouseMove;

	// Get the filter values from the cookies, apply them and associate the click handler
	var filters = document.getElementsByName("filter");

	for (var i = 0; i < filters.length; i++)
	{
		filters[i].checked = (window.localStorage && parseInt(window.localStorage.getItem("filter" + String(i))));
		filters[i].onclick = ProcessFilters;
	}

	ProcessFilters();
}

function Result_OnClick(id, prev_id)
{
	window.open("detail.php?id=" + id + "&prev=" + prev_id);
}
