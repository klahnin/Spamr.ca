<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->name('api.')->prefix('v1')->group(function () {

    Route::namespace('Auth')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::post('login', 'login')->middleware('throttle:5,1');
        });

        Route::controller('ForgotPasswordController')->group(function () {
            Route::post('password/email', 'sendResetCodeEmail');
            Route::post('password/verify-code', 'verifyCode');
            Route::post('password/reset', 'reset');
        });
    });

    Route::middleware('auth.api:sanctum')->group(function () {

        Route::post('logout', "User\Auth\LoginController@logout");

        Route::namespace('User\Auth')->middleware(['check.status', 'kyc.required'])->group(function () {
            Route::controller('LoginController')->group(function () {
                Route::post('add-device', "addDevice");
            });
        });
    });

    Route::namespace('User')->group(function () {
        Route::middleware(["auth.api:sanctum", 'kyc.required'])->group(function () {
            Route::prefix('message')->controller("SmsController")->group(function () {
                Route::post('/received', "received");
                Route::post('/update/{id}', "update");
            });
        });

        // API Implementation
        Route::controller('SmsController')->prefix('sms')->middleware('apiKey')->group(function () {
            Route::post('/send', 'send')->name('sms.send');
            Route::get('/send/get', 'sendViaGet')->name('sms.send.get');
        });

        // Pusher API
        Route::controller('PusherController')->group(function () {
            Route::post('pusher/auth', 'authenticationApp')->middleware(['auth.api:sanctum', 'kyc.required']);
            Route::post('pusher/auth/{socketId}/{channelName}', 'authentication');
        });
    });
});

Route::namespace('Api\\V2')->name('api.v2.')->prefix('v2')->group(function () {
    Route::post('devices/pair', 'DevicePairingController@store')
        ->middleware(['throttle:10,1', 'device.pairing'])
        ->name('devices.pair');

    Route::put('devices/{installationId}/profile', 'DeviceProfileController@update')
        ->whereUuid('installationId')
        ->middleware(['throttle:60,1', 'device.token:device:profile:write'])
        ->name('devices.profile.update');
});
