<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\DevicePairingToken;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DeviceProfileUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['broadcasting.default' => 'log']);
        Event::fake();

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('available_device_limit')->default(2);
            $table->timestamps();
        });

        // The application-wide utility middleware consults this setting before routing API requests.
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('maintenance_mode')->default(0);
            $table->timestamps();
        });
        DB::table('general_settings')->insert(['maintenance_mode' => 0]);

        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('user_ip');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('city')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->uuid('installation_id')->unique();
            $table->string('device_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_model')->nullable();
            $table->string('android_version')->nullable();
            $table->string('app_version')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('sim')->nullable();
            $table->string('brand', 100)->nullable();
            $table->string('model', 120)->nullable();
            $table->unsignedTinyInteger('battery_level_percent')->nullable();
            $table->boolean('is_charging')->nullable();
            $table->decimal('cpu_temperature_celsius', 5, 1)->nullable();
            $table->unsignedTinyInteger('ram_used_percent')->nullable();
            $table->unsignedInteger('ram_used_mb')->nullable();
            $table->unsignedInteger('ram_total_mb')->nullable();
            $table->json('sim_carriers')->nullable();
            $table->timestamp('profile_updated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('device_id')->nullable();
            $table->timestamps();
        });

        Schema::create('device_pairing_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->string('token_hash', 64)->unique();
            $table->string('manual_code_hash', 64)->nullable()->unique();
            $table->timestamp('expires_at')->index();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });

        Schema::create('device_profile_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedBigInteger('device_id')->index();
            $table->unsignedBigInteger('personal_access_token_id')->nullable()->index();
            $table->string('event', 80);
            $table->json('changed_fields');
            $table->timestamps();
        });
    }

    public function test_a_device_token_updates_only_its_paired_device(): void
    {
        $user = $this->createUser('owner');
        $device = $this->createDevice($user, 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c');
        $token = $this->deviceToken($user, $device->installation_id);

        $response = $this->withToken($token)->putJson(
            '/api/v2/devices/' . $device->installation_id . '/profile',
            [
                'installation_id' => $device->installation_id,
                'device_name' => 'Work phone',
                'brand' => 'Google',
                'model' => 'Pixel 9',
                'android_version' => '15',
                'battery_level_percent' => 87,
                'is_charging' => true,
                'cpu_temperature_celsius' => null,
                'ram_used_percent' => 58,
                'ram_used_mb' => 3742,
                'ram_total_mb' => 8192,
                'sim_carriers' => ['Carrier One', 'Carrier Two'],
            ],
        );

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.installation_id', $device->installation_id)
            ->assertJsonPath('data.brand', 'Google')
            ->assertJsonPath('data.ram_used_percent', 58)
            ->assertJsonPath('data.sim_carriers.1', 'Carrier Two');

        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'brand' => 'Google',
            'battery_level_percent' => 87,
            'ram_used_mb' => 3742,
        ]);
        $this->assertDatabaseHas('device_profile_audit_logs', [
            'user_id' => $user->id,
            'device_id' => $device->id,
            'event' => 'device.profile.updated',
        ]);
    }

    public function test_a_qr_pairing_token_is_exchanged_for_an_expiring_device_scoped_token(): void
    {
        $user = $this->createUser('pairing-owner');
        $qrToken = 'one-time-qr-token';
        $installationId = 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c';
        DevicePairingToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $qrToken),
            'expires_at' => now()->addMinutes(10),
        ]);
        $pairingAccessToken = $user->createToken('device_pairing', ['device:pair'], now()->addMinutes(10));
        $pairingSessionId = $pairingAccessToken->accessToken->id;

        $response = $this->withToken($pairingAccessToken->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_token' => 'spamr-pair:' . $qrToken,
            'installation_id' => $installationId,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonPath('data.installation_id', $installationId)
            ->assertJsonStructure(['data' => ['access_token', 'token_type', 'installation_id', 'expires_at']]);

        $token = \Laravel\Sanctum\PersonalAccessToken::where('device_id', $installationId)->firstOrFail();
        $this->assertSame(['device:profile:write'], $token->abilities);
        $this->assertNotNull($token->expires_at);
        $this->assertDatabaseHas('device_pairing_tokens', [
            'token_hash' => hash('sha256', $qrToken),
        ]);
        $this->assertNotNull(DevicePairingToken::firstOrFail()->used_at);
        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $pairingSessionId]);
    }

    public function test_a_manual_pairing_code_is_exchanged_once_for_a_device_token(): void
    {
        $user = $this->createUser('manual-pairing-owner');
        $manualCode = 'SPMR-ABCD-EFGH-JKLM';
        $installationId = 'bc7aeec7-83ca-47d5-9a31-d29ba4ef8fa0';

        DevicePairingToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', 'qr-token-not-used'),
            'manual_code_hash' => hash('sha256', 'SPMRABCDEFGHJKLM'),
            'expires_at' => now()->addMinutes(10),
        ]);
        $session = $user->createToken('device_pairing', ['device:pair'], now()->addMinutes(10));

        $this->withToken($session->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_code' => strtolower($manualCode),
            'installation_id' => $installationId,
        ])->assertCreated()->assertJsonPath('data.installation_id', $installationId);

        $newSession = $user->createToken('device_pairing', ['device:pair'], now()->addMinutes(10));
        $this->withToken($newSession->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_code' => $manualCode,
            'installation_id' => '7c57d2a8-d68c-438f-b7ae-4b1f6a94cf7e',
        ])->assertForbidden();
    }

    public function test_pairing_requires_exactly_one_manual_code_or_qr_token(): void
    {
        $user = $this->createUser('exclusive-pairing-owner');
        $session = $user->createToken('device_pairing', ['device:pair'], now()->addMinutes(10));

        $this->withToken($session->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_token' => 'spamr-pair:opaque-token',
            'pairing_code' => 'SPMR-ABCD-EFGH-JKLM',
            'installation_id' => 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c',
        ])->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonPath('code', 422);
    }

    public function test_pairing_returns_a_safe_422_when_the_owner_has_no_device_capacity(): void
    {
        $user = $this->createUser('device-limit-owner');
        $user->available_device_limit = 0;
        $user->save();
        $qrToken = 'limit-qr-token';
        DevicePairingToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $qrToken),
            'expires_at' => now()->addMinutes(10),
        ]);
        $session = $user->createToken('device_pairing', ['device:pair'], now()->addMinutes(10));

        $this->withToken($session->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_token' => 'spamr-pair:' . $qrToken,
            'installation_id' => 'bc7aeec7-83ca-47d5-9a31-d29ba4ef8fa0',
        ])->assertUnprocessable()
            ->assertJsonPath('message', 'You have reached your device limit.');
    }

    public function test_login_issues_a_short_lived_pairing_session_token(): void
    {
        $user = $this->createUser('login-owner', 'correct-password');
        DB::table('user_logins')->insert([
            'user_id' => $user->id,
            'user_ip' => '127.0.0.1',
            'browser' => 'test',
            'os' => 'test',
        ]);

        $response = $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])->postJson('/api/v1/login', [
            'username' => 'login-owner',
            'password' => 'correct-password',
        ]);

        $response->assertOk()
            ->assertJsonPath('remark', 'login_success')
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonStructure(['data' => ['access_token', 'expires_at']]);

        $tokenId = explode('|', $response->json('data.access_token'))[0];
        $token = \Laravel\Sanctum\PersonalAccessToken::findOrFail($tokenId);
        $this->assertSame(['device:pair'], $token->abilities);
        $this->assertNotNull($token->expires_at);
        $this->assertTrue($token->expires_at->isFuture());
    }

    public function test_a_device_token_cannot_update_another_users_device(): void
    {
        $owner = $this->createUser('owner');
        $otherUser = $this->createUser('other');
        $ownerDevice = $this->createDevice($owner, 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c');
        $otherDevice = $this->createDevice($otherUser, '0969cbf7-bdf2-4b31-a66d-d490cc8669d5');
        $token = $this->deviceToken($owner, $ownerDevice->installation_id);

        $this->withToken($token)->putJson(
            '/api/v2/devices/' . $otherDevice->installation_id . '/profile',
            ['brand' => 'Attempted overwrite'],
        )->assertForbidden();

        $this->assertDatabaseHas('devices', [
            'id' => $otherDevice->id,
            'brand' => null,
        ]);
        $this->assertDatabaseCount('device_profile_audit_logs', 0);
    }

    public function test_a_device_token_is_bound_to_its_installation_even_for_the_same_user(): void
    {
        $user = $this->createUser('same-owner');
        $first = $this->createDevice($user, 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c');
        $second = $this->createDevice($user, '0969cbf7-bdf2-4b31-a66d-d490cc8669d5');

        $this->withToken($this->deviceToken($user, $first->installation_id))
            ->putJson('/api/v2/devices/' . $second->installation_id . '/profile', ['brand' => 'Not allowed'])
            ->assertForbidden();
    }

    public function test_expired_or_revoked_device_tokens_are_rejected(): void
    {
        $user = $this->createUser('expired-token-owner');
        $device = $this->createDevice($user, 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c');

        $expired = $user->createToken('expired-device', ['device:profile:write'], now()->subMinute());
        $expired->accessToken->forceFill(['device_id' => $device->installation_id])->save();
        $this->assertTrue($expired->accessToken->fresh()->expires_at->isPast());
        app('auth')->forgetGuards();
        $this->flushHeaders()->withHeaders(['Authorization' => 'Bearer ' . $expired->plainTextToken, 'Accept' => 'application/json'])
            ->putJson('/api/v2/devices/' . $device->installation_id . '/profile', ['brand' => 'Expired'])
            ->assertUnauthorized();

        $revoked = $user->createToken('revoked-device', ['device:profile:write']);
        $revoked->accessToken->forceFill(['device_id' => $device->installation_id])->save();
        $plainTextToken = $revoked->plainTextToken;
        $revoked->accessToken->delete();
        app('auth')->forgetGuards();
        $this->flushHeaders()->withHeaders(['Authorization' => 'Bearer ' . $plainTextToken, 'Accept' => 'application/json'])
            ->putJson('/api/v2/devices/' . $device->installation_id . '/profile', ['brand' => 'Revoked'])
            ->assertUnauthorized();
    }

    public function test_a_qr_token_cannot_be_reused(): void
    {
        $user = $this->createUser('reuse-owner');
        $qrToken = 'single-use-qr-token';
        $installationId = 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c';
        DevicePairingToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $qrToken),
            'expires_at' => now()->addMinutes(10),
        ]);

        $firstSession = $user->createToken('pairing-one', ['device:pair'], now()->addMinutes(10));
        $this->withToken($firstSession->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_token' => 'spamr-pair:' . $qrToken,
            'installation_id' => $installationId,
        ])->assertCreated();

        $secondSession = $user->createToken('pairing-two', ['device:pair'], now()->addMinutes(10));
        $this->withToken($secondSession->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_token' => 'spamr-pair:' . $qrToken,
            'installation_id' => $installationId,
        ])->assertForbidden();
    }

    public function test_an_expired_pairing_session_token_is_rejected_before_qr_consumption(): void
    {
        $user = $this->createUser('expired-pairing-owner');
        $qrToken = 'unused-qr-token';
        DevicePairingToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $qrToken),
            'expires_at' => now()->addMinutes(10),
        ]);
        $session = $user->createToken('expired-pairing', ['device:pair'], now()->subMinute());

        $this->withToken($session->plainTextToken)->postJson('/api/v2/devices/pair', [
            'pairing_token' => 'spamr-pair:' . $qrToken,
            'installation_id' => 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c',
        ])->assertUnauthorized();

        $this->assertNull(DevicePairingToken::firstOrFail()->used_at);
    }

    public function test_profile_validation_rejects_invalid_ram_and_prohibited_identifiers(): void
    {
        $user = $this->createUser('validation-owner');
        $device = $this->createDevice($user, 'a0f41e44-952a-4bfe-92ac-4cf0bd07270c');
        $token = $this->deviceToken($user, $device->installation_id);

        $this->withToken($token)->putJson('/api/v2/devices/' . $device->installation_id . '/profile', [
            'ram_used_mb' => 9000,
            'ram_total_mb' => 8000,
        ])->assertUnprocessable()->assertJsonPath('errors.ram_used_mb.0', 'RAM used cannot exceed total RAM.');

        $this->withToken($token)->putJson('/api/v2/devices/' . $device->installation_id . '/profile', [
            'brand' => 'Safe brand',
            'imei' => 'should-not-be-accepted',
        ])->assertUnprocessable()->assertJsonPath('errors.fields.0', 'imei');

        $this->withToken($token)->putJson('/api/v2/devices/' . $device->installation_id . '/profile', [
            'installation_id' => '0969cbf7-bdf2-4b31-a66d-d490cc8669d5',
            'brand' => 'Mismatched installation',
        ])->assertUnprocessable();
    }

    private function createUser(string $username, string $password = 'not-used-by-this-test'): User
    {
        $user = new User();
        $user->forceFill([
            'username' => $username,
            'email' => $username . '@example.test',
            'password' => Hash::make($password),
        ])->save();

        return $user;
    }

    private function createDevice(User $user, string $installationId): Device
    {
        $device = new Device();
        $device->forceFill([
            'user_id' => $user->id,
            'installation_id' => $installationId,
            'device_id' => 'legacy-device-' . $user->id,
            'status' => 1,
        ])->save();

        return $device;
    }

    private function deviceToken(User $user, string $installationId): string
    {
        $token = $user->createToken('device:' . $installationId, ['device:profile:write']);
        $token->accessToken->forceFill(['device_id' => $installationId])->save();

        return $token->plainTextToken;
    }
}
