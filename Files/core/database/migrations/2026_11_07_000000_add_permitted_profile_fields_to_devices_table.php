<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->uuid('installation_id')->nullable()->unique()->after('user_id');
            $table->string('brand', 100)->nullable()->after('device_name');
            $table->string('model', 120)->nullable()->after('brand');
            $table->unsignedTinyInteger('battery_level_percent')->nullable()->after('android_version');
            $table->boolean('is_charging')->nullable()->after('battery_level_percent');
            $table->json('sim_carriers')->nullable()->after('is_charging');
            $table->timestamp('profile_updated_at')->nullable()->after('sim_carriers');
        });

        // Existing installations receive a server-generated UUID before the column becomes required on MySQL.
        DB::table('devices')->whereNull('installation_id')->orderBy('id')->eachById(function (object $device): void {
            DB::table('devices')->where('id', $device->id)->update([
                'installation_id' => (string) Str::uuid(),
            ]);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE devices MODIFY installation_id CHAR(36) NOT NULL');
        }
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropUnique(['installation_id']);
            $table->dropColumn([
                'installation_id',
                'brand',
                'model',
                'battery_level_percent',
                'is_charging',
                'sim_carriers',
                'profile_updated_at',
            ]);
        });
    }
};
