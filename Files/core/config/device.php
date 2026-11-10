<?php

return [
    // Credential login can mint this narrowly scoped bridge token for QR pairing only.
    'pairing_session_ttl_minutes' => (int) env('DEVICE_PAIRING_SESSION_TTL_MINUTES', 10),

    // Device profile tokens are independently revocable and expire after this period.
    'token_ttl_days' => (int) env('DEVICE_TOKEN_TTL_DAYS', 30),
];
