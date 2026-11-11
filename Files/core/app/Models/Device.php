<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\FileExport;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use GlobalStatus, FileExport;

    protected $casts = [
        'sim' => 'array',
        'sim_carriers' => 'array',
        'is_charging' => 'boolean',
        'cpu_temperature_celsius' => 'decimal:1',
        'profile_updated_at' => 'datetime',
        'cooldown_until' => 'datetime',
        'is_for_rent' => 'boolean',
        'health_score' => 'decimal:2',
        'rental_price_cents' => 'integer',
    ];

    protected $fillable = [
        'device_name',
        'brand',
        'model',
        'android_version',
        'battery_level_percent',
        'is_charging',
        'cpu_temperature_celsius',
        'ram_used_percent',
        'ram_used_mb',
        'ram_total_mb',
        'sim_carriers',
        'health_score',
        'cooldown_until',
        'otp_success_count',
        'otp_failure_count',
        'delivery_success_count',
        'delivery_failure_count',
        'is_for_rent',
        'rental_price_cents',
        'rented_by_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sms()
    {
        return $this->hasMany(Sms::class);
    }

    public function rentals()
    {
        return $this->hasMany(NumberRental::class);
    }

    public function scopeConnected($query)
    {
        return $query->where('status', Status::YES);
    }

    public function scopeDisconnected($query)
    {
        return $query->where('status', Status::NO);
    }

    public function scopeBelongsToUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeAvailableForRent($query)
    {
        return $query->where('is_for_rent', true)
            ->whereNull('rented_by_user_id')
            ->where('status', Status::YES);
    }

    public function scopeNotOnCooldown($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('cooldown_until')
              ->orWhere('cooldown_until', '<', now());
        });
    }

    public function carrierForSlot($slot): ?string
    {
        foreach ($this->sim ?? [] as $key => $sim) {
            if (!is_array($sim) || (string) ($sim['slot'] ?? $key) !== (string) $slot) {
                continue;
            }
            $carrier = $sim['carrier'] ?? $sim['carrier_name'] ?? $sim['operator'] ?? null;
            if (is_string($carrier) && trim($carrier) !== '') {
                return trim($carrier);
            }
        }

        $carriers = array_values(array_filter($this->sim_carriers ?? [], fn ($carrier) => is_string($carrier) && trim($carrier) !== ''));
        if (!$carriers) {
            return null;
        }

        foreach (is_numeric($slot) ? array_unique([(int) $slot - 1, (int) $slot]) : [] as $index) {
            if (isset($carriers[$index])) {
                return trim($carriers[$index]);
            }
        }

        return count($carriers) === 1 ? trim($carriers[0]) : null;
    }

    public function updateHealthScore(): void
    {
        $total = $this->delivery_success_count + $this->delivery_failure_count;
        if ($total === 0) {
            $this->health_score = 100.00;
        } else {
            $this->health_score = round(($this->delivery_success_count / $total) * 100, 2);
        }
        $this->save();
    }

    public function onCooldown(): bool
    {
        return $this->cooldown_until !== null && $this->cooldown_until->isFuture();
    }

    public function setCooldown(int $seconds): void
    {
        $this->cooldown_until = now()->addSeconds($seconds);
        $this->save();
    }

    public function recordDelivery(bool $success): void
    {
        if ($success) $this->delivery_success_count++;
        else $this->delivery_failure_count++;
        $this->updateHealthScore();
    }

    public function recordOtp(bool $success): void
    {
        if ($success) $this->otp_success_count++;
        else $this->otp_failure_count++;
        $this->save();
    }
}