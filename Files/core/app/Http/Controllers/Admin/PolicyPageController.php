<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use Illuminate\Http\Request;

class PolicyPageController extends Controller
{
    private const PAGES = [
        'legal-center' => 'Legal Center',
        'law-enforcement' => 'Law Enforcement Requests',
    ];

    public function index()
    {
        $pages = collect(self::PAGES)->map(function (string $title, string $slug) {
            return $this->policyPage($slug, $title);
        });
        $pageTitle = 'Policy Pages';

        return view('admin.policy_pages.index', compact('pageTitle', 'pages'));
    }

    public function edit(string $slug)
    {
        $page = $this->policyPage($slug);
        $pageTitle = 'Edit ' . $page->data_values->title;

        return view('admin.policy_pages.edit', compact('pageTitle', 'page', 'slug'));
    }

    public function update(Request $request, string $slug)
    {
        $page = $this->policyPage($slug);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'details' => ['nullable', 'string', 'max:50000'],
        ]);

        $purifier = new \HTMLPurifier();
        $page->data_values = [
            'title' => $validated['title'],
            'slug' => $slug,
            'details' => htmlspecialchars_decode($purifier->purify($validated['details'] ?? '')),
        ];
        $page->save();

        $notify[] = ['success', 'Policy page updated successfully'];
        return back()->withNotify($notify);
    }

    private function policyPage(string $slug, ?string $defaultTitle = null): Frontend
    {
        abort_unless(array_key_exists($slug, self::PAGES), 404);

        $page = Frontend::where('data_keys', 'policy_pages.element')
            ->where('tempname', activeTemplateName())
            ->where('slug', $slug)
            ->first();

        if (!$page) {
            $page = new Frontend();
            $page->forceFill([
                'data_keys' => 'policy_pages.element',
                'tempname' => activeTemplateName(),
                'slug' => $slug,
                'data_values' => [
                    'title' => $defaultTitle ?? self::PAGES[$slug],
                    'slug' => $slug,
                    'details' => '',
                ],
            ])->save();
        }

        return $page;
    }
}
