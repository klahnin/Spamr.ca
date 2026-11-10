<?php

namespace App\Http\Controllers\Api\V2;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DevicePairingToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DevicePairingController extends Controller
{
    /**
     * Exchange a one-time QR pairing token for an expiring, installation-scoped token.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pairing_token' => ['nullable', 'string', 'max:128'],
            'pairing_code' => ['nullable', 'string', 'max:32'],
            'installation_id' => ['required', 'uuid'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $hasQrToken = filled($request->input('pairing_token'));
            $hasManualCode = filled($request->input('pairing_code'));

            if ($hasQrToken === $hasManualCode) {
                $validator->errors()->add('pairing_credential', 'Provide exactly one pairing_code or pairing_token.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'The pairing payload is invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $pairingSessionToken = $request->attributes->get('authenticated_personal_access_token');
        $pairingToken = preg_replace('/^spamr-pair:/', '', $request->string('pairing_token')->toString());
        $manualPairingCode = strtoupper((string) preg_replace('/[^A-Za-z0-9]/', '', $request->string('pairing_code')->toString()));

        // Accept a manual code submitted through older QR-only clients as
        // spamr-pair:SPMR-XXXX-XXXX-XXXX. It still resolves only against the
        // hashed, owner-bound, expiring manual-code record below.
        if ($manualPairingCode === '' && preg_match('/^SPMR[-A-Z0-9]+$/i', $pairingToken)) {
            $manualPairingCode = strtoupper((string) preg_replace('/[^A-Za-z0-9]/', '', $pairingToken));
        }
        $installationId = $request->string('installation_id')->toString();
        $expiresAt = now()->addDays(max(1, (int) config('device.token_ttl_days')));

        try {
            $response = DB::transaction(function () use ($user, $pairingSessionToken, $pairingToken, $manualPairingCode, $installationId, $expiresAt) {
                $pairing = DevicePairingToken::query()
                    ->where(function ($query) use ($pairingToken, $manualPairingCode) {
                        if ($pairingToken !== '') {
                            $query->where('token_hash', hash('sha256', $pairingToken));
                        }

                        if ($manualPairingCode !== '') {
                            $query->orWhere('manual_code_hash', hash('sha256', $manualPairingCode));
                        }
                    })
                    ->whereNull('used_at')
                    ->where('expires_at', '>', now())
                    ->lockForUpdate()
                    ->first();

                // Never reveal whether a QR token belongs to another account or merely expired.
                if (!$pairing || $pairing->user_id !== $user->id) {
                    abort(403, 'Invalid or expired pairing token.');
                }

                $device = Device::query()
                    ->where('installation_id', $installationId)
                    ->lockForUpdate()
                    ->first();

                if ($device && $device->user_id !== $user->id) {
                    abort(403, 'Invalid installation identifier.');
                }

                if (!$device) {
                    if (!$user->hasLimit('available_device_limit')) {
                        abort(422, 'You have reached your device limit.');
                    }

                    $device = new Device();
                    $device->forceFill([
                        'user_id' => $user->id,
                        'installation_id' => $installationId,
                        'status' => Status::ENABLE,
                    ])->save();

                    $user->subtractLimitCounter('available_device_limit');
                } else {
                    $device->status = Status::ENABLE;
                    $device->save();
                }

                $pairing->used_at = now();
                $pairing->save();

                // Re-pairing revokes the prior token for this installation before issuing a replacement.
                DB::table('personal_access_tokens')
                    ->where('tokenable_id', $user->id)
                    ->where('tokenable_type', User::class)
                    ->where('device_id', $installationId)
                    ->delete();

                $token = $user->createToken(
                    'device:' . $installationId,
                    ['device:profile:write'],
                    $expiresAt,
                );
                $token->accessToken->forceFill(['device_id' => $installationId])->save();

                // The credential-login bridge token is single-purpose and should not survive pairing.
                $pairingSessionToken?->delete();

                return [
                    'access_token' => $token->plainTextToken,
                    'token_type' => 'Bearer',
                    'installation_id' => $installationId,
                    'expires_at' => $expiresAt->toISOString(),
                ];
            });
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
            return response()->json([
                'success' => false,
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage(),
            ], $exception->getStatusCode());
        }

        return response()->json(['data' => $response], 201);
    }
}
