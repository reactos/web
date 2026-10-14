<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     History of a single test suite on one source and platform
 * COPYRIGHT:   Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("utils.inc.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/exceptions.php");
	require_once(ROOT_PATH . "rosweb/gitinfo.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	//$rw = new RosWeb($supported_languages);
	$rw = new RosWeb();
	$lang = $rw->getLanguage();
	require_once(ROOT_PATH . "rosweb/lang/$lang.inc.php");
	require_once("lang/$lang.inc.php");

	/**
	 * Builds the query string of a link back to this page, with $overrides applied on top
	 * of the current suite, source and platform.
	 */
	function SuiteURL($overrides = array())
	{
		global $suite_id, $source_id, $platform;

		global $show_pr;

		$query = array_merge(array("suite" => $suite_id, "source" => $source_id, "platform" => $platform, "pr" => $show_pr ? 1 : null), $overrides);

		return "suite.php?" . http_build_query(array_filter($query, function($value) { return $value !== null && $value !== ""; }));
	}

	try
	{
		// Check the parameters. A suite only has a history within one source and platform;
		// mixing builders would compare results that were never meant to line up.
		foreach (array("suite", "source", "platform") as $required)
		{
			if (!array_key_exists($required, $_GET) || $_GET[$required] === "")
				throw new ErrorMessageException("Necessary information not specified");
		}

		$suite_id = (int)$_GET["suite"];
		$source_id = (int)$_GET["source"];
		$platform = $_GET["platform"];
		$cursor = array_key_exists("cursor", $_GET) ? (int)$_GET["cursor"] : 0;
		$newer = (array_key_exists("dir", $_GET) && $_GET["dir"] === "newer");

		// Pull request builds are off by default. A PR that breaks a test would otherwise
		// draw a spike in this history that reads as a master regression and is not one.
		$show_pr = (array_key_exists("pr", $_GET) && $_GET["pr"] === "1");

		if ($suite_id <= 0 || $source_id <= 0 || !preg_match("#^[A-Za-z0-9._-]{1,24}$#", $platform))
			throw new ErrorMessageException("Invalid input");

		$gi = new GitInfo();

		// Connect to the database.
		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $dbh->prepare("SELECT module, test FROM winetest_suites WHERE id = :suite_id");
		$stmt->execute(array(":suite_id" => $suite_id));
		$suite = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$suite)
			throw new ErrorMessageException("No test suite with this ID");

		$stmt = $dbh->prepare("SELECT name FROM sources WHERE id = :source_id");
		$stmt->execute(array(":source_id" => $source_id));
		$source_name = $stmt->fetchColumn();

		if ($source_name === FALSE)
			throw new ErrorMessageException("No source with this ID");

		// The runs are what gets paged, not the results: keyset on the run id, one extra
		// row to find out whether a further page exists. The suite is attached with a
		// LEFT JOIN, so a run in which it did not execute still shows up - that gap is
		// itself an answer to "when did this stop working".
		//
		// the driving query filters on source and platform but orders by id, so
		// it either scans the primary key backwards or sorts the source's runs. Both are
		// bounded by one source's run count. Add an index on (source_id, id) if that ever
		// stops being cheap.
		$page_size = SUITE_HISTORY_PAGE_SIZE;

		$driver = "SELECT r.id, r.timestamp, r.revision, r.base_revision, r.base_exact, r.pr_number, r.comment " .
		          "FROM winetest_runs r " .
		          "WHERE r.finished = 1 AND r.source_id = :source_id AND r.platform = :platform ";

		if (!$show_pr)
			$driver .= "AND r.pr_number IS NULL ";

		$params = array(":source_id" => $source_id, ":platform" => $platform, ":suite_id" => $suite_id);

		if ($cursor)
		{
			$driver .= ($newer ? "AND r.id > :cursor " : "AND r.id < :cursor ");
			$params[":cursor"] = $cursor;
		}

		$driver .= "ORDER BY r.id " . ($newer ? "ASC" : "DESC") . " LIMIT " . ($page_size + 1);

		$stmt = $dbh->prepare(
			"SELECT d.id AS run_id, UNIX_TIMESTAMP(d.timestamp) AS timestamp, d.revision, d.base_revision, d.base_exact, d.pr_number, d.comment, " .
			"e.id AS result_id, e.status, e.count, e.failures, e.skipped, e.todo, e.time " .
			"FROM ($driver) d " .
			"LEFT JOIN winetest_results e ON e.test_id = d.id AND e.suite_id = :suite_id " .
			"ORDER BY d.id " . ($newer ? "ASC" : "DESC")
		);
		$stmt->execute($params);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// The extra row is only a probe, it never gets rendered.
		$has_more = (count($rows) > $page_size);
		if ($has_more)
			array_pop($rows);

		// Always render newest first, whichever direction the page was read in.
		if ($newer)
			$rows = array_reverse($rows);

		// has_more only speaks about the direction that was asked for. In the other one we
		// either came from a page (so it exists) or we are at the newest run (so it is not).
		$has_older = $newer ? TRUE : $has_more;
		$has_newer = $newer ? $has_more : (bool)$cursor;

		// The run right below the page, so the oldest row on it can be compared as well.
		$tail = null;

		if (count($rows))
		{
			$stmt = $dbh->prepare(
				"SELECT e.id AS result_id, e.status, e.failures " .
				"FROM winetest_runs r " .
				"LEFT JOIN winetest_results e ON e.test_id = r.id AND e.suite_id = :suite_id " .
				"WHERE r.finished = 1 AND r.source_id = :source_id AND r.platform = :platform " .
				"AND r.pr_number IS NULL AND r.id < :run_id " .
				"ORDER BY r.id DESC LIMIT 1"
			);
			$stmt->execute(array(
				":suite_id" => $suite_id,
				":source_id" => $source_id,
				":platform" => $platform,
				":run_id" => $rows[count($rows) - 1]["run_id"],
			));
			$tail = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($tail === FALSE)
				$tail = null;
		}

		// Mark every row that differs from the run before it. Those are the rows worth
		// looking at; everything else is the same result repeated.
		//
		// Only master runs form that series. A PR build is compared against the newest
		// master run below it - "did I break this, or was it already broken" - and never
		// marks a change of its own, because a failure it introduces belongs to the pull
		// request and not to master's history.
		//
		// Walking oldest to newest keeps that baseline to hand in one pass.
		$older_master = $tail;

		for ($i = count($rows) - 1; $i >= 0; $i--)
		{
			$prev = $older_master;
			$is_pr = ($rows[$i]["pr_number"] !== null);

			$rows[$i]["prev_result_id"] = ($prev && array_key_exists("result_id", $prev)) ? $prev["result_id"] : null;
			$rows[$i]["changed"] = (!$is_pr && $prev !== null && ($rows[$i]["status"] !== $prev["status"] || $rows[$i]["failures"] !== $prev["failures"]));
			$rows[$i]["prev"] = $prev;

			if (!$is_pr)
				$older_master = $rows[$i];
		}
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
	<title><?php echo htmlspecialchars($suite["module"] . ":" . $suite["test"]); ?> - <?php echo $testman_langres["suite_title"]; ?></title>
	<?php $rw->printHead(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo AssetURL("css/testman.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo AssetURL("css/suite.css"); ?>">
</head>
<body>

<?php $rw->printHeader(); ?>

<div class="row" id="heading-breadcrumbs">
	<div class="col-md-offset-1 col-md-10">
		<div class="breadcrumbs">
			<a href="/">home</a> / <a href="/testman">testman</a> / <?php echo htmlspecialchars($suite["module"] . ":" . $suite["test"]); ?>
		</div>
		<h1><?php echo $testman_langres["suite_title"]; ?></h1>
	</div>
</div>

<section id="content" class="row">
	<div class="col-md-10 col-md-offset-1">
		<dl class="dl-horizontal">
			<dt><?php echo $testman_langres["testsuite"]; ?></dt>
			<dd><?php echo htmlspecialchars($suite["module"] . ":" . $suite["test"]); ?></dd>
			<dt><?php echo $testman_langres["source"]; ?></dt>
			<dd><a href="index.php?source=<?php echo $source_id; ?>"><?php echo htmlspecialchars($source_name); ?></a></dd>
			<dt><?php echo $testman_langres["platform"]; ?></dt>
			<dd><?php echo htmlspecialchars(GetPlatformString($platform)); ?></dd>
		</dl>

		<div class="pagesbox">
			<label class="includepr">
				<input type="checkbox" onclick="location.href = this.checked ? <?php echo htmlspecialchars(json_encode(SuiteURL(array("pr" => 1))), ENT_QUOTES); ?> : <?php echo htmlspecialchars(json_encode(SuiteURL(array("pr" => null))), ENT_QUOTES); ?>;"<?php echo $show_pr ? " checked" : ""; ?>>
				<?php echo $testman_langres["includepr"]; ?>
			</label>

			<?php if ($has_newer): ?>
				<a class="btn btn-default" href="<?php echo htmlspecialchars(SuiteURL(array("cursor" => $rows[0]["run_id"], "dir" => "newer"))); ?>"><i class="fa fa-angle-left"></i> <?php echo $testman_langres["newer"]; ?></a>
			<?php else: ?>
				<span class="btn btn-default disabled"><i class="fa fa-angle-left"></i> <?php echo $testman_langres["newer"]; ?></span>
			<?php endif; ?>

			<?php if ($has_older && count($rows)): ?>
				<a class="btn btn-default" href="<?php echo htmlspecialchars(SuiteURL(array("cursor" => $rows[count($rows) - 1]["run_id"], "dir" => "older"))); ?>"><?php echo $testman_langres["older"]; ?> <i class="fa fa-angle-right"></i></a>
			<?php else: ?>
				<span class="btn btn-default disabled"><?php echo $testman_langres["older"]; ?> <i class="fa fa-angle-right"></i></span>
			<?php endif; ?>
		</div>

		<table class="table table-hover" id="suitetable">
			<thead>
				<tr class="head">
					<th><?php echo $testman_langres["date"]; ?></th>
					<th><?php echo $shared_langres["revision"]; ?></th>
					<th><?php echo $testman_langres["teststatus"]; ?></th>
					<th><?php echo $testman_langres["totaltests"]; ?></th>
					<th><?php echo $testman_langres["failedtests"]; ?></th>
					<th><?php echo $testman_langres["skippedtests"]; ?></th>
					<th><?php echo $testman_langres["todotests"]; ?></th>
					<th><?php echo $testman_langres["timetest"]; ?></th>
					<th><?php echo $testman_langres["comment"]; ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if (!count($rows)): ?>
					<tr><td colspan="10"><?php echo $testman_langres["noresults"]; ?></td></tr>
				<?php else: foreach ($rows as $row): ?>
					<tr class="<?php echo trim(($row["changed"] ? "changed " : "") . ($row["pr_number"] !== null ? "prrun" : "")); ?>">
						<td><?php echo GetDateString($row["timestamp"]); ?></td>
						<td>
							<a href="compare.php?ids=<?php echo (int)$row["run_id"]; ?>"><?php echo $gi->getShortHash($row["revision"]); ?></a>
							<?php if ($row["pr_number"] !== null): ?>
								<br /><a class="prlink" href="<?php echo htmlspecialchars(sprintf(GITHUB_PR_URL, (int)$row["pr_number"])); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars(sprintf($testman_langres["onepr"], (int)$row["pr_number"])); ?></a>
								<?php if ($row["base_revision"] !== null): ?>
									<span class="anchor"><?php echo htmlspecialchars(sprintf($testman_langres["basedon"], $gi->getShortHash($row["base_revision"]))); ?></span>
								<?php endif; ?>
								<?php if (!$row["base_exact"]): ?>
									<span class="approx" title="<?php echo htmlspecialchars($testman_langres["approximate"]); ?>">?</span>
								<?php endif; ?>
							<?php endif; ?>
						</td>
						<?php if ($row["result_id"] === null): ?>
							<td colspan="6" class="notrun"><?php echo $testman_langres["notrun"]; ?></td>
						<?php else: ?>
							<td><?php echo htmlspecialchars($row["status"]); ?></td>
							<td><?php echo (int)$row["count"]; ?></td>
							<td><?php echo (int)$row["failures"]; ?> <span class="diff"><?php echo GetDifference($row, $row["prev"], "failures"); ?></span></td>
							<td><?php echo (int)$row["skipped"]; ?></td>
							<td><?php echo (int)$row["todo"]; ?></td>
							<td><?php echo $row["time"]; ?>s</td>
						<?php endif; ?>
						<td><?php echo htmlspecialchars($row["comment"]); ?></td>
						<td>
							<?php if ($row["result_id"] !== null): ?>
								<a href="detail.php?id=<?php echo (int)$row["result_id"]; ?><?php echo $row["prev_result_id"] ? "&amp;prev=" . (int)$row["prev_result_id"] : ""; ?>"><?php echo $testman_langres["log"]; ?></a>
								<?php if ($row["prev_result_id"]): ?>
									| <a href="diff.php?id1=<?php echo (int)$row["prev_result_id"]; ?>&amp;id2=<?php echo (int)$row["result_id"]; ?>&amp;type=1&amp;strip=1"><?php echo $testman_langres["showdiff"]; ?></a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
</section>

<?php
	$rw->printFooter();
	$rw->printCookieBanner();
?>

</body>
</html>
