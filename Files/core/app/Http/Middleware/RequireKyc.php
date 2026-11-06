<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\KycVerification;

class RequireKyc
{
    public function handle($request, Closure $next)
    {
        $userId = $request->user()?->id ?? auth('sanctum')->id() ?? auth()->id();
        $kyc = KycVerification::where('user_id', $userId)->first();

        if ($kyc && in_array($kyc->status, ['required', 'submitted', 'rejected'], true) && !$request->routeIs('user.kyc.*')) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'remark' => 'kyc_required',
                    'message' => ['KYC verification is required before this action can be used.'],
                ], 403);
            }

            return to_route('user.kyc.show');
        }

        return $next($request);
    }
}
