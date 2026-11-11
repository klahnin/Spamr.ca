<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterceptionSession;
use Illuminate\Http\Request;

class InterceptionController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'OTP Interception';
        $status    = $request->get('status');
        $query     = InterceptionSession::with('user', 'campaign');
        if ($status) $query->where('status', $status);
        $sessions = $query->latest()->paginate(getPaginate());

        return view('Template::admin.interception.index', compact('pageTitle', 'sessions', 'status'));
    }
}