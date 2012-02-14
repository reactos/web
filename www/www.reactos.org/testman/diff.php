<?php
	require_once("config.inc.php");
	require_once(TESTMAN_PATH . "connect.db.php");
	require_once '/lib/text_diff/Diff.php';
    require_once '/lib/text_diff/Diff/Renderer/Html/SideBySide.php';
    
    function GetRevision($test_id)
    {
        global $dbh;
    	$stmt = $dbh->prepare("SELECT runs.revision, results.suite_id, suites.module, suites.test FROM winetest_results results
                               JOIN winetest_runs runs ON runs.id = results.test_id
                               JOIN winetest_suites suites ON suites.id = results.suite_id WHERE results.id = :id LIMIT 1");
    	$stmt->bindParam(":id", $test_id);
    	$stmt->execute() or die("DB error @".__LINE__);
    	
    	if($stmt->rowCount() != 1)
            die("DB error @".__LINE__);
    	
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);

        return array($result["revision"].' - '.$result["module"].':'.$result["test"], $result["suite_id"]);
    }
    
    function GetLog($test_id)
    {
        global $dbh;

       	$stmt = $dbh->prepare("SELECT UNCOMPRESS(log) log FROM winetest_logs WHERE id = :id LIMIT 1");
    	$stmt->bindParam(":id", $test_id);
    	$stmt->execute() or die("DB error @".__LINE__);

    	if($stmt->rowCount() != 1)
            die("DB error @".__LINE__);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return explode("\n", $result["log"]);
    }
    

	if(!isset($_GET["id1"]) || !isset($_GET["id2"]) || !is_numeric($_GET["id1"]) || !is_numeric($_GET["id2"]))
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
    
    if($suite_info[0][1] != $suite_info[1][1])
       die("Not the same suite.");

    $title = array();
    $title[] = $suite_info[0][0];
    $title[] = $suite_info[1][0];

	$options = array('ignoreWhitespace' => true, 'ignoreCase' => true);
	$diff = new Diff(GetLog($_GET["id1"]), GetLog($_GET["id2"]), $options);
	$renderer = new Diff_Renderer_Html_SideBySide;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/diff.css" />
	<link rel="stylesheet" type="text/css" href="css/compare.css" />
	<title><?php echo $title[0].' / '.$title[1];?></title>
	<script type="text/javascript" src="js/diff.js"></script>
</head>
<body onload="showDiff()">
<?php echo $diff->Render($renderer); ?>
</body>
</html>
