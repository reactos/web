/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Some easy-to-use AJAX functions
 * COPYRIGHT:   Copyright 2008-2017 Colin Finck (colin@reactos.org)
 */

function PrepareParameters(data)
{
	var parameters = "";

	for (var elem in data)
		parameters += elem + "=" + encodeURIComponent(data[elem]) + "&";

	return parameters;
}

function AjaxGet(url, callback, data)
{
	var HttpRequest = new XMLHttpRequest();
	if (!HttpRequest)
	{
		alert("Cannot create an XMLHTTP instance");
		return false;
	}

	var parameters = PrepareParameters(data);

	HttpRequest.open("GET", url + "?" + parameters, true);
	HttpRequest.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");     // Bypass the IE Cache
	HttpRequest.send(null);

	HttpRequest.onreadystatechange = function()
	{
		// Check for a HTTP error
		if(HttpRequest.readyState == 4)
		{
			if(HttpRequest.status == 200)
				eval(callback + "(HttpRequest, data)");
			else if(HttpRequest.status != 0)
				alert("AJAX Request problem!" + "\n\nError Code: " + HttpRequest.status + "\nError Text: " + HttpRequest.statusText + "\nURL: " + url);
		}
	}
}
