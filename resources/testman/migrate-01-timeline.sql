-- Testman migration 01: put every run on master's timeline
--
-- Only winetest_runs changes. A single ALTER, because each of these changes rebuilds the
-- whole table anyway and doing them separately would rebuild it several times. On MyISAM
-- that rebuild holds a table-level write lock and submitting builders block until it
-- finishes, so run this in a maintenance window and measure first to know how long it has
-- to be:
--
--   SELECT table_name, engine, table_rows,
--          ROUND(data_length /1024/1024) AS data_mb,
--          ROUND(index_length/1024/1024) AS index_mb
--   FROM information_schema.tables
--   WHERE table_schema = 'testman' AND table_name = 'winetest_runs';
--
--
-- Indexes
-- -------
-- ix_runs_ts        every search filters finished = 1 and then orders and pages by id;
--                   the timestamp in the middle makes the date filter an index range.
-- ix_runs_src_plat  covers "this builder on this platform, newest first", which is what
--                   the landing view and the suite history page ask for.
-- ix_runs_base      the revision range, which is now a numeric compare on base_order.
-- ix_runs_base_rev  the hash search also matches what a run was built on top of, so that
--                   typing a master commit finds the pull request builds based on it.
--                   Without this that half of the OR cannot use an index at all.
-- ix_runs_pr        every run of one pull request, across all builders.
--
-- KEY (revision) already serves the other half of that search, the LIKE 'abc1234%' prefix
-- match at the full 40 chars.
--
--
-- Anchor columns
-- --------------
-- A run's identity (the exact commit it built) and its position on master's timeline (what
-- it was built against) are not the same thing. For a master build they coincide; for a
-- build of refs/pull/N/merge they do not, and that hash is not in gitinfo and never will
-- be - which is why searching for such a run used to fail outright and a revision range
-- used to omit it silently.
--
-- revision       unchanged: the exact hash that was built.
-- base_revision  the master commit it was built on top of. Same as revision for a master
--                build, the merge base for a PR build, NULL when only the approximate
--                position is known.
-- base_order     master_revisions.id of base_revision. The sortable, rangeable axis, and
--                the only column timeline queries touch.
-- base_exact     0 when base_order was guessed from the run's clock rather than resolved.
-- ref            what the builder checked out, verbatim: "refs/heads/master",
--                "refs/pull/9453/merge", "refs/pull/9453/head". Not normalised, because
--                /merge (the pull request merged into master) and /head (the pull request
--                branch alone) are different things with differently computed bases.
-- pr_number      parsed out of ref, so "every run for PR N" is one indexed query.
--
-- Old SVN runs keep NULL in all of these: they predate git and gitinfo has no ordinal for
-- them. They stay reachable by date.
--
-- Fill these in for existing runs with backfill-run-anchors.php afterwards.

ALTER TABLE `winetest_runs`
  ADD COLUMN `base_revision` char(40) DEFAULT NULL COMMENT 'Master commit this run was built on top of' AFTER `revision`,
  ADD COLUMN `base_order` int(10) unsigned DEFAULT NULL COMMENT 'master_revisions.id of base_revision' AFTER `base_revision`,
  ADD COLUMN `base_exact` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 if base_order was guessed from the clock' AFTER `base_order`,
  ADD COLUMN `ref` varchar(64) DEFAULT NULL COMMENT 'What the builder checked out, verbatim' AFTER `base_exact`,
  ADD COLUMN `pr_number` int(10) unsigned DEFAULT NULL COMMENT 'Pull request number, parsed from ref' AFTER `ref`,
  ADD KEY `ix_runs_ts` (`finished`,`timestamp`,`id`),
  ADD KEY `ix_runs_src_plat` (`source_id`,`platform`,`timestamp`),
  ADD KEY `ix_runs_base` (`base_order`),
  ADD KEY `ix_runs_base_rev` (`base_revision`),
  ADD KEY `ix_runs_pr` (`pr_number`);
