# Docker Development Environment

Runs the ReactOS web services locally using three containers:

| Container | Description |
|-----------|-------------|
| `web` | Apache + PHP 8.2 serving all four services |
| `db` | MySQL 8.0 with roslogin, testman, and gitinfo databases |
| `ldap` | In-memory LDAP stub (replaces real LDAP for local testing) |

## Starting

```bash
docker compose up --build
```

The `--build` flag is only needed the first time or after changing files in `docker/web/` or `docker/ldap/`. On subsequent runs, `docker compose up` is sufficient.

## Services

Once running, the following URLs are available:

| URL | Service |
|-----|---------|
| http://localhost/roslogin/ | Authentication / user management |
| http://localhost/testman/ | Build and test results |
| http://localhost/getbuilds/ | Pre-built revision downloads |
| http://localhost/rosweb/ | Shared interface component |

## Test Credentials

The LDAP stub is pre-populated with these test accounts:

| Username | Password | Groups |
|----------|----------|--------|
| test | test12 | — |
| test2 | test12 | — |
| test3 | test12 | — |
| testmod | test12 | Moderators |
| testadmin | test12 | Moderators, Administrators |

## Database Access

Connect directly to the database for debugging:

```bash
docker compose exec db mysql -u roslogin roslogin
docker compose exec db mysql -u testman testman
```

## Configuration

The files in `docker/config/` are Docker-specific overrides for the connection settings in `www/www.reactos.org_config/`. They redirect database connections to the `db` container and LDAP to the `ldap` container. The original config files are not modified.

## Stopping

```bash
docker compose down          # stop containers, keep database volume
docker compose down -v       # stop containers and delete database volume
```
