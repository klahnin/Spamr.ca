<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\ShortLinkService;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    public function index()
    {
        $pageTitle = 'SMS Short Links';
        $campaigns = Campaign::belongsToUser()->latest()->paginate(getPaginate());
        $service   = app(ShortLinkService::class);

        return view('Template::user.short_link.index', compact('pageTitle', 'campaigns', 'service'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|integer',
            'url'         => 'required|url',
        ]);
        $campaign = Campaign::belongsToUser()->findOrFail($request->campaign_id);
        $service  = app(ShortLinkService::class);
        $code     = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
        $url      = $service->url($code);

        return back()->withNotify([['success', "Short link created: {$url}"]]);
    }
}