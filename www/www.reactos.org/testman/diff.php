<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Log Diff Viewer
 * COPYRIGHT:   Copyright 2012 Kamil Hornicek (kamil.hornicek@reactos.org)
 *              Copyright 2017 Colin Finck (colin@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("lib/text_diff/Diff.php");
	require_once("lib/text_diff/Diff/Renderer/Html/SideBySide.php");
	require_once("lib/text_diff/Diff/Renderer/Html/Inline.php");
	require_once(ROOT_PATH . "rosweb/exceptions.php");

	// Functions
	function GetRevision($test_id)
	{
		global $dbh;

		$stmt = $dbh->prepare(
			"SELECT runs.revision, results.suite_id, suites.module, suites.test FROM winetest_results results
			JOIN winetest_runs runs ON runs.id = results.test_id
			JOIN winetest_suites suites ON suites.id = results.suite_id WHERE results.id = :id LIMIT 1"
		);
		$stmt->bindParam(":id", $test_id);
		$stmt->execute();
		if (!$stmt->rowCount())
			throw new RuntimeException("Got no revision info");

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return array($result["revision"], $result["module"], $result["test"], $result["suite_id"]);
	}
    
	function GetLog($test_id, $strip, $test)
	{
		global $dbh;

		$stmt = $dbh->prepare("SELECT UNCOMPRESS(log) log FROM winetest_logs WHERE id = :id LIMIT 1");
		$stmt->bindParam(":id", $test_id);
		$stmt->execute();
		if (!$stmt->rowCount())
			throw new RuntimeException("Got no log");

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$result = explode("\n", $result["log"]);

		if ($strip)
		{
			$stripped = array();

			foreach ($result as &$value)
			{
				if ($value && ($value[0] == "(" || strncmp($test, $value, strlen($test)) != 0))
					continue;

				$stripped[] = $value;
			}
		
			return $stripped;
		}
		else
		{
			return $result;
		}
	}

	// Entry point
	try
	{
		// Check the parameters.
		if (!array_key_exists("id1", $_GET) || !array_key_exists("id2", $_GET) || !array_key_exists("type", $_GET) || !array_key_exists("strip", $_GET))
			throw new ErrorMessageException("Necessary information not specified!");

		$id1 = $_GET["id1"];
		$id2 = $_GET["id2"];
		$type = $_GET["type"];
		$strip = $_GET["strip"];

		// Connect to the database.
		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$suite_info[] = GetRevision($id1);
		$suite_info[] = GetRevision($id2);

		if ($suite_info[0][3] != $suite_info[1][3])
			throw new RuntimeException("Not the same suite.");

		$title = array();
		$title[] = array($suite_info[0][0], $suite_info[0][1] . ':' . $suite_info[0][2]);
		$title[] = array($suite_info[1][0], $suite_info[0][1] . ':' . $suite_info[0][2]);

		$options = array('ignoreWhitespace' => true, 'ignoreCase' => true);
		$diff = new Diff(GetLog($id1, $strip, $suite_info[0][2]), GetLog($id2, $strip, $suite_info[0][2]), $options);

		if ($type == 1)
			$renderer = new Diff_Renderer_Html_SideBySide;
		else
			$renderer = new Diff_Renderer_Html_Inline;
	}
	catch (ErrorMessageException $e)
	{
		die($e->getMessage());
	}
	catch (Exception $e)
	{
		die($e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/diff.css">
	<title><?php echo $title[0][0] . ' / ' . $title[1][0] . ' ' . $title[0][1]; ?></title>
</head>
<body>
	<?php echo $diff->Render($renderer); ?>
</body>
</html>
