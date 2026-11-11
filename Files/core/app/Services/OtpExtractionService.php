<?php

namespace App\Services;

use App\Models\Sms;

class OtpExtractionService
{
    /**
     * Extract an OTP code from a raw SMS message.
     * Tries the campaign's regex first, then falls back to the default.
     */
    public function extract(?string $message, ?string $campaignRegex = null): ?string
    {
        if (!$message) return null;

        // Try campaign-specific regex first
        if ($campaignRegex && preg_match($campaignRegex, $message, $matches)) {
            return $matches[1] ?? $matches[0];
        }

        // Fall back to built-in patterns
        return $this->tryPatterns($message);
    }

    private function tryPatterns(string $message): ?string
    {
        $patterns = [
            // "Your code is 123456", "Code: 123456"
            '/(?:your code|code|otp|verification code|one-time code|one time code|PIN|security code)[^0-9]{0,15}([0-9]{4,8})/i',
            // "123456 is your verification code"
            '/^([0-9]{4,8})\s+is\s+(?:your|the)/i',
            // "Enter 123456 to verify"
            '/(?:enter|use|input)\s+([0-9]{4,8})/i',
            // "123456" at the start (common in carrier SMS)
            '/^([0-9]{4,8})\b/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}