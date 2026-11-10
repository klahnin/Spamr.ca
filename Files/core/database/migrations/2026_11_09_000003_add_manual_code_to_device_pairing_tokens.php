<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('device_pairing_tokens', function (Blueprint $table) {
            $table->string('manual_code_hash', 64)->nullable()->unique()->after('token_hash');
        });
    }

    public function down(): void
    {
        Schema::table('device_pairing_tokens', function (Blueprint $table) {
            $table->dropUnique(['manual_code_hash']);
            $table->dropColumn('manual_code_hash');
        });
    }
};
