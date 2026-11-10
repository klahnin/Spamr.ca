# Spamr VPS production deployment

This guide deploys only the Android V2 pairing and permitted-profile flow. It
does **not** enable legacy `device_id`/Pusher Android relay, outbound SMS
transport, or inbound SMS-content upload.

## Prerequisites

- A domain, such as `app.example.com`, pointed at the VPS.
- Ubuntu/Debian VPS with Nginx, PHP 8.3-FPM, Composer 2, MySQL/MariaDB, Redis,
  and Certbot. Install PHP extensions required by this project, including
  `bcmath`, `curl`, `dom`, `fileinfo`, `gd`, `intl`, `mbstring`, `mysql`,
  `openssl`, `pdo`, `redis`, `xml`, `zip`.
- A database backup made and verified before changing production.
- A fresh `APP_KEY`, database password, Redis password, mail credentials, and
  replacement Pusher/provider credentials where those services are used.

## Secrets and environment

1. Copy `.env.production.example` to an out-of-repository, owner-readable
   location or provision equivalent environment variables through the host's
   secret manager. Never copy the local `.env` to production.
2. Set `APP_ENV=production`, `APP_DEBUG=false`, and the exact HTTPS
   `APP_URL`. Set `SESSION_SECURE_COOKIE=true`.
3. Set `TRUSTED_PROXIES` only to the IP/CIDR addresses of the reverse proxy or
   load balancer. Do not use `*` unless the network boundary guarantees all
   requests traverse that proxy.
4. Native Android requests do not require browser CORS. Set
   `CORS_ALLOWED_ORIGINS` to the web application's HTTPS origin, never `*` in
   production.
5. The former repository Pusher credentials were removed from source. Rotate
   those credentials before deployment; treat them as compromised. Do not set
   Pusher credentials unless that unrelated web functionality requires them.
   Pusher settings are intentionally not editable in the web admin: configure
   them only through deployment secrets and restart/re-cache configuration.

Required environment-variable groups (values deliberately omitted):

- Application: `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL`,
  `APP_TIMEZONE`.
- Database: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`,
  `DB_USERNAME`, `DB_PASSWORD`.
- Sessions/cache/queue: `SESSION_*`, `CACHE_*`, `QUEUE_*`, `REDIS_*`.
- Device API: `DEVICE_PAIRING_SESSION_TTL_MINUTES`, `DEVICE_TOKEN_TTL_DAYS`.
- Reverse proxy/CORS: `TRUSTED_PROXIES`, `CORS_ALLOWED_ORIGINS`.
- Mail and third-party services only when used: `MAIL_*`, `PUSHER_*`, payment
  provider variables, storage variables, and monitoring credentials.

## Deploy

From a release directory (not the public web root):

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

Set the release owner to the PHP-FPM user. Only `storage` and `bootstrap/cache`
should be writable by that user; application code, `.env`, backups, and source
configuration must not be web-writable. Configure Nginx from
`deploy/nginx/spamr.conf.example`, issue a TLS certificate with Certbot, test
Nginx, then reload it. Configure the queue service from
`deploy/systemd/spamr-queue.service.example` and restart it after each deploy.

Install the scheduler for the deploy user:

```cron
* * * * * cd /var/www/spamr/current && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

Use an atomic release/symlink strategy where possible. Before `migrate --force`,
take an encrypted database backup and verify it restores to an isolated
database. Migrations are forward-only unless an individual migration's `down()`
method has been reviewed and tested; recovery means restore the verified backup
and previous release, not an untested production rollback.

## V2 Android verification

Run automated tests in an isolated test database before deployment:

```bash
php artisan test --filter DeviceProfileUpdateTest --stop-on-failure
php artisan route:list --path=api/v2
```

Then, over the production HTTPS domain only:

1. Sign in as a non-production test owner with an available device slot.
2. Generate a new code on `/user/device`; it is owner-bound, one-use, and valid
   for ten minutes. Use either `pairing_code: SPMR-XXXX-XXXX-XXXX` or
   `pairing_token: spamr-pair:<opaque-token>`, never both.
3. Pair through `POST /api/v2/devices/pair`. It must return HTTP 201 with only
   `access_token`, `token_type`, `installation_id`, and `expires_at` in `data`.
4. Sync the approved profile through
   `PUT /api/v2/devices/{installationId}/profile` with the device token.
5. Confirm the owner dashboard shows only permitted telemetry.
6. Remove the device at `/user/device/{installationId}`; the next app sync must
   receive a safe 401/403 and require re-pairing.

## Security checks

- `POST /api/v1/login` remains rate-limited and issues only a ten-minute
  `device:pair` pairing session token for Android use.
- Pairing is rate-limited, accepts exactly one credential, verifies a UUID,
  consumes credentials once, and returns an installation-scoped token with only
  `device:profile:write`.
- The profile endpoint is rate-limited and rejects unknown/prohibited fields,
  including hardware identifiers, phone numbers, contacts, SMS bodies, tokens,
  and app/process inventory. Audit data records changed field names only.
- Safe JSON API errors apply to 401, 403, 422, 429 (with `Retry-After`), and
  V2 500 responses. Do not enable debug output in production.
- Device removal revokes device tokens, consumes unused pairing credentials,
  removes the device/audit records, and restores the capacity slot when
  applicable.

## Branded Funnel tracking domains

For a customer using `go.pineapple.cc`, require both records before enabling a
branded link such as `https://go.pineapple.cc/s/summer-abc123/<opaque-token>`:

```text
TXT    _spamr-verify.go.pineapple.cc   spamr-verify=<value displayed in Spamr>
CNAME go.pineapple.cc                 tracking.spamr.ca
```

`tracking.spamr.ca` must be a production tracking ingress capable of issuing a
certificate for each verified customer host (for example through Cloudflare
SaaS custom hostnames or an automated ACME workflow). It must forward the
original `Host` header to Laravel. Never activate a branded host merely because
it contains a familiar name; Laravel checks both the recorded domain and CNAME
verification before recording/redirecting a click.
- Check tracked files before release with `git grep -nEi
  '(PUSHER_APP_SECRET|API[_-]?KEY|SECRET|PASSWORD)' -- ':!*.example'`; review
  results rather than treating the command as proof. Never print `.env` in CI
  logs.
