<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms', function (Blueprint $table) {
            $table->string('otp_code', 20)->nullable()->after('message');
            $table->text('otp_regex')->nullable()->after('otp_code');
            $table->string('webhook_url', 500)->nullable()->after('otp_regex');
            $table->timestamp('webhook_sent_at')->nullable()->after('webhook_url');
            $table->string('webhook_status', 20)->nullable()->after('webhook_sent_at');
            $table->boolean('short_link_created')->default(false)->after('webhook_status');
            $table->string('short_link_code', 10)->nullable()->after('short_link_created');
            $table->index('otp_code');
        });
    }

    public function down(): void
    {
        Schema::table('sms', function (Blueprint $table) {
            $table->dropColumn(['otp_code', 'otp_regex', 'webhook_url', 'webhook_sent_at', 'webhook_status', 'short_link_created', 'short_link_code']);
        });
    }
};