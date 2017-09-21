<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Easily download prebuilt ReactOS Revisions
 * COPYRIGHT:   Copyright 2007-2017 Colin Finck (colin@reactos.org)
 */

	// This self-contained provider script has to be uploaded to the server, which contains the ISO files.
	// Therefore it has an own configuration and doesn't use "config.inc.php".

	// Configuration
	define(ROOT_DIR, "../");
	$DIRECTORIES = array("bootcd", "livecd");
	$ISO_EXTENSION = ".7z";
	$ISO_PATTERN = "#[0-9a-z-]#";

	// This must be the actual length of the hash in the filenames!
	$SHORT_HASH_LENGTH = 7;

	// The following values need to be set here and in "config.inc.php"!
	$MAX_FILES_PER_PAGE = 100;
	$REV_RANGE_LIMIT = 3000;

	// Exceptions
	class ErrorMessageException extends Exception
	{
	}

	// Functions
	function fsize_str($size)
	{
		if($size > 1000000)
		{
			$size = $size / 1048576;
			$unit = " MB";
		}
		else if($size > 1000)
		{
			$size = $size / 1024;
			$unit = " KB";
		}
		else
		{
			$unit = " Bytes";
		}

		return number_format($size, 2, ".", ",") . $unit;
	}


	// Entry point
	header("Content-type: text/xml");

	try
	{
		// Check the parameters.
		if (!array_key_exists("prefixes", $_POST) || !array_key_exists("suffixes", $_POST))
			throw new ErrorMessageException("No prefixes and suffixes");

		$prefixes = preg_split("#,#", $_POST["prefixes"], NULL, PREG_SPLIT_NO_EMPTY);
		foreach ($prefixes as $p)
			if (!preg_match($ISO_PATTERN, $p))
				throw new RuntimeException("Invalid prefix");

		$suffixes = preg_split("#,#", $_POST["suffixes"], NULL, PREG_SPLIT_NO_EMPTY);
		foreach ($suffixes as $s)
			if (!preg_match($ISO_PATTERN, $s))
				throw new RuntimeException("Invalid suffix");

		$get_filelist = (array_key_exists("filelist", $_POST) && $_POST["filelist"]);

		// We want to read all matching files into a two-dimensional associative array of the format:
		//    $files[$revision][] = "$d/$filename"
		$files = array();
		$filecount = 0;

		if (array_key_exists("startrev", $_POST) && array_key_exists("endrev", $_POST))
		{
			// The user wants to find old SVN builds.
			$startrev = (int)$_POST["startrev"];
			$endrev = (int)$_POST["endrev"];
			if ($endrev - $startrev + 1 > $REV_RANGE_LIMIT)
				throw new RuntimeException("Range exceeds limit");

			// Enforce the order of the $files array by adding all revisions in order.
			for ($i = $startrev; $i <= $endrev; $i++)
				$files["$i"] = array();

			// We never had builds < r10000 and never reached > r99999...
			$revision_pattern = "-([0-9]{5})";
		}
		else if (array_key_exists("range", $_POST))
		{
			// The user wants to find GIT builds.
			$range = preg_split("#,#", $_POST["range"], NULL, PREG_SPLIT_NO_EMPTY);
			if (count($range) > $REV_RANGE_LIMIT)
				throw new RuntimeException("Range exceeds limit");

			// Enforce the order of the $files array by adding all revisions in order.
			foreach ($range as $r)
				$files["$r"] = array();

			// "git describe" puts a "g" in front of the actual hash.
			$revision_pattern = "-g([0-9a-f]{$SHORT_HASH_LENGTH})";
		}
		else
		{
			throw new RuntimeException("No startrev/endrev or range");
		}

		// Read all matching files into a two-dimensional associative array of the format:
		//    $files[$revision][] = "$d/$filename"
		//
		// This way, we can easily first sort by revision and then by filename.
		foreach ($DIRECTORIES as $d)
		{
			$dir = opendir(ROOT_DIR . $d);
			if (!$dir)
				throw new RuntimeException("opendir failed");

			while (($filename = readdir($dir)) !== FALSE)
			{
				// Does this entry match any of the prefixes?
				$match = FALSE;
				foreach ($prefixes as $p)
				{
					if (substr($filename, 0, strlen($p)) === $p)
					{
						$match = TRUE;
						break;
					}
				}

				if (!$match)
					continue;

				// Does this entry match any of the suffixes?
				$match = FALSE;
				foreach ($suffixes as $s)
				{
					if (preg_match('#' . $revision_pattern . $s . $ISO_EXTENSION . '$#', $filename, $matches))
					{
						$match = TRUE;
						break;
					}
				}

				if (!$match)
					continue;

				// Good, so are we looking for this revision?
				if (array_key_exists($matches[1], $files))
				{
					// Add it to the $files array.
					$files[ $matches[1] ][] = "$d/$filename";
					$filecount++;
				}
			}

			closedir($dir);
		}

		// Output the file information.
		$output  = "<fileinformation>";
		$output .= "<filecount>$filecount</filecount>";

		if ($filecount)
		{
			// Now use $filecount to count the files of this page.
			$filecount = 0;
			foreach ($files as $revision => $filenames)
			{
				sort($filenames);

				foreach ($filenames as $filename)
				{
					if ($get_filelist)
					{
						$output .= "<file>";
						$output .= "<name>" . basename($filename) . "</name>";
						$output .= "<dir>" . dirname($filename) . "</dir>";
						$output .= "<size>" . fsize_str(filesize(ROOT_DIR . $filename)) . "</size>";
						$output .= "<date>" . date("Y-m-d H:i", filemtime(ROOT_DIR . $filename)) . "</date>";
						$output .= "</file>";
					}

					if (!isset($firstrev))
						$firstrev = $revision;

					$filecount++;
					if ($filecount == $MAX_FILES_PER_PAGE)
						break;
				}

				if ($filecount == $MAX_FILES_PER_PAGE)
					break;
			}

			$output .= "<firstrev>$firstrev</firstrev>";
			$output .= "<lastrev>$revision</lastrev>";
		}

		$output .= "</fileinformation>";
		die($output);
	}
	catch (ErrorMessageException $e)
	{
		die("<error>" . $e->getMessage() . "</error>");
	}
	catch (Exception $e)
	{
		die("<error>" . $e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage() . "</error>");
	}
