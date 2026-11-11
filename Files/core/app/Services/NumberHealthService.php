<?php

namespace App\Services;

use App\Models\Device;

class NumberHealthService
{
    /**
     * Pick the best device for a campaign based on health + cooldown.
     * Optionally prefer same-carrier devices.
     */
    public function bestDevice(?string $preferredCarrier = null): ?Device
    {
        $query = Device::connected()
            ->notOnCooldown()
            ->whereNull('rented_by_user_id');

        if ($preferredCarrier) {
            // Try same-carrier first
            $match = $query->get()->first(fn ($d) => $this->carrierMatches($d, $preferredCarrier));
            if ($match) return $match;
        }

        return $query->orderByDesc('health_score')->first();
    }

    private function carrierMatches(Device $device, string $carrier): bool
    {
        return stripos($device->brand ?? '', $carrier) !== false
            || stripos($device->model ?? '', $carrier) !== false;
    }

    /**
     * Record a delivery outcome and apply cooldown.
     */
    public function recordDelivery(Device $device, bool $success, int $cooldownSeconds): void
    {
        $device->recordDelivery($success);
        if (!$success) {
            $device->setCooldown($cooldownSeconds);
        }
    }
}