<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DevicePairingToken;
use App\Models\DeviceProfileAuditLog;
use App\Constants\Status;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class DeviceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pageTitle = 'Manage Device';
        $allDevice = Device::belongsToUser()
            ->searchable(['device_name', 'device_id'])
            ->filter(['status'])
            ->orderBy('id', 'DESC')
            ->paginate(getPaginate());

        // QR data is deliberately opaque: it is single-use, expires quickly, and
        // contains neither a user identifier nor a server secret.
        DevicePairingToken::where('user_id', $user->id)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->delete();

        $pairingToken = Str::random(64);
        $manualPairingCode = $this->makeManualPairingCode();
        DevicePairingToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $pairingToken),
            // A human-enterable pairing code is hashed at rest just like QR data.
            'manual_code_hash' => hash('sha256', $this->normaliseManualPairingCode($manualPairingCode)),
            'expires_at' => now()->addMinutes(10),
        ]);
        $qrCodeImgSrc = cryptoQR('spamr-pair:' . $pairingToken);

        return view('Template::user.device.index', compact('pageTitle', 'allDevice', 'qrCodeImgSrc', 'manualPairingCode'));
    }

    /** Revoke an owner device, its scoped credentials, and outstanding pairing sessions. */
    public function destroy(string $installationId)
    {
        /** @var User $user */
        $user = auth()->user();

        DB::transaction(function () use ($user, $installationId) {
            $device = Device::query()
                ->where('user_id', $user->id)
                ->where('installation_id', $installationId)
                ->lockForUpdate()
                ->firstOrFail();

            PersonalAccessToken::query()
                ->where('tokenable_type', User::class)
                ->where('tokenable_id', $user->id)
                ->where('device_id', $installationId)
                ->delete();

            // Pairing sessions are owner-bound rather than installation-bound,
            // so removing any device invalidates pending pairing credentials too.
            DevicePairingToken::query()
                ->where('user_id', $user->id)
                ->whereNull('used_at')
                ->delete();

            DeviceProfileAuditLog::query()->where('device_id', $device->id)->delete();
            $device->delete();

            if ((int) $user->available_device_limit !== Status::UNLIMITED) {
                $user->increment('available_device_limit');
            }
        });

        $notify[] = ['success', 'Device removed and its credentials were revoked.'];
        return back()->withNotify($notify);
    }

    private function makeManualPairingCode(): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $characters = [];

        for ($index = 0; $index < 12; $index++) {
            $characters[] = $alphabet[random_int(0, strlen($alphabet) - 1)];
        }

        return 'SPMR-' . implode('', array_slice($characters, 0, 4)) . '-'
            . implode('', array_slice($characters, 4, 4)) . '-'
            . implode('', array_slice($characters, 8, 4));
    }

    private function normaliseManualPairingCode(string $code): string
    {
        return strtoupper((string) preg_replace('/[^A-Za-z0-9]/', '', $code));
    }
}
