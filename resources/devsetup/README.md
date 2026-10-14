# Development Setup

Scripts for filling a local development database with real data from the live website,
so that Testman and GetBuilds show something useful without a production dump.

## Prerequisites

1. Create the `testman` and `gitinfo` databases and import the schemas:

   ```
   mysql testman < ../testman/testman.sql
   mysql gitinfo < ../gitinfo/gitinfo.sql
   ```

   `testman.sql` already includes every migration in `../testman/`, so a fresh database
   needs none of them. An existing one does; see the README there.

2. Point `www/www.reactos.org_config/testman-connect.php` and `gitinfo-connect.php` at them.

3. Enable the GD extension in `php.ini` (`extension=gd`) and restart the web server.
   `compare.php` generates its indicator images with it and fatals without it.

## import-live.php

```
php import-live.php [days] [--no-gitinfo]
```

Imports the test runs of the last `days` days (default: 7) from reactos.org, plus the
Git commits they refer to. Both parts are safe to re-run.

* **Commits** come from the GitHub API and go into `gitinfo.master_revisions`. That table
  is truncated first, because GitInfo derives the commit order from the auto increment
  `id` and appending older commits would silently break revision range searches.
  The production `gitinfo-connect.php` only grants `SELECT`, so either give the local user
  `INSERT` too, or override the credentials with the `GITINFO_DB_USER` and
  `GITINFO_DB_PASS` environment variables.

* **Test runs** come from `ajax-search.php` (for the run IDs and comments) and
  `export.php?f=xml` (for everything else). Run and result IDs of the live website are
  preserved, so local `detail.php` and `export.php` URLs match the ones on reactos.org.

Roughly 1400 results and 200 KB of XML per run, and about 30 runs per day, so keep `days`
small unless you want to wait.

## Anchoring the imported runs

`import-live.php` writes runs straight into the database rather than through the web
service, so they arrive without their `base_order`, `ref` and `pr_number`. Roughly a third
of recent runs are pull request builds, and until they are anchored they are missing from
revision ranges and indistinguishable from master runs. Fix that afterwards with:

```
php ../testman/backfill-run-anchors.php
```

The first run sweeps the BuildBot's build index, which takes a few minutes and is then
cached. See `../testman/README.md`.

### What is not imported

`winetest_logs`. The live website only exposes logs as HTML inside `detail.php`, one
request per result. Detail and diff views will therefore be empty for imported runs;
everything else works.

## Missing CSS

The stylesheets referenced by the shared page header (`/css/bootstrap.min.css` and
friends) are not part of this repository. They are built from the
[web-content](https://github.com/reactos/web-content) repository and served from
`www.reactos.org_content`. For a local setup, either build that repository and serve it as
the fallback document root, or redirect those paths to the live site from your vhost:

```apache
RedirectMatch 302 "^/((?:css|js|img|fonts|fork-awesome)/.*|favicon\.ico)$" "https://reactos.org/$1"
```

Use `reactos.org`, not `www.reactos.org`, which redirects every asset.
