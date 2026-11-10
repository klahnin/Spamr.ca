<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('funnel_domains', function (Blueprint $table) {
            $table->timestamp('cname_verified_at')->nullable()->index()->after('verified_at');
        });
        Schema::table('funnel_links', function (Blueprint $table) {
            $table->string('slug', 80)->nullable()->unique()->after('label');
        });
    }
    public function down(): void
    {
        Schema::table('funnel_links', fn (Blueprint $table) => $table->dropColumn('slug'));
        Schema::table('funnel_domains', fn (Blueprint $table) => $table->dropColumn('cname_verified_at'));
    }
};
