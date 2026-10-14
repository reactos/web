<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0-or-later (https://spdx.org/licenses/GPL-2.0-or-later)
 * PURPOSE:     Front Page for managing ReactOS Regression Test results over the web
 * COPYRIGHT:   Copyright 2008-2020 Colin Finck (colin@reactos.org)
 *              Copyright 2012-2013 Aleksey Bragin (aleksey@reactos.org)
 *              Copyright 2026 Mark Jansen (mark.jansen@reactos.org)
 */

	require_once("config.inc.php");
	require_once(ROOT_PATH . "../www.reactos.org_config/testman-connect.php");
	require_once("utils.inc.php");
	require_once("languages.inc.php");
	require_once(ROOT_PATH . "rosweb/gitinfo.php");
	require_once(ROOT_PATH . "rosweb/rosweb.php");

	//$rw = new RosWeb($supported_languages);
	$rw = new RosWeb();
	$lang = $rw->getLanguage();
	require_once(ROOT_PATH . "rosweb/lang/$lang.inc.php");
	require_once("lang/$lang.inc.php");

	// The filters the page understands. They are the parameters of api/runs.php, so a
	// search is fully described by the query string and can be bookmarked and shared.
	$FILTER_KEYS = array("from", "to", "rev", "rev_from", "rev_to", "pr", "source", "platform", "min_failures", "cursor", "dir");

	try
	{
		$gi = new GitInfo();
		$rev = $gi->getShortHash($gi->getLatestRevision());

		// Connect to the database.
		$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// With a filter in the URL the JavaScript renders the matching runs, so the
		// overview below would only be in the way.
		$has_filter = (bool)array_intersect($FILTER_KEYS, array_keys($_GET));
		$cutoff = time() - LANDING_ACTIVE_DAYS * 86400;

		$sources = $dbh->query("SELECT id, name FROM sources ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

		// Only offer platforms that something actually still submits for.
		$stmt = $dbh->prepare("SELECT DISTINCT platform FROM winetest_runs WHERE finished = 1 AND timestamp >= FROM_UNIXTIME(:cutoff) ORDER BY platform");
		$stmt->execute(array(":cutoff" => $cutoff));
		$platforms = $stmt->fetchAll(PDO::FETCH_COLUMN);

		// The overview: the newest run of every source that is still submitting, plus the
		// one before it so the row can show what changed.
		// one small query per source. There is a handful of them and each is
		// served by ix_runs_src_plat; fold it into a single window function query if the
		// source list ever grows.
		$overview = array();

		if (!$has_filter)
		{
			$stmt = $dbh->prepare(
				"SELECT r.id, UNIX_TIMESTAMP(r.timestamp) AS timestamp, r.revision, r.platform, r.count, r.failures, r.comment " .
				"FROM winetest_runs r " .
				"WHERE r.finished = 1 AND r.source_id = :source_id " .
				"ORDER BY r.id DESC LIMIT 2"
			);

			foreach ($sources as $source)
			{
				$stmt->execute(array(":source_id" => $source["id"]));
				$runs = $stmt->fetchAll(PDO::FETCH_ASSOC);

				if (!count($runs) || $runs[0]["timestamp"] < $cutoff)
					continue;

				$overview[] = array(
					"source" => $source,
					"run" => $runs[0],
					"prev" => isset($runs[1]) ? $runs[1] : null,
				);
			}

			// Whoever finished last goes on top.
			usort($overview, function($a, $b) { return $b["run"]["timestamp"] - $a["run"]["timestamp"]; });
		}
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
	<title><?php echo $testman_langres["index_title"]; ?></title>
	<?php $rw->printHead(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo AssetURL("css/testman.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo AssetURL("css/index.css"); ?>">
	<script type="text/javascript">
		var MAX_COMPARE_RESULTS = <?php echo MAX_COMPARE_RESULTS; ?>;
		var GITHUB_PR_URL = <?php echo json_encode(str_replace("%u", "", GITHUB_PR_URL)); ?>;
	</script>
	<script type="text/javascript" src="<?php echo AssetURL("/rosweb/lang/$lang.js", ROOT_PATH . "rosweb/lang/$lang.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo AssetURL("lang/$lang.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo AssetURL("js/index.js"); ?>"></script>
</head>
<body onload="Load()">

<?php $rw->printHeader(); ?>

<div class="row" id="heading-breadcrumbs">
	<div class="col-md-offset-1 col-md-10">
		<div class="breadcrumbs">
			<a href="/">home</a> / <a href="/testman">testman</a>
		</div>
		<h1><?php echo $testman_langres["index_title"]; ?></h1>
	</div>
</div>

<section id="content" class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="testman-filters">
			<div class="row">
				<div class="col-md-3 form-group">
					<label for="search_source"><?php echo $testman_langres["source"]; ?></label>
					<select class="form-control" id="search_source" size="1">
						<option value=""><?php echo $testman_langres["allsources"]; ?></option>
						<?php foreach ($sources as $source): ?>
							<option value="<?php echo (int)$source["id"]; ?>"><?php echo htmlspecialchars($source["name"]); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-3 form-group">
					<label for="search_platform"><?php echo $testman_langres["platform"]; ?></label>
					<select class="form-control" id="search_platform" size="1">
						<option value=""><?php echo $testman_langres["allplatforms"]; ?></option>
						<?php foreach ($platforms as $platform): ?>
							<option value="<?php echo htmlspecialchars($platform); ?>"><?php echo htmlspecialchars(GetPlatformString($platform)); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-4 form-group">
					<label for="search_from"><?php echo $testman_langres["date"]; ?></label>
					<div class="date-range">
						<input class="form-control" type="date" id="search_from" title="<?php echo $testman_langres["datefrom"]; ?>">
						<span>&ndash;</span>
						<input class="form-control" type="date" id="search_to" title="<?php echo $testman_langres["dateto"]; ?>">
					</div>
				</div>

				<div class="col-md-2 form-group">
					<label for="search_min_failures"><?php echo $testman_langres["minfailures"]; ?></label>
					<input class="form-control" type="number" id="search_min_failures" min="0" step="1" value="">
				</div>
			</div>

			<div class="row">
				<div class="col-md-3 form-group">
					<label for="search_revision"><?php echo $shared_langres["revision"]; ?></label>
					<input class="form-control" type="text" id="search_revision" value="" placeholder="<?php echo htmlspecialchars($rev); ?>" title="<?php echo htmlspecialchars(sprintf($testman_langres["revisionhint"], $rev)); ?>">
				</div>

				<div class="col-md-4 form-group">
					<label for="search_rev_from"><?php echo $shared_langres["revision"]; ?> <?php echo $testman_langres["datefrom"]; ?>&ndash;<?php echo $testman_langres["dateto"]; ?></label>
					<div class="date-range" title="<?php echo htmlspecialchars($testman_langres["revisionrangehint"]); ?>">
						<input class="form-control" type="text" id="search_rev_from" title="<?php echo htmlspecialchars($testman_langres["revisionfrom"]); ?>">
						<span>&ndash;</span>
						<input class="form-control" type="text" id="search_rev_to" title="<?php echo htmlspecialchars($testman_langres["revisionto"]); ?>">
					</div>
				</div>

				<div class="col-md-3 form-group">
					<label for="search_pr"><?php echo $testman_langres["prbuilds"]; ?></label>
					<select class="form-control" id="search_pr" size="1">
						<option value="master"><?php echo $testman_langres["masteronly"]; ?></option>
						<option value="all"><?php echo $testman_langres["allbuilds"]; ?></option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 filter-actions">
					<button class="btn btn-primary" onclick="SearchButton_OnClick()"><i class="fa fa-search"></i> <?php echo $shared_langres["search_button"]; ?></button>
					<button class="btn btn-default" onclick="ResetButton_OnClick()"><?php echo $testman_langres["reset_button"]; ?></button>
					<button class="btn btn-default" onclick="CompareFirstTwoButton_OnClick()"><?php echo $testman_langres["comparefirsttwo_button"]; ?></button>
					<button class="btn btn-default" onclick="CompareSelectedButton_OnClick()"><?php echo $testman_langres["compareselected_button"]; ?></button>
					<label class="opennewwindow"><input type="checkbox" id="opennewwindow" onclick="OpenNewWindowCheckbox_OnClick(this)"> <?php echo $testman_langres["opennewwindow_checkbox"]; ?></label>
					<i class="fa fa-cog fa-spin" id="ajax_loading_search"></i>
				</div>
			</div>
		</div>

		<div id="overview"<?php echo $has_filter ? ' style="display: none;"' : ''; ?>>
			<h3><?php echo $testman_langres["overview_title"]; ?></h3>

			<table class="table table-hover" id="overviewtable">
				<thead>
					<tr class="head">
						<th><?php echo $testman_langres["source"]; ?></th>
						<th><?php echo $testman_langres["platform"]; ?></th>
						<th><?php echo $shared_langres["revision"]; ?></th>
						<th><?php echo $testman_langres["date"]; ?></th>
						<th><?php echo $testman_langres["totaltests"]; ?></th>
						<th><?php echo $testman_langres["failedtests"]; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if (!count($overview)): ?>
						<tr><td colspan="7"><?php echo $testman_langres["noresults"]; ?></td></tr>
					<?php else: foreach ($overview as $entry): ?>
						<tr>
							<td><?php echo htmlspecialchars($entry["source"]["name"]); ?></td>
							<td><?php echo htmlspecialchars(GetPlatformString($entry["run"]["platform"])); ?></td>
							<td><a href="compare.php?ids=<?php echo (int)$entry["run"]["id"]; ?>"><?php echo $gi->getShortHash($entry["run"]["revision"]); ?></a></td>
							<td><?php echo GetDateString($entry["run"]["timestamp"]); ?></td>
							<td><?php echo (int)$entry["run"]["count"]; ?> <span class="diff"><?php echo GetDifference($entry["run"], $entry["prev"], "count"); ?></span></td>
							<td><?php echo (int)$entry["run"]["failures"]; ?> <span class="diff"><?php echo GetDifference($entry["run"], $entry["prev"], "failures"); ?></span></td>
							<td><a href="?source=<?php echo (int)$entry["source"]["id"]; ?>"><?php echo $testman_langres["showhistory"]; ?></a></td>
						</tr>
					<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>

		<div id="searchtable">
			<!-- Filled by the JavaScript -->
		</div>

		<iframe id="comparepage_frame" frameborder="0" onload="ResizeIFrame()" scrolling="yes"></iframe>
	</div>
</section>

<?php
	$rw->printFooter();
	$rw->printCookieBanner();
?>

</body>
</html>
