<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->text('otp_regex')->nullable()->after('message');
            $table->string('webhook_url', 500)->nullable()->after('otp_regex');
            $table->boolean('caller_id_spoof')->default(false)->after('webhook_url');
            $table->string('spoofed_number', 20)->nullable()->after('caller_id_spoof');
            $table->boolean('carrier_match')->default(false)->after('spoofed_number');
            $table->integer('cooldown_seconds')->default(300)->after('carrier_match');
            $table->boolean('auto_rotate')->default(true)->after('cooldown_seconds');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['otp_regex', 'webhook_url', 'caller_id_spoof', 'spoofed_number', 'carrier_match', 'cooldown_seconds', 'auto_rotate']);
        });
    }
};