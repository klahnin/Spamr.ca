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
    ];

    /** Only these fields may be mass-assigned by the device profile endpoint. */
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sms()
    {
        return $this->hasMany(Sms::class);
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

    /**
     * Resolve the user-visible carrier for a SIM slot without collecting device identifiers.
     * V2 Android profiles store carrier names in slot order (0, 1, ...).
     */
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

        // Legacy SMS slots are commonly 1-based, while Android reports slot indexes from 0.
        foreach (is_numeric($slot) ? array_unique([(int) $slot - 1, (int) $slot]) : [] as $index) {
            if (isset($carriers[$index])) {
                return trim($carriers[$index]);
            }
        }

        return count($carriers) === 1 ? trim($carriers[0]) : null;
    }
}
