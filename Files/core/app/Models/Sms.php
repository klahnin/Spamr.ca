<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use GlobalStatus;

    protected $fillable = [
        'device_id',
        'user_id',
        'campaign_id',
        'device_slot_number',
        'device_slot_name',
        'mobile_number',
        'message',
        'otp_code',
        'otp_regex',
        'webhook_url',
        'webhook_sent_at',
        'webhook_status',
        'short_link_created',
        'short_link_code',
        'schedule',
        'et',
        'batch_id',
        'status',
    ];

    protected $casts = [
        'webhook_sent_at' => 'datetime',
        'short_link_created' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function scopeBelongsToUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    /**
     * Extract OTP code from a message using the given (or stored) regex.
     */
    public static function extractOtp(string $message, ?string $regex = null): ?string
    {
        $regex = $regex ?? self::DEFAULT_OTP_REGEX;
        if (preg_match($regex, $message, $matches)) {
            return $matches[1] ?? $matches[0];
        }
        return null;
    }

    public const DEFAULT_OTP_REGEX = '/(?:code|otp|verification|one[- ]time|PIN)[^0-9]*([0-9]{4,8})/i';

    public function shortLinkUrl(): ?string
    {
        if (!$this->short_link_created || !$this->short_link_code) return null;
        return config('app.url') . '/s/' . $this->short_link_code;
    }
}