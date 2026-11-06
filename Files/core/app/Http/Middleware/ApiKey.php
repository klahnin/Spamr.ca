<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey as ApiKeyModel;
use App\Models\KycVerification;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET')) {
            $apiKey = $request->apikey;
        } else {
            $header = $request->header();
            if (!array_key_exists('apikey', $header)) {
                return apiResponse(false, 422, null, ['API key must be required on request header']);
            }
            $apiKey = @$header['apikey'][0];
        }

        if (!$apiKey) {
            return apiResponse(false, 422, null, ['API key must be required']);
        }

        $exitsApiKey = ApiKeyModel::where('status', Status::ENABLE)->where('key', $apiKey)->with('user')->first();

        if (!$exitsApiKey) {
            return apiResponse(false, 406, null, ['API Key mismatch', 'API key not acceptable']);
        }

        $kyc = KycVerification::where('user_id', $exitsApiKey->user_id)->first();
        if ($kyc && in_array($kyc->status, ['required', 'submitted', 'rejected'], true)) {
            return apiResponse(false, 403, null, ['KYC verification is required before API access can be used']);
        }

        return $next($request);
    }
}
