<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Configuration Settings for the JSON API
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	define("ROOT_PATH", "../../");

	// Rows per page. Every query fetches one row more than this to find out whether a
	// further page exists, which is what replaces the COUNT(*) of ajax-search.php.
	define("API_PAGE_SIZE", 50);
	define("API_MAX_PAGE_SIZE", 200);
