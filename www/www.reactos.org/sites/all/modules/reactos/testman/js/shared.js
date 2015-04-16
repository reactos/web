/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Shared JavaScript functions
  COPYRIGHT:  Copyright 2009 Colin Finck <colin@reactos.org>

  charset=utf-8
*/

function GetCookieValue(cookie)
{
	var cookies = document.cookie.split("; ");
	
	for(var i = 0; i < cookies.length; i++)
	{
		var data = cookies[i].split("=");
		
		if(data[0] == cookie)
			return data[1];
	}
	
	return null;
}
