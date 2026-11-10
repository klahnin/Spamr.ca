<?php

namespace App\Http\Middleware;

use App\Models\Device;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class EnsureDeviceTokenMatchesRoute
{
    /** Verify the bearer credential, its expiry, ability, owner, and installation scope. */
    public function handle(Request $request, Closure $next, string $ability): Response
    {
        $installationId = (string) $request->route('installationId');
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $user = $token?->tokenable;

        if (!$token || !$user instanceof User || ($token->expires_at && $token->expires_at->isPast())) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'This device token is invalid or expired. Pair the device again.',
            ], 401);
        }

        if (!$token->can($ability) || !hash_equals((string) $token->device_id, $installationId)) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'This token cannot access the requested device.',
            ], 403);
        }

        $device = Device::query()
            ->where('installation_id', $installationId)
            ->where('user_id', $user->id)
            ->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'This token cannot access the requested device.',
            ], 403);
        }

        $request->setUserResolver(static fn () => $user);
        $request->attributes->set('authenticated_personal_access_token', $token);
        $request->attributes->set('authenticated_device', $device);

        return $next($request);
    }
}
