<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DevicePairingToken;
use Illuminate\Support\Str;

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
        DevicePairingToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $pairingToken),
            'expires_at' => now()->addMinutes(10),
        ]);
        $qrCodeImgSrc = cryptoQR('spamr-pair:' . $pairingToken);

        return view('Template::user.device.index', compact('pageTitle', 'allDevice', 'qrCodeImgSrc'));
    }
}
