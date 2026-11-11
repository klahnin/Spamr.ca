<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumberRental extends Model
{
    protected $fillable = [
        'device_id',
        'rented_by_user_id',
        'owned_by_user_id',
        'price_cents',
        'status',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
        'price_cents' => 'integer',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function renter()
    {
        return $this->belongsTo(User::class, 'rented_by_user_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owned_by_user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}