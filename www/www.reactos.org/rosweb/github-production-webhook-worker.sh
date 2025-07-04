#!/bin/bash
set -eu

LOCKDIR="/tmp/github-production-webhook-worker.lock"

while true; do
    # Check if another instance of this script is already running.
    if ! mkdir "$LOCKDIR" &> /dev/null; then
        sleep 5
        continue
    fi

    # We have acquired the lock and can be sure to be the only instance running!
    # Release the lock when the script exits for whatever reason.
    trap 'rm -rf "$LOCKDIR"' EXIT

    # Start from a clean sheet and update to the latest production branch in Git.
    cd /srv/web-content_git_repo
    git clean -d -f -f
    git checkout production
    git fetch
    git reset --hard origin/production

    # Build the production website.
    sed -i "s#baseURL = \".*\"#baseURL = \"https://reactos.org/\"#" config.toml
    sed -i "s#development_banner_text = \".*\"##" config.toml
    truncate --size=0 static/robots.txt
    hugo

    # Deploy it.
    # Uses the renameat2 tool from https://gist.github.com/eatnumber1/f97ac7dad7b1f5a9721f to exchange directories atomically.
    cd /srv/www
    rm -rf www.reactos.org_content_new
    mv /srv/web-content_git_repo/public www.reactos.org_content_new
    renameat2 -e www.reactos.org_content www.reactos.org_content_new
    rm -rf www.reactos.org_content_new

    # We have finished successfully!
    exit 0
done
