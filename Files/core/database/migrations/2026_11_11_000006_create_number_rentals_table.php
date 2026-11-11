<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('number_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->foreignId('rented_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('owned_by_user_id')->constrained('users')->onDelete('cascade');
            $table->integer('price_cents');
            $table->string('status', 20)->default('active'); // active, completed, cancelled
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('number_rentals');
    }
};