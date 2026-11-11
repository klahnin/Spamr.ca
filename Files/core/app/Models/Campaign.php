<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use GlobalStatus;

    protected $fillable = [
        'user_id',
        'title',
        'schedule',
        'et',
        'status',
        'message',
        'otp_regex',
        'webhook_url',
        'caller_id_spoof',
        'spoofed_number',
        'carrier_match',
        'cooldown_seconds',
        'auto_rotate',
        'random_delay_min_seconds',
        'random_delay_max_seconds',
        'load_balance_mode',
    ];

    protected $casts = [
        'random_delay_min_seconds' => 'integer',
        'random_delay_max_seconds' => 'integer',
        'caller_id_spoof' => 'boolean',
        'carrier_match' => 'boolean',
        'cooldown_seconds' => 'integer',
        'auto_rotate' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSim()
    {
        return $this->device_slot_number . '***' . $this->device_slot_name;
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function allSms()
    {
        return $this->hasMany(Sms::class, 'campaign_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function scopeBelongsToUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function isCompleted()
    {
        return (!$this->allSms()->where('status', '!=', Status::SMS_DELIVERED)->exists());
    }

    public function campaignBadge()
    {
        if ($this->isCompleted() || $this->status == Status::CAMPAIGN_FINISHED) {
            return '<span class="badge badge--success">' . trans('Finished') . '</span>';
        }
        if ($this->status == Status::CAMPAIGN_RUNNING) {
            return '<span class="badge badge--primary">' . trans('Running') . '</span>';
        }
        if ($this->status == Status::CAMPAIGN_PENDING) {
            return '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        }
        return '<span class="badge badge--dark">' . trans('Initiated') . '</span>';
    }

    public function otpCapturedCount()
    {
        return $this->allSms()->whereNotNull('otp_code')->count();
    }

    public function liveMetrics()
    {
        $total = $this->allSms()->count();
        $delivered = $this->allSms()->where('status', Status::SMS_DELIVERED)->count();
        $otpCaptured = $this->otpCapturedCount();
        return [
            'total' => $total,
            'delivered' => $delivered,
            'otp_captured' => $otpCaptured,
            'pending' => $total - $delivered,
        ];
    }
}