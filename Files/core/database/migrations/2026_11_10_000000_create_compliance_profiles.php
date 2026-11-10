<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('compliance_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('account_type', 20);
            $table->string('legal_business_name')->nullable();
            $table->string('operating_country', 100);
            $table->string('operating_region', 100);
            $table->string('website', 2048);
            $table->json('audience_types');
            $table->string('industry', 120);
            $table->string('monthly_sms_volume', 40);
            $table->json('recipient_countries');
            $table->json('consent_methods');
            $table->string('consent_evidence_url', 2048)->nullable();
            $table->text('consent_sample_language')->nullable();
            $table->json('campaign_purposes');
            $table->string('sender_name', 120);
            $table->string('support_email', 255);
            $table->text('public_business_address');
            $table->string('privacy_policy_url', 2048);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
        Schema::table('kyc_verifications', function (Blueprint $table) {
            $table->string('verification_type', 20)->nullable()->after('status');
            $table->json('verification_data')->nullable()->after('selfie_path');
            $table->string('business_document_path')->nullable()->after('selfie_path');
            $table->string('director_id_document_path')->nullable()->after('business_document_path');
        });
    }
    public function down(): void {
        Schema::table('kyc_verifications', fn (Blueprint $table) => $table->dropColumn(['verification_type','verification_data','business_document_path','director_id_document_path']));
        Schema::dropIfExists('compliance_profiles');
    }
};
