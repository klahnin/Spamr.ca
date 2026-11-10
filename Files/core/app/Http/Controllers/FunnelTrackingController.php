<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use App\Models\FunnelClickEvent;
use App\Models\FunnelDomain;
use App\Models\FunnelLeadSubmission;
use App\Models\FunnelLink;
use App\Models\FunnelPageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FunnelTrackingController extends Controller
{
    private const EVENTS = ['page_view', 'scroll', 'button_click', 'form_start', 'form_submit', 'purchase'];
    private const FORBIDDEN_FIELD = '/(pass(word)?|pin|cvv|card|credit|debit|bank|seed|private.?key|token|otp|2fa|social.?security|government.?id)/i';

    public function redirect(Request $request, string $linkToken, ?string $recipientToken = null)
    {
        $link = FunnelLink::with('funnel.domain')->where('token_hash', hash('sha256', $linkToken))->where('is_active', true)->firstOrFail();
        $funnel = $link->funnel;
        abort_unless($funnel && $funnel->is_active && $funnel->domain?->verified_at, 404);
        $this->assertApprovedDestination($funnel);

        FunnelClickEvent::create([
            'funnel_link_id' => $link->id,
            'recipient_hash' => $recipientToken ? hash('sha256', $recipientToken) : null,
            'visitor_hash' => hash('sha256', $link->id . '|' . (string) $request->ip() . '|' . now()->format('Y-m-d')),
            'clicked_at' => now(),
        ]);

        $separator = str_contains($funnel->landing_url, '?') ? '&' : '?';
        return redirect()->away($funnel->landing_url . $separator . 'sp_funnel=' . urlencode($funnel->public_id));
    }

    /** Serve a customer-owned CNAME host, e.g. go.pineapple.cc/s/summer/token. */
    public function brandedRedirect(Request $request, string $slug, ?string $recipientToken = null)
    {
        $link = FunnelLink::with('funnel.domain')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $funnel = $link->funnel;
        abort_unless($funnel && $funnel->is_active && $funnel->domain?->verified_at && $funnel->domain?->cname_verified_at, 404);
        abort_unless(strtolower($request->getHost()) === $funnel->domain->hostname, 404);
        $this->assertApprovedDestination($funnel);

        FunnelClickEvent::create([
            'funnel_link_id' => $link->id,
            'recipient_hash' => $recipientToken ? hash('sha256', $recipientToken) : null,
            'visitor_hash' => hash('sha256', $link->id . '|' . (string) $request->ip() . '|' . now()->format('Y-m-d')),
            'clicked_at' => now(),
        ]);

        $separator = str_contains($funnel->landing_url, '?') ? '&' : '?';
        return redirect()->away($funnel->landing_url . $separator . 'sp_funnel=' . urlencode($funnel->public_id));
    }

    public function script(string $publicId)
    {
        $funnel = Funnel::with('domain')->where('public_id', $publicId)->where('is_active', true)->firstOrFail();
        $endpoint = route('funnels.track');
        $script = "(()=>{const e='" . addslashes($endpoint) . "',f='" . addslashes($funnel->public_id) . "',v=localStorage.getItem('spamr_fv')||crypto.randomUUID();localStorage.setItem('spamr_fv',v);const p=x=>({method:'POST',headers:{'Content-Type':'text/plain'},body:JSON.stringify(x),keepalive:true});const s=(t,d={})=>fetch(e,p({funnel:f,event:t,visitor:v,...d}));s('page_view');let m=0;addEventListener('scroll',()=>{let d=Math.round(100*(scrollY+innerHeight)/document.documentElement.scrollHeight);if(d>=m+25){m=d;s('scroll',{scroll_depth:d})}});document.addEventListener('click',a=>{if(a.target.closest('button,a'))s('button_click')});document.addEventListener('focusin',a=>{if(a.target.closest('form'))s('form_start')});document.addEventListener('submit',a=>{if(a.target.closest('form'))s('form_submit')});window.Spamr={track:(t,d={})=>s(t,d),trackLead:(fields={})=>fetch(e+'/lead',p({funnel:f,visitor:v,fields}))};})();";
        return response($script, 200, ['Content-Type' => 'application/javascript; charset=UTF-8', 'Cache-Control' => 'public, max-age=300']);
    }

    public function track(Request $request)
    {
        $request->merge($this->trackingPayload($request));
        $data = $request->validate(['funnel' => ['required', 'string', 'max:48'], 'event' => ['required', 'in:' . implode(',', self::EVENTS)], 'visitor' => ['required', 'string', 'max:120'], 'scroll_depth' => ['nullable', 'integer', 'between:0,100']]);
        $funnel = $this->authorizedFunnel($request, $data['funnel']);
        FunnelPageEvent::create(['funnel_id' => $funnel->id, 'visitor_hash' => hash('sha256', $data['visitor']), 'event_type' => $data['event'], 'scroll_depth' => $data['scroll_depth'] ?? null, 'occurred_at' => now()]);
        return $this->cors(response()->json(['ok' => true]), $request);
    }

    public function lead(Request $request)
    {
        $request->merge($this->trackingPayload($request));
        $request->validate(['funnel' => ['required', 'string', 'max:48'], 'visitor' => ['required', 'string', 'max:120'], 'fields' => ['required', 'array', 'min:1', 'max:20'], 'fields.*' => ['nullable', 'string', 'max:500']]);
        foreach ($request->input('fields', []) as $key => $value) {
            abort_if(preg_match(self::FORBIDDEN_FIELD, (string) $key) === 1, 422, 'This form field is not permitted.');
        }
        $funnel = $this->authorizedFunnel($request, $request->string('funnel')->toString());
        FunnelLeadSubmission::create(['user_id' => $funnel->user_id, 'funnel_id' => $funnel->id, 'fields' => $request->input('fields'), 'status' => 'new', 'submitted_at' => now()]);
        return $this->cors(response()->json(['ok' => true], 201), $request);
    }

    private function authorizedFunnel(Request $request, string $publicId): Funnel
    {
        $funnel = Funnel::with('domain')->where('public_id', $publicId)->where('is_active', true)->firstOrFail();
        $originHost = strtolower((string) parse_url((string) $request->header('Origin'), PHP_URL_HOST));
        abort_unless($originHost !== '' && $this->isApprovedHost($funnel->domain->hostname, $originHost) && $funnel->domain->verified_at, 403, 'Tracking origin is not verified.');
        return $funnel;
    }

    private function assertApprovedDestination(Funnel $funnel): void
    {
        $host = strtolower((string) parse_url($funnel->landing_url, PHP_URL_HOST));
        abort_unless($this->isApprovedHost($funnel->domain->hostname, $host), 404);
    }

    private function cors($response, Request $request)
    {
        return $response->header('Access-Control-Allow-Origin', $request->header('Origin'))->header('Vary', 'Origin');
    }

    private function trackingPayload(Request $request): array
    {
        $payload = json_decode($request->getContent(), true);
        return is_array($payload) ? $payload : $request->all();
    }

    private function isApprovedHost(string $trackingHost, string $candidateHost): bool
    {
        return $candidateHost === $trackingHost || Str::endsWith($trackingHost, '.' . $candidateHost);
    }
}
