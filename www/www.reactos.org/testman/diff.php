<?php
	require_once("config.inc.php");
	require_once("connect.db.php");
	require_once("lib/text_diff/Diff.php");
	require_once("lib/text_diff/Diff/Renderer/Html/SideBySide.php");
	require_once("lib/text_diff/Diff/Renderer/Html/Inline.php");
    
	function GetRevision($test_id)
	{
		global $dbh;
		$stmt = $dbh->prepare(
			"SELECT runs.revision, results.suite_id, suites.module, suites.test FROM winetest_results results
			JOIN winetest_runs runs ON runs.id = results.test_id
			JOIN winetest_suites suites ON suites.id = results.suite_id WHERE results.id = :id LIMIT 1"
		);
		$stmt->bindParam(":id", $test_id);
		$stmt->execute() or die("DB error @".__LINE__);

		if ($stmt->rowCount() != 1)
			die("DB error @".__LINE__);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return array($result["revision"], $result["module"], $result["test"], $result["suite_id"]);
	}
    
	function GetLog($test_id, $strip, $test)
	{
		global $dbh;

		$stmt = $dbh->prepare("SELECT UNCOMPRESS(log) log FROM winetest_logs WHERE id = :id LIMIT 1");
		$stmt->bindParam(":id", $test_id);
		$stmt->execute() or die("DB error @".__LINE__);

		if ($stmt->rowCount() != 1)
			die("DB error @".__LINE__);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$result = explode("\n", $result["log"]);

		if ($strip != 1)
		{
			return $result;
		}

		$stripped = array();

		foreach ($result as &$value)
		{
			if ($value && ($value[0] == "(" || strncmp($test, $value, strlen($test)) != 0))
				continue;

			$stripped[] = $value;
		}

		return $stripped;
	}


	if (!isset($_GET["id1"]) || !isset($_GET["id2"]) || !isset($_GET["type"]) || !isset($_GET["strip"]) || !is_numeric($_GET["id1"]) || !is_numeric($_GET["id2"]) || !is_numeric($_GET["type"]) || !is_numeric($_GET["strip"]))
		die("Necessary information not specified!");

	try
	{
		$dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_TESTMAN, DB_USER, DB_PASS);
	}
	catch(PDOException $e)
	{
		die("DB error @".__LINE__);
	}
	
	$suite_info[] = GetRevision($_GET["id1"]);
	$suite_info[] = GetRevision($_GET["id2"]);

	if ($suite_info[0][3] != $suite_info[1][3])
		die("Not the same suite.");

	$title = array();
	$title[] = array($suite_info[0][0], $suite_info[0][1].':'.$suite_info[0][2]);
	$title[] = array($suite_info[1][0], $suite_info[0][1].':'.$suite_info[0][2]);

	$options = array('ignoreWhitespace' => true, 'ignoreCase' => true);
	$diff = new Diff(GetLog($_GET["id1"], $_GET["strip"], $suite_info[0][2]), GetLog($_GET["id2"], $_GET["strip"], $suite_info[0][2]), $options);

	if ($_GET["type"] == 1)
		$renderer = new Diff_Renderer_Html_SideBySide;
	else
		$renderer = new Diff_Renderer_Html_Inline;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/diff.css">
	<title><?php echo 'r'.$title[0][0].' / r'.$title[1][0].' '.$title[0][1];?></title>
</head>
<body>
	<?php echo $diff->Render($renderer); ?>
</body>
</html>
