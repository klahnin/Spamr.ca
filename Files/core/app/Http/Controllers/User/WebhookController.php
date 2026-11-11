<?php

namespace App\Http\Controllers\User;

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
        $campaigns = Campaign::belongsToUser()->whereNotNull('webhook_url')->latest()->paginate(getPaginate());
        $smsLog    = Sms::belongsToUser()->whereNotNull('webhook_url')->latest()->take(20)->get();

        return view('Template::user.webhook.index', compact('pageTitle', 'campaigns', 'smsLog'));
    }

    public function test(Request $request)
    {
        $request->validate(['campaign_id' => 'required|integer']);
        $campaign = Campaign::belongsToUser()->findOrFail($request->campaign_id);
        $service  = app(WebhookService::class);
        $sms      = new Sms();
        $sms->webhook_url = $campaign->webhook_url;
        $sms->otp_code    = '123456';
        $sms->message     = 'Test OTP: 123456';
        $result = $service->sendOtpReceived($sms, $campaign);
        return back()->withNotify([['success', "Webhook test sent: {$result['status']}"]]);
    }
}