<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\ShortLinkService;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    public function index()
    {
        $pageTitle = 'SMS Short Links';
        $campaigns = Campaign::with('user')->latest()->paginate(getPaginate());
        $service   = app(ShortLinkService::class);

        return view('Template::admin.short_link.index', compact('pageTitle', 'campaigns', 'service'));
    }
}