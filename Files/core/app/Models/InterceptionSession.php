<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterceptionSession extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'victim_number',
        'interception_method',
        'status',
        'otp_code',
        'otp_received_at',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'otp_received_at' => 'datetime',
        'completed_at'    => 'datetime',
        'metadata'        => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function scopeBelongsToUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'active']);
    }

    public function isComplete(): bool
    {
        return in_array($this->status, ['completed', 'failed']);
    }

    public function complete(?string $otpCode = null): void
    {
        $this->status = $otpCode ? 'completed' : 'failed';
        $this->otp_code = $otpCode;
        $this->completed_at = now();
        if ($otpCode) $this->otp_received_at = now();
        $this->save();
    }
}