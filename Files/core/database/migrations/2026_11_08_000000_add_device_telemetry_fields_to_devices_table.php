<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->decimal('cpu_temperature_celsius', 5, 1)->nullable()->after('is_charging');
            $table->unsignedTinyInteger('ram_used_percent')->nullable()->after('cpu_temperature_celsius');
            $table->unsignedInteger('ram_used_mb')->nullable()->after('ram_used_percent');
            $table->unsignedInteger('ram_total_mb')->nullable()->after('ram_used_mb');
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['cpu_temperature_celsius', 'ram_used_percent', 'ram_used_mb', 'ram_total_mb']);
        });
    }
};
