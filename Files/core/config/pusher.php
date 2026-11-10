<?php

/*
 * Credentials must be injected by the deployment environment.  Do not place
 * Pusher credentials in source control, cached config, dashboard markup, or
 * API responses.  The values formerly present in this file must be rotated
 * before a production deployment.
 */
$pusherAppId = env('PUSHER_APP_ID');
$pusherAppKey = env('PUSHER_APP_KEY');
$pusherAppSecret = env('PUSHER_APP_SECRET');
$pusherAppCluster = env('PUSHER_APP_CLUSTER', 'mt1');
