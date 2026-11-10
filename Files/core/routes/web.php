<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('cron', 'CronController@cron')->name('cron');

Route::post('/campaign-coverage/check', [\App\Http\Controllers\CampaignCoverageController::class, 'check'])
    ->middleware('throttle:20,1')
    ->name('campaign.coverage.check');

// External, verified-domain-only funnel tracking. No credentials or phone
// numbers are accepted by these public endpoints.
Route::controller(\App\Http\Controllers\FunnelTrackingController::class)->prefix('f')->name('funnels.')->group(function () {
    Route::get('r/{linkToken}/{recipientToken?}', 'redirect')->name('redirect')->middleware('throttle:120,1');
    Route::get('script/{publicId}.js', 'script')->name('script')->middleware('throttle:120,1');
    Route::post('track', 'track')->name('track')->middleware('throttle:120,1');
    Route::post('track/lead', 'lead')->name('lead')->middleware('throttle:30,1');
});

// Customer-owned branded tracking host. The production tracking ingress must
// preserve the original Host header after validating its TLS certificate.
Route::get('/s/{slug}/{recipientToken?}', [\App\Http\Controllers\FunnelTrackingController::class, 'brandedRedirect'])
    ->where(['slug' => '[A-Za-z0-9-]+', 'recipientToken' => '[A-Za-z0-9_-]+'])
    ->middleware('throttle:120,1')
    ->name('funnels.branded.redirect');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::controller('SiteController')->group(function () {
    Route::get('/bitcoin-price', 'bitcoinPrice')->name('bitcoin.price');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('/pricing', 'pricing')->name('pricing');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog', 'blog')->name('blog');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');

    Route::post('subscribe', 'subscribe')->name('subscribe');

});
