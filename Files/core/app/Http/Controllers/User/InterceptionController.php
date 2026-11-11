<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InterceptionSession;
use App\Services\InterceptionService;
use Illuminate\Http\Request;

class InterceptionController extends Controller
{
    public function index()
    {
        $pageTitle = 'OTP Interception';
        $sessions  = InterceptionSession::belongsToUser()->latest()->paginate(getPaginate());
        return view('Template::user.interception.index', compact('pageTitle', 'sessions'));
    }

    public function create()
    {
        $pageTitle = 'New Interception Session';
        return view('Template::user.interception.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'victim_number'       => 'required',
            'interception_method' => 'required|in:ss7,sim_swap,android,volte',
        ]);
        $service = app(InterceptionService::class);
        $service->start(auth()->id(), 0, $request->victim_number, $request->interception_method);
        return back()->withNotify([['success', "Interception session started for {$request->victim_number}"]]);
    }

    public function show($id)
    {
        $pageTitle = 'Session Detail';
        $session   = InterceptionSession::belongsToUser()->with('campaign')->findOrFail($id);
        return view('Template::user.interception.show', compact('pageTitle', 'session'));
    }

    public function complete($id, Request $request)
    {
        $request->validate(['otp_code' => 'nullable|string|max:10']);
        $session = InterceptionSession::belongsToUser()->findOrFail($id);
        app(InterceptionService::class)->complete($session, $request->otp_code);
        return back()->withNotify([['success', 'Session completed']]);
    }
}