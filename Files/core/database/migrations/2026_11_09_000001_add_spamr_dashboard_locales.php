<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            ['name' => 'Nederlands', 'code' => 'nl'],
            ['name' => 'Русский', 'code' => 'ru'],
            ['name' => '简体中文', 'code' => 'zh'],
        ] as $language) {
            DB::table('languages')->updateOrInsert(
                ['code' => $language['code']],
                $language + ['is_default' => 0, 'image' => '660b94fa876ac1712035066.png', 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('languages')->whereIn('code', ['nl', 'ru', 'zh'])->delete();
    }
};
