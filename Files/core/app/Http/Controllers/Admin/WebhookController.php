<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Sms;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index()
    {
        $pageTitle = 'Webhooks';
        $campaigns = Campaign::whereNotNull('webhook_url')->with('user')->latest()->paginate(getPaginate());
        $smsLog    = Sms::whereNotNull('webhook_url')->with('user', 'device')->latest()->take(30)->get();

        return view('Template::admin.webhook.index', compact('pageTitle', 'campaigns', 'smsLog'));
    }

    public function test(Request $request)
    {
        $request->validate(['campaign_id' => 'required|integer']);
        $campaign = Campaign::findOrFail($request->campaign_id);
        $service  = app(WebhookService::class);
        $sms      = new Sms();
        $sms->webhook_url = $campaign->webhook_url;
        $sms->otp_code    = '123456';
        $sms->message     = 'Test OTP: 123456';
        $result = $service->sendOtpReceived($sms, $campaign);
        return back()->withNotify([['success', "Webhook test sent: {$result['status']}"]]);
    }
}