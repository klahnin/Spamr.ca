<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
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

    public function down(): void
    {
        Schema::dropIfExists('device_profile_audit_logs');
    }
};
