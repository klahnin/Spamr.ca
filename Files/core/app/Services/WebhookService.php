<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Sms;
use Illuminate\Support\Facades\Http;

class WebhookService
{
    /**
     * Send an OTP-received webhook callback to the campaign's webhook URL.
     */
    public function sendOtpReceived(Sms $sms, ?Campaign $campaign = null): array
    {
        $url = $sms->webhook_url ?? $campaign?->webhook_url;
        if (!$url) return ['sent' => false, 'reason' => 'no_url'];

        $payload = [
            'event'       => 'otp_received',
            'sms_id'      => $sms->id,
            'campaign_id' => $sms->campaign_id,
            'otp_code'    => $sms->otp_code,
            'raw_message' => $sms->message,
            'from_number' => $sms->device?->sim[0]['number'] ?? null,
            'to_number'   => $sms->mobile_number,
            'device_name' => $sms->device?->device_name,
            'received_at' => now()->toIso8601String(),
        ];

        try {
            $response = Http::timeout(10)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);

            $status = $response->successful() ? 'success' : 'failed';
        } catch (\Exception $e) {
            $status = 'error';
        }

        $sms->webhook_sent_at = now();
        $sms->webhook_status  = $status;
        $sms->save();

        return ['sent' => true, 'status' => $status];
    }
}