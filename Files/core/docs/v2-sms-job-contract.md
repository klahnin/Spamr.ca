# Spamr V2 installation-scoped SMS command contract

Status: design only. No SMS command, Pusher channel, or legacy `device_id` path is implemented by this document.

## Device authentication

Every device command endpoint is scoped to `/api/v2/devices/{installationId}` and requires a Sanctum token that:

- belongs to the device owner;
- has the exact route `installation_id` in `personal_access_tokens.device_id`;
- has a future `device:commands:read` or `device:commands:write` ability;
- has not expired or been revoked.

User tokens cannot execute or acknowledge device jobs.

## Proposed command lifecycle

1. The server creates a job only after validating campaign ownership, destination availability, consent reference, opt-out suppression, recipient country policy, content policy, and per-user/device quotas.
2. The device polls `GET /api/v2/devices/{installationId}/commands` using `device:commands:read`.
3. The response includes only unexpired jobs addressed to that installation, plus a job ID and idempotency key. It does not include secrets, Pusher credentials, or legacy device IDs.
4. The device acknowledges receipt using `POST /api/v2/devices/{installationId}/commands/{jobId}/ack` with `device:commands:write`.
5. The device reports a terminal result using `POST /api/v2/devices/{installationId}/commands/{jobId}/result` with a delivery state, safe error code, and the original idempotency key.

## Required job fields

- `id`: opaque server job identifier;
- `idempotency_key`: unique per job and retained server-side;
- `expires_at`: job expiry timestamp;
- `consent_reference`: server-issued consent record reference;
- `recipient`: normalized permitted destination;
- `message`: approved message body only after product approval for device transmission;
- `rate_limit`: server-calculated instruction, never client-controlled.

## Enforcement

- Every job is idempotent; duplicate acknowledgement or result reports are safe.
- Expired, cancelled, opt-out, revoked-device, blocked-country, and over-limit jobs are never delivered.
- Per-device, per-user, and per-campaign limits are enforced server-side.
- Revoking/removing a device revokes its scoped tokens and cancels its outstanding jobs.
- Audit records store job state transitions and field names/IDs only; they never store device tokens, pairing values, or credentials.

## Explicit exclusions

- No legacy `device_id` compatibility.
- No Pusher secret, provider secret, or private-channel credential in the Android app.
- No inbound SMS-content upload.
- No command endpoint is available until this contract receives product, consent, privacy, and abuse-prevention approval.
