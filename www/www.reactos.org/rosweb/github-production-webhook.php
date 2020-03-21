<?php
/*
 * PROJECT:     ReactOS Website
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Validates a GitHub webhook request and spawns a subprocess to handle it asynchronously.
 * COPYRIGHT:   Copyright 2017-2020 Colin Finck (colin@reactos.org)
 */

    define("ROOT_PATH", "../");
    require_once(ROOT_PATH . "../www.reactos.org_config/github-production-webhook-config.php");

    // This script should only be activated on the production web server.
    if (!defined("WEBHOOK_ENABLED") || !WEBHOOK_ENABLED)
        die("Disabled");

	// This must be run exclusively with HTTPS security enabled!
	if (!array_key_exists("HTTPS", $_SERVER) || $_SERVER["HTTPS"] != "on")
		die("TLS required");

	// Verify the signature format.
	if (!array_key_exists("HTTP_X_HUB_SIGNATURE", $_SERVER) || substr($_SERVER["HTTP_X_HUB_SIGNATURE"], 0, 5) != "sha1=")
		die("Wrong signature format");

	// Verify the signature itself.
	$http_signature = substr($_SERVER["HTTP_X_HUB_SIGNATURE"], 5);

	$post_data = file_get_contents("php://input");
	$valid_signature = hash_hmac("sha1", $post_data, GITHUB_SECRET);

	if (!hash_equals($valid_signature, $http_signature))
		die("Invalid signature");

	// Verify the event.
	if (!array_key_exists("HTTP_X_GITHUB_EVENT", $_SERVER))
		die("No event");

	$event = $_SERVER["HTTP_X_GITHUB_EVENT"];

	// Check the event.
	if ($event == "ping")
	{
		// ping is for testing and we only want to return a pong here.
		die("pong");
	}
	else if ($event == "push")
	{
		// Parse the JSON payload.
		$payload = json_decode($_POST["payload"]);
		if ($payload === NULL)
			die("Invalid payload");

		// Verify the supplied repository name.
        $repo = $payload->repository->name;
        if ($repo != "web-content")
            die("Invalid repo");

        // Verify that this is a push to the "production" branch.
        $ref = $payload->ref;
        if ($ref != "refs/heads/production")
            die("This is no push to production");
        
        // Spawn the worker process.
        shell_exec(__DIR__ . "/github-production-webhook-worker.sh 1> /var/log/github-production-webhook-worker.log 2>&1 &");
		die("Spawned subprocess");
	}
	else
	{
		die("Wrong event");
	}
