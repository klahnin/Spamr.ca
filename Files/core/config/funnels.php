<?php

return [
    // The CNAME target customers configure for their branded tracking host.
    // In production this must terminate TLS and forward the original Host
    // header to Laravel or the tracking edge.
    'tracking_cname_target' => env('FUNNEL_TRACKING_CNAME_TARGET', 'tracking.spamr.ca'),
];
