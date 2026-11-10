<?php
namespace App\Http\Middleware;
use App\Models\ComplianceProfile;
use App\Models\ComplianceOverride;
use Closure;
use Illuminate\Http\Request;
class EnsureComplianceOnboarding {
    public function handle(Request $request, Closure $next) {
        $isComplete = ComplianceProfile::where('user_id', auth()->id())->exists()
            || ComplianceOverride::where('user_id', auth()->id())->exists();
        if (!$isComplete && !$request->routeIs('user.compliance.*')) return to_route('user.compliance.show');
        return $next($request);
    }
}
