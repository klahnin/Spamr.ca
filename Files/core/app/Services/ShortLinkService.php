<?php

namespace App\Services;

use App\Models\Sms;
use Illuminate\Support\Str;

class ShortLinkService
{
    /**
     * Generate a short link code for an SMS and return the full URL.
     */
    public function create(Sms $sms, string $destinationUrl): string
    {
        $code = Str::lower(Str::random(6));
        $sms->short_link_code    = $code;
        $sms->short_link_created = true;
        $sms->save();

        return config('app.url') . '/s/' . $code;
    }

    /**
     * Build a short URL string for display.
     */
    public function url(string $code): string
    {
        return config('app.url') . '/s/' . $code;
    }
}