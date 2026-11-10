<?php

use App\Models\Frontend;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $template = function_exists('activeTemplateName') ? activeTemplateName() : 'basic';

        foreach ([
            'legal-center' => 'Legal Center',
            'law-enforcement' => 'Law Enforcement Requests',
        ] as $slug => $title) {
            $page = Frontend::where('data_keys', 'policy_pages.element')
                ->where('tempname', $template)
                ->where('slug', $slug)
                ->first();

            if (!$page) {
                $page = new Frontend();
                $page->forceFill([
                    'data_keys' => 'policy_pages.element',
                    'tempname' => $template,
                    'slug' => $slug,
                    'data_values' => ['title' => $title, 'slug' => $slug, 'details' => ''],
                ])->save();
            }
        }
    }

    public function down(): void
    {
        Frontend::where('data_keys', 'policy_pages.element')
            ->whereIn('slug', ['legal-center', 'law-enforcement'])
            ->delete();
    }
};
