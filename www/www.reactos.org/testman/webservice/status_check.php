<?php

    include "config.inc.php";
    // for GetBlackList
    include TESTMAN_PATH."utils.inc.php";
    include TESTMAN_PATH."connect.db.php";
    
    
    function GetResults($test_id, $query)
    {
        global $dbh;
        $result = array();

    	$stmt = $dbh->prepare("SELECT SUM(count) as count, SUM(failures) as failures FROM winetest_results WHERE test_id = :test_id $query LIMIT 1");
    	$stmt->bindParam(":test_id", $test_id);
    	$stmt->execute() or die("DB error ".__LINE__);
    	
    	if($stmt->rowCount() != 1)
           die("DB error ".__LINE__);
           
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $result[] = $row["count"];
        $result[] = $row["failures"];

        return $result;
    }
    
    $bl_query = null;
    $result = array();
    $blacklist = GetBlacklist();
    
    if(!isset($_GET["source_id"]) || !isset($_GET["revision"]) || !is_numeric($_GET["source_id"]) || !is_numeric($_GET["revision"]))
		die("Missing input.");
		
	try
	{
		$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_TESTMAN, DB_USER, DB_PASS);
	}
	catch(PDOException $exception)
	{
		die("DB error ".__LINE__);
	}
	
	// Build the query - get blacklisted tests
	if(count($blacklist) > 0)
	{
        $bl_query =  "AND suite_id not in (SELECT id FROM winetest_suites WHERE (";
        $or = null;
        
        foreach($blacklist as $suite)
        {
            $suite = explode(":", $suite, 2);
            $bl_query .= $or;
            $bl_query .= "(module = '$suite[0]' AND test = '$suite[1]')";
            $or = " OR ";
        }
        $bl_query .= "))";
	}

	// Get the revision run id
	$stmt = $dbh->prepare("SELECT id FROM winetest_runs WHERE revision = :revision AND source_id = :source_id ORDER BY revision DESC LIMIT 1");
	$stmt->bindParam(":revision", $_GET["revision"]);
	$stmt->bindParam(":source_id", $_GET["source_id"]);
	$stmt->execute() or die("DB error ".__LINE__);
	
	if($stmt->rowCount() == 0)
        die("DB error ".__LINE__);
        
    $first_run = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get the id of the preceding run
    $stmt = $dbh->prepare("SELECT id FROM winetest_runs WHERE revision < :revision AND source_id = :source_id ORDER BY revision DESC LIMIT 1");
	$stmt->bindParam(":revision", $_GET["revision"]);
	$stmt->bindParam(":source_id", $_GET["source_id"]);
	$stmt->execute() or die("DB error ".__LINE__);

	if($stmt->rowCount() == 0)
        die("DB error ".__LINE__);

    $second_run = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $result[] = GetResults($first_run["id"], $bl_query);
    $result[] = GetResults($second_run["id"], $bl_query);
    
    // Display results in form of totals diff; failures diff
    echo ($result[0][0] - $result[1][0]).";".($result[0][1] - $result[1][1]);
?>



