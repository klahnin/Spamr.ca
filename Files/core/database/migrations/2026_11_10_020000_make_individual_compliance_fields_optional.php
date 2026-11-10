<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('compliance_profiles', function (Blueprint $table) {
            $table->string('operating_country', 100)->nullable()->change();
            $table->string('operating_region', 100)->nullable()->change();
            $table->string('website', 2048)->nullable()->change();
            $table->json('audience_types')->nullable()->change();
            $table->string('industry', 120)->nullable()->change();
            $table->string('monthly_sms_volume', 40)->nullable()->change();
            $table->json('recipient_countries')->nullable()->change();
            $table->json('consent_methods')->nullable()->change();
            $table->json('campaign_purposes')->nullable()->change();
            $table->string('sender_name', 120)->nullable()->change();
            $table->string('support_email', 255)->nullable()->change();
            $table->text('public_business_address')->nullable()->change();
            $table->string('privacy_policy_url', 2048)->nullable()->change();
        });
    }

    public function down(): void {}
};
