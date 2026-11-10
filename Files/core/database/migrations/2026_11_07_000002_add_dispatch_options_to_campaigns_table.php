<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedSmallInteger('random_delay_min_seconds')->default(3)->after('message');
            $table->unsignedSmallInteger('random_delay_max_seconds')->default(6)->after('random_delay_min_seconds');
            $table->string('load_balance_mode', 20)->default('selected_sim')->after('random_delay_max_seconds');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['random_delay_min_seconds', 'random_delay_max_seconds', 'load_balance_mode']);
        });
    }
};
