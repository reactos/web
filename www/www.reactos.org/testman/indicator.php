<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Health Indicator image for a single test run
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("autoload.inc.php");

	try
	{
		if (!array_key_exists("id", $_GET))
			throw new RuntimeException("Necessary information not specified");

		$indicator = new Indicator((int)$_GET["id"]);
		$png = $indicator->render();

		header("Content-Type: image/png");

		// A finished run never changes again, so the browser keeps the image instead of
		// the web server keeping one file per run forever.
		if ($indicator->isFinished())
			header("Cache-Control: public, max-age=31536000, immutable");
		else
			header("Cache-Control: no-store");

		echo $png;
	}
	catch (Exception $e)
	{
		http_response_code(400);
		header("Content-Type: text/plain");
		echo $e->getMessage();
	}
