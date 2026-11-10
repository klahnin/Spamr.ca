<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceProfileAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DeviceProfileController extends Controller
{
    private const PERMITTED_FIELDS = [
        'installation_id',
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

    /**
     * Update the non-sensitive profile data for the authenticated installation only.
     */
    public function update(Request $request, string $installationId)
    {
        /** @var Device $device */
        $device = $request->attributes->get('authenticated_device');
        $prohibitedFields = array_values(array_diff(array_keys($request->all()), self::PERMITTED_FIELDS));

        if ($prohibitedFields !== []) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'The profile payload contains unsupported fields.',
                'errors' => ['fields' => $prohibitedFields],
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            // The route remains authoritative. The body value is accepted only for Android client compatibility.
            'installation_id' => ['sometimes', 'uuid', Rule::in([$installationId])],
            'device_name' => ['sometimes', 'nullable', 'string', 'max:120'],
            'brand' => ['sometimes', 'nullable', 'string', 'max:100'],
            'model' => ['sometimes', 'nullable', 'string', 'max:120'],
            'android_version' => ['sometimes', 'nullable', 'string', 'max:40'],
            'battery_level_percent' => ['sometimes', 'nullable', 'integer', 'between:0,100'],
            'is_charging' => ['sometimes', 'nullable', 'boolean'],
            // Optional telemetry only: no device identifiers or app/process inventory is accepted.
            'cpu_temperature_celsius' => ['sometimes', 'nullable', 'numeric', 'between:-20,125'],
            'ram_used_percent' => ['sometimes', 'nullable', 'integer', 'between:0,100'],
            'ram_used_mb' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:1048576'],
            'ram_total_mb' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:1048576'],
            'sim_carriers' => ['sometimes', 'nullable', 'array', 'max:4'],
            'sim_carriers.*' => ['nullable', 'string', 'max:100'],
        ]);

        $validator->after(function ($validator) use ($request, $device) {
            $used = $request->input('ram_used_mb', $device->ram_used_mb);
            $total = $request->input('ram_total_mb', $device->ram_total_mb);

            if ($used !== null && $total !== null && (int) $used > (int) $total) {
                $validator->errors()->add('ram_used_mb', 'RAM used cannot exceed total RAM.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'The profile payload is invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $profile = Arr::except($validator->validated(), 'installation_id');

        if ($profile === []) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Provide at least one profile field to update.',
            ], 422);
        }

        // The device is supplied only by EnsureDeviceTokenMatchesRoute, never by client input.
        $device->fill($profile);
        $changedFields = array_keys($device->getDirty());
        $device->profile_updated_at = now();
        $device->save();

        DeviceProfileAuditLog::create([
            'user_id' => $request->user()->id,
            'device_id' => $device->id,
            'personal_access_token_id' => $request->attributes->get('authenticated_personal_access_token')->id,
            'event' => 'device.profile.updated',
            // Store field names, not values, to keep audit logs free of profile content.
            'changed_fields' => $changedFields,
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Device profile updated.',
            'data' => [
                'installation_id' => $device->installation_id,
                'device_name' => $device->device_name,
                'brand' => $device->brand,
                'model' => $device->model,
                'android_version' => $device->android_version,
                'battery_level_percent' => $device->battery_level_percent,
                'is_charging' => $device->is_charging,
                'cpu_temperature_celsius' => $device->cpu_temperature_celsius,
                'ram_used_percent' => $device->ram_used_percent,
                'ram_used_mb' => $device->ram_used_mb,
                'ram_total_mb' => $device->ram_total_mb,
                'sim_carriers' => $device->sim_carriers,
                'profile_updated_at' => $device->profile_updated_at?->toISOString(),
            ],
        ]);
    }
}
