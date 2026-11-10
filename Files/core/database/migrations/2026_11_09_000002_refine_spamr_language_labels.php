<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('languages')->where('code', 'nl')->update(['name' => 'Dutch', 'updated_at' => now()]);
        DB::table('languages')->where('code', 'ru')->update(['name' => 'Russian', 'updated_at' => now()]);
        DB::table('languages')->where('code', 'zh')->update(['name' => 'Chinese', 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('languages')->where('code', 'nl')->update(['name' => 'Nederlands', 'updated_at' => now()]);
        DB::table('languages')->where('code', 'ru')->update(['name' => 'Русский', 'updated_at' => now()]);
        DB::table('languages')->where('code', 'zh')->update(['name' => '简体中文', 'updated_at' => now()]);
    }
};
