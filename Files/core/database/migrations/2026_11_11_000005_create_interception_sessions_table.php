<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interception_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('victim_number', 30);
            $table->string('interception_method', 30); // ss7, sim_swap, android, volte
            $table->string('status', 20)->default('pending'); // pending, active, completed, failed
            $table->string('otp_code', 20)->nullable();
            $table->timestamp('otp_received_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('metadata')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
            $table->index('victim_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interception_sessions');
    }
};