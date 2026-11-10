<?php
namespace App\Http\Middleware;
use App\Models\ComplianceProfile;
use Closure;
use Illuminate\Http\Request;
class EnsureComplianceOnboarding {
    public function handle(Request $request, Closure $next) {
        if (!ComplianceProfile::where('user_id', auth()->id())->exists() && !$request->routeIs('user.compliance.*')) return to_route('user.compliance.show');
        return $next($request);
    }
}
