<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->decimal('health_score', 5, 2)->default(100.00)->after('ram_total_mb');
            $table->timestamp('cooldown_until')->nullable()->after('health_score');
            $table->integer('otp_success_count')->default(0)->after('cooldown_until');
            $table->integer('otp_failure_count')->default(0)->after('otp_success_count');
            $table->integer('delivery_success_count')->default(0)->after('otp_failure_count');
            $table->integer('delivery_failure_count')->default(0)->after('delivery_success_count');
            $table->boolean('is_for_rent')->default(false)->after('delivery_failure_count');
            $table->integer('rental_price_cents')->default(100)->after('is_for_rent');
            $table->string('rented_by_user_id', 36)->nullable()->after('rental_price_cents');
        });
        $table->index('is_for_rent');
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['health_score', 'cooldown_until', 'otp_success_count', 'otp_failure_count', 'delivery_success_count', 'delivery_failure_count', 'is_for_rent', 'rental_price_cents', 'rented_by_user_id']);
        });
    }
};