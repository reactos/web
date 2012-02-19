<?php

    include "config.inc.php";
    require_once("utils.inc.php");
    // for GetBlackList
    include TESTMAN_PATH."utils.inc.php";
    include TESTMAN_PATH."connect.db.php";
    include TESTMAN_PATH."common.inc.php";
    
    
    function CheckResults($current_run, $previous_run, $blacklist)
    {
        global $dbh;
        
        $total_fail_diff = 0;
        $total_count_diff = 0;
        $offenders = array();
    
        if($current_run > $previous_run)
           $order = "DESC";
        else
           $order = "ASC";
           
        $bl_size = count($blacklist) - 1;
           
        $query = $dbh->prepare("SELECT id FROM winetest_suites ORDER BY id ASC");
        $query->execute();
        
        if($query->rowCount() == 0)
            die("DB error ".__LINE__);
            
        while($suite = $query->fetch(PDO::FETCH_ASSOC))
        {
           $results = array();
           $changed = false;
           $fail_diff = 0;
           $count_diff = 0;
           
           // Is this suite blacklisted?
           if($bl_size >= 0 && $blacklist[$bl_size] == $suite["id"])
           {
                array_pop($blacklist);
                $bl_size--;
                continue;
           }
           
            $stmt = $dbh->prepare("SELECT results.id, results.count, results.failures, results.status, suites.test, suites.module FROM winetest_results results
                                  JOIN winetest_suites suites ON results.suite_id = suites.id
                                  WHERE (results.test_id = :id1 OR results.test_id = :id2) AND results.suite_id = :sid ORDER BY results.id $order LIMIT 2");
            $stmt->bindParam(":id1", $current_run);
            $stmt->bindParam(":id2", $previous_run);
            $stmt->bindParam(":sid", $suite["id"]);
            $stmt->execute() or die("DB error @".__LINE__);

            // New test added, skip it in this run
            if(($fetch = $stmt->rowCount()) != 2)
                continue;

            while($fetch--)
            {
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                $results[] = array("test" => $res["module"].":".$res["test"], "count" => $res["count"], "failures" => $res["failures"], "result_id" => $res["id"], "status" => $res["status"]);
            }

            $fail_diff = $results[0]["failures"] - $results[1]["failures"];

            // Report only if the previous run was ok
            // TODO: if the previous run crashed, maybe try to find failures of some older run and use that
            if($fail_diff > 0 && $results[1]["status"] == "ok")
            {
               $changed = true;
               $total_fail_diff += $fail_diff;
            }
            else
            {
                $fail_diff = 0;
            }
            
            $count_diff = $results[0]["count"] - $results[1]["count"];

            if($count_diff < 0)
            {
               $changed = true;
               $total_count_diff += $count_diff;
            }
            else
            {
                $count_diff = 0;
            }
            
            if($changed == true)
                $offenders[] = array("name" => $results[0]["test"], "id1" => $results[0]["result_id"], "id2" => $results[1]["result_id"], "count" => $count_diff, "failures" => $fail_diff);

        }

        return array("offenders" => $offenders, "fail_diff" => $total_fail_diff, "count_diff" => $total_count_diff);
    }
    
    $bl_query = null;
    $result = array();

    if(!isset($_GET["source_id"]) || !isset($_GET["build"]) || !isset($_GET["password"]) || !isset($_GET["builder"]) ||
       !is_numeric($_GET["source_id"]) || !is_numeric($_GET["build"]) || !ctype_alnum($_GET["password"]))
        die("Wrong input.");

    try
    {
        $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_TESTMAN, DB_USER, DB_PASS);
    }
    catch(PDOException $exception)
    {
        die("DB error @".__LINE__);
    }

    VerifyLogin($_GET["source_id"], $_GET["password"]);

    $blacklist = GetBlacklist();

    // Build the query - get blacklisted tests
    if(count($blacklist) > 0)
    {
        $bl_query =  "";
        $or = null;
        
        foreach($blacklist as $suite)
        {
            $suite = explode(":", $suite, 2);
            $bl_query .= $or;
            $bl_query .= "(module = '$suite[0]' AND test = '$suite[1]')";
            $or = " OR ";
        }
    }
    
    // Get ids of all blacklisted tests
    if($bl_query)
    {
        $stmt = $dbh->prepare("SELECT id FROM winetest_suites WHERE ($bl_query) ORDER BY id DESC");
        $stmt->execute() or die("DB error ".__LINE__);
        $blacklist = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    
    // Get the revision run id
    $stmt = $dbh->prepare("SELECT id, revision FROM winetest_runs WHERE comment = :comment AND source_id = :source_id ORDER BY revision DESC LIMIT 1");
    $stmt->bindValue(":comment", "Build ".$_GET["build"]);
    $stmt->bindParam(":source_id", $_GET["source_id"]);
    $stmt->execute() or die("DB error ".__LINE__);
    
    if($stmt->rowCount() == 0)
        die("DB error ".__LINE__);
        
    $current_run = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get the id of the preceding run
    $stmt = $dbh->prepare("SELECT id, revision FROM winetest_runs WHERE revision < :revision AND source_id = :source_id AND finished = '1' ORDER BY revision DESC LIMIT 1");
    $stmt->bindParam(":revision", $current_run["revision"]);
    $stmt->bindParam(":source_id", $_GET["source_id"]);
    $stmt->execute() or die("DB error ".__LINE__);

    if($stmt->rowCount() == 0)
        die("DB error @".__LINE__);

    $previous_run = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $result = CheckResults($current_run["id"], $previous_run["id"], $blacklist);
    
    // No change detected, no more work to do
    if($result["fail_diff"] == 0 && $result["count_diff"] == 0)
       die("OK");
       
    // Assemble the report
    $subject = "";
    $body = "";
    $subject = $_GET["builder"].': '.($result["fail_diff"] > 0 ? ' failures +'.$result["fail_diff"] : '').($result["count_diff"] < 0 ? '  tests '.$result["count_diff"] : '');
    
    $body = "Following issues were detected while comparing test results between revisions ".$previous_run["revision"]." and ".$current_run["revision"].":\n\n";

    foreach($result["offenders"] as $offender)
    {
        $body.= "&nbsp;&nbsp;&nbsp;&nbsp;".$offender["name"]." -> ";
        
        if($offender["count"] != 0)
           $body .= " tests ".$offender["count"];
    
        if($offender["failures"] != 0)
           $body .= " failures +".$offender["failures"];
           
        $body .= sprintf(" <a href=\"%sdiff.php?id1=%d&id2=%d&type=1&strip=1\">diff<a/>", TESTMAN_URL, $offender["id2"], $offender["id1"]);
        
        $body .="\n";
    }
    
    $body .= "\nDetails: ";
    
    $body .= sprintf("<a href=\"%s\">log</a>, ", BUILDER_URL . rawurlencode($_GET["builder"]) . "/builds/" . $_GET["build"] . "/steps/test/logs/stdio/text");
    $body .= sprintf("<a href=\"%scompare.php?ids=%d,%d\">testman</a>, ", TESTMAN_URL, $previous_run["id"], $current_run["id"]);
    $body .= sprintf("<a href=\"%s?view=rev&revision=%d\">svn</a>", VIEWVC, $current_run["revision"]);
    
    echo "OK";
?>
