<?php
	require("common.php");
	header("HTTP/1.0 404 Not Found");
	bsod(404, "PAGE_FAULT_IN_NONPAGED_AREA");
