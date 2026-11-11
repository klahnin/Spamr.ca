<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('category', 50)->nullable()->after('message');
            $table->string('bank', 100)->nullable()->after('category');
            $table->boolean('is_library')->default(false)->after('bank');
            $table->text('preview')->nullable()->after('is_library');
        });
        $table->index('category');
        $table->index('is_library');
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn(['category', 'bank', 'is_library', 'preview']);
        });
    }
};