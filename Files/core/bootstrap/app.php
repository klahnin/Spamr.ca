<?php

use App\Http\Middleware\ApiKey;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\AuthenticateApi;
use App\Http\Middleware\CheckStatus;
use App\Http\Middleware\Demo;
use App\Http\Middleware\EnsureDeviceTokenMatchesRoute;
use App\Http\Middleware\EnsurePairingSessionToken;
use App\Http\Middleware\HasActivePlan;
use App\Http\Middleware\MaintenanceMode;
use App\Http\Middleware\RedirectIfAdmin;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfNotAdmin;
use App\Http\Middleware\RegistrationStep;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Laramin\Utility\VugiChugi;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
        using: function () {
            Route::namespace('App\Http\Controllers')->middleware([VugiChugi::mdNm()])->group(function () {
                Route::prefix('api')
                    ->middleware(['api', 'maintenance'])
                    ->group(base_path('routes/api.php'));
                Route::middleware(['web'])
                    ->namespace('Admin')
                    ->prefix('admin')
                    ->name('admin.')
                    ->group(base_path('routes/admin.php'));

                Route::middleware(['web', 'maintenance'])
                    ->namespace('Gateway')
                    ->prefix('ipn')
                    ->name('ipn.')
                    ->group(base_path('routes/ipn.php'));

                Route::middleware(['web', 'maintenance'])->prefix('user')->group(base_path('routes/user.php'));
                Route::middleware(['web', 'maintenance'])->group(base_path('routes/web.php'));
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Trust only the reverse-proxy addresses configured by the deployment.
        // Do not use a wildcard in production unless the infrastructure itself
        // guarantees that all incoming traffic has passed through that proxy.
        $trustedProxies = array_values(array_filter(array_map(
            'trim',
            explode(',', (string) env('TRUSTED_PROXIES', ''))
        )));

        if ($trustedProxies !== []) {
            $middleware->trustProxies(at: $trustedProxies);
        }

        $middleware->web(append: [
            \App\Http\Middleware\LanguageMiddleware::class,
            \App\Http\Middleware\ActiveTemplateMiddleware::class,
        ]);

        $middleware->alias([
            'auth.api' => AuthenticateApi::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            'admin' => RedirectIfNotAdmin::class,
            'admin.guest' => RedirectIfAdmin::class,

            'check.status' => CheckStatus::class,
            'demo' => Demo::class,
            'registration.complete' => RegistrationStep::class,
            'maintenance' => MaintenanceMode::class,

            'apiKey' => ApiKey::class,
            'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
            'has.active.plan' => HasActivePlan::class,
            'kyc.required' => \App\Http\Middleware\RequireKyc::class,
            'compliance.complete' => \App\Http\Middleware\EnsureComplianceOnboarding::class,
            'device.token' => EnsureDeviceTokenMatchesRoute::class,
            'device.pairing' => EnsurePairingSessionToken::class,
        ]);

        $middleware->preventRequestForgery(
            except: ['user/deposit', 'ipn*']
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function () {
            if (request()->is('api/*')) {
                return true;
            }
        });
        $exceptions->respond(function (Response $response) {
            if (request()->is('api/*') && $response->getStatusCode() === 429) {
                return response()->json([
                    'success' => false,
                    'code' => 429,
                    'message' => 'Too many requests. Please retry after the indicated delay.',
                ], 429, [
                    'Retry-After' => $response->headers->get('Retry-After', '60'),
                ]);
            }

            if (request()->is('api/v2/*')) {
                if ($response->getStatusCode() >= 500) {
                    return response()->json([
                        'success' => false,
                        'code' => 500,
                        'message' => 'An unexpected server error occurred.',
                    ], 500);
                }
            }

            if ($response->getStatusCode() === 401) {
                if (request()->is('api/*')) {
                    $notify[] = 'Unauthorized request';
                    return response()->json([
                        'remark' => 'unauthenticated',
                        'status' => 'error',
                        'message' => ['error' => $notify]
                    ]);
                }
            }

            return $response;
        });
    })->create();
