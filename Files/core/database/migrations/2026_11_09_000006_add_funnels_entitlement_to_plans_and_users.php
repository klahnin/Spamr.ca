<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->boolean('funnels_available')->default(false)->after('campaign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('plan_funnels_available')->default(false)->after('plan_campaign_available');
        });
    }

    public function down(): void
    {
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('plan_funnels_available'));
        Schema::table('plans', fn (Blueprint $table) => $table->dropColumn('funnels_available'));
    }
};
