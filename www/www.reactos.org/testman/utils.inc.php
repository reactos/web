<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Utility functions shared among several PHP files
  COPYRIGHT:  Copyright 2008-2015 Colin Finck <colin@reactos.org>
*/

	function GetPlatformString($platform)
	{
		// First get the main operating system
		if(substr($platform, 0, 7) == "reactos")
		{
			$str = "ReactOS";
			$arch = (int)substr($platform, 8);
		}
		else
		{
			sscanf($platform, "%u.%u.%u.%u.%u.%c.%u", $major, $minor, $build, $sp_major, $sp_minor, $type, $arch);
			
			switch($major)
			{
				case 5:
					switch($minor)
					{
						case 0:
							$str = "Windows 2000";
							
							if($type == "s")
								$str .= " Server";
							
							break;
						
						case 1:
							$str = "Windows XP";
							break;
						
						case 2:
							if($type == "s")
								$str = "Windows Server 2003";
							else
								$str = "Windows XP";
							
							break;
						
						default:
							return $platform;
					}
					
					break;
				
				case 6:
					switch($minor)
					{
						case 0:
							if($type = "s")
								$str = "Windows Server 2008";
							else
								$str = "Windows Vista";
							
							break;
						
						case 1:
							$str = "Windows 7";
							break;
						
						default:
							return $platform;
					}
					
					break;
				
				default:
					return $platform;
			}
			
			$str .= " - Build " . $build;
			
			// Add the service pack information if we have any
			if($sp_major)
			{
				$str .= " SP" . $sp_major;
				
				if($sp_minor)
					$str .= "." . $sp_minor;
			}
		}
		
		// Now get the processor architecture
		// The values for $arch are Windows PROCESSOR_ARCHITECTURE_* constants
		$str .= " - ";
		
		switch($arch)
		{
			case 0: $str .= "i386"; break;
			case 9: $str .= "AMD64"; break;
			default: return $platform;
		}
		
		return $str;
	}
	
	function GetDateString($timestamp)
	{
		return date("Y-m-d H:i", $timestamp);
	}
	
	function GetTotalTestsString($row)
	{
		if($row["status"] != "ok")
			return strtoupper($row["status"]);
		
		return $row["count"];
	}
	
	function GetDifference(&$current_row, &$prev_row, $subject, $percent = false)
	{
		// Return &nbsp; ("" is not possible because of IE...) if
		//  - we have no previous array to compare with
		//  - we have both arrays, but not the values for both of them
		//  - both values are identical

		$percent_diff = NULL;

		if(!$prev_row ||
		   $current_row[$subject] === null ||
		   $prev_row[$subject] === null ||
		   $current_row[$subject] == $prev_row[$subject])
		{
			return "&nbsp;";
		}

		$diff = $current_row[$subject] - $prev_row[$subject];

		if($percent && $prev_row[$subject] != 0)
		{
			$percent_diff = 100 * $diff / $prev_row[$subject];
			$percent_diff = sprintf(" | %+.g%%", round($percent_diff,1));
		}

		return sprintf("(%+.".(is_float($diff)? '1' : '0')."f%s)", $diff, $percent_diff);
	}

	function CheckIfChanged(&$changed, &$temp, &$current)
	{
		if($changed)
			return;

		if($temp == -1)
			$temp = $current;
		else if($current != $temp)
			$changed = true;
	}

	function GetBlacklist()
	{
		$fp = @fopen(BLACKLIST_URL, "r");
		$blacklist = array();

		if($fp)
		{
	    		do
	    		{
				$line = trim(fgets($fp));

				if(preg_match("/^[a-z0-9_\-\.]*\:{1}[a-z0-9_\-\.]*$/i", $line) == 1)
		   			$blacklist[] = $line;

	    		}
			while(!feof($fp));
		}

		fclose($fp);
		return $blacklist;
	}
