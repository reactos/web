# Testman database

`testman.sql` is the schema after every migration here has been applied, so a **new**
database needs only that:

```
mysql testman < testman.sql
```

An **existing** database needs the migrations, in order, once each.

## Upgrading an existing database

```
mysql testman < migrate-01-timeline.sql          # maintenance window, see below
GITHUB_TOKEN=... php backfill-run-anchors.php    # can run while the site is up
```

**`migrate-01-timeline.sql`** adds to `winetest_runs` the indexes that date filtering and
the run browser need, and the columns that put a run on master's timeline. It is a single
`ALTER`, because each change rebuilds the table anyway. The table is MyISAM, so that
rebuild holds a write lock and submitting builders block; the file has the query to size
the window first.

**`backfill-run-anchors.php`** fills those columns for runs that predate them. Resumable
and re-runnable, and it caches every external answer, so a second run costs almost
nothing. `--help` for the options.

## What the anchor columns are for

A run's identity (the exact commit it built) and its position on master's timeline (what
it was built against) are not the same thing. For a master build they coincide. For a
build of `refs/pull/9453/merge` they do not — that hash is one GitHub synthesised, it is
not in gitinfo and never will be, which is why searching for such a run used to fail and a
revision range used to omit it silently.

| Column | Master run | Pull request run |
| --- | --- | --- |
| `revision` | the exact commit that was built, unchanged | |
| `base_revision` | same as `revision` | the master commit underneath it |
| `base_order` | `master_revisions.id` of `base_revision` — the sortable axis | |
| `base_exact` | `1` | `0` when the position was guessed from the run's clock |
| `ref` | `refs/heads/master` | `refs/pull/9453/merge` or `.../head`, verbatim |
| `pr_number` | `NULL` | `9453`, parsed from `ref` |

`ref` is stored exactly as the builder reports it. Normalising it to `pr/9453` would lose
the `/merge` versus `/head` distinction, and those are different things whose bases are
computed differently: `/merge` is the pull request merged into master, `/head` is the
pull request branch on its own.

Old SVN runs keep `NULL` in every anchor column. They predate git, gitinfo has no ordinal
for them, and they stay reachable by date.

## Where the backfill gets its answers

Cheapest first, falling through:

1. **Master builds** resolve against gitinfo alone, no network. That is most of the archive.
2. **The ref and PR number** come from the BuildBot. A run's `comment` starts with
   `Build <N>` and its source name ends in the builder that ran it
   (`Build GCCLin_x86 on Test KVM` → `Test KVM`), which together address one build whose
   `branch` property is the ref. Build properties are kept forever, so this is always
   recoverable. Both the bare `master` and `refs/heads/master` spellings appear; the
   BuildBot used the first until around build 26,800.
3. **The base of a PR build** comes from the `prepare_source` step log, where `git show`
   prints `Merge: <base> <head>`. But **the janitor prunes log contents after a few
   hundred builds** — an old build still lists its `stdio` log and still answers `200`,
   with an empty body — so this only covers recent builds.
4. **GitHub** covers the rest, one request per distinct commit: `/commits/<sha>` gives
   `parents[0]` for a `/merge` ref, and `/compare/master...<sha>` gives
   `merge_base_commit` for a `/head` ref, whose first parent is the previous commit of the
   branch and *not* the base.
5. **The clock**, last resort: newest master commit at or before the run's timestamp,
   stored with `base_exact = 0`.

Set `GITHUB_TOKEN` for a full archive run because of step 4. Without it GitHub allows 60
requests an hour instead of 5000, and the script stops and asks to be re-run rather than
filling the rest of the archive with clock guesses that nothing would ever revisit.

The PR number is never scraped out of `comment`. The "Reason" half is free text someone
typed when triggering the build, and the live data has runs of PR 9310 whose reason reads
`PR 9449`.

## Self-checks

Against a development database and the local site, never production.

```
php selftest-anchors.php [base-url] [sourceid] [password]
php selftest-pr-history.php [base-url]
```

The first submits runs through the real web service and checks the anchor columns each one
gets: the three resolution cases, `/merge` versus `/head`, that an SVN revision number is
not mistaken for a hash prefix, and that a malformed `ref` or `baserevision` is rejected.
It deletes the runs it created.

The second checks that pull request builds stay off master's own history: turning them on
adds rows to the suite history without moving any of master's change marks, a PR build is
never marked as a change itself, and a lone PR run's compare page picks its own master
baseline. Run the backfill first, or it has nothing to look at.
