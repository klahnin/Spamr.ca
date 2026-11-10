<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class EnsurePairingSessionToken
{
    /** Verify the short-lived bearer token minted solely for a QR pairing exchange. */
    public function handle(Request $request, Closure $next): Response
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $user = $token?->tokenable;

        if (!$token || !$user instanceof User) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'A valid pairing session token is required.',
            ], 401);
        }

        if (!$token->can('device:pair')) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'message' => 'This token cannot pair a device.',
            ], 403);
        }

        if (!$token->expires_at || $token->expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'code' => 401,
                'message' => 'This pairing session has expired. Sign in again to pair a device.',
            ], 401);
        }

        $request->setUserResolver(static fn () => $user);
        $request->attributes->set('authenticated_personal_access_token', $token);

        return $next($request);
    }
}
