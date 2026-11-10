<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Funnel;
use App\Models\FunnelClickEvent;
use App\Models\FunnelDomain;
use App\Models\FunnelLeadSubmission;
use App\Models\FunnelLink;
use App\Models\FunnelPageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FunnelController extends Controller
{
    public function index()
    {
        $pageTitle = 'Spamr Funnels';
        $domains = FunnelDomain::where('user_id', auth()->id())->latest()->get();
        $funnels = Funnel::where('user_id', auth()->id())->with(['domain', 'links'])->latest()->get();
        $funnels->each(function (Funnel $funnel) {
            $linkIds = $funnel->links->pluck('id');
            $funnel->metrics = [
                'clicks' => FunnelClickEvent::whereIn('funnel_link_id', $linkIds)->count(),
                'unique_clicks' => FunnelClickEvent::whereIn('funnel_link_id', $linkIds)->distinct('recipient_hash')->count('recipient_hash'),
                'views' => FunnelPageEvent::where('funnel_id', $funnel->id)->where('event_type', 'page_view')->count(),
                'leads' => FunnelLeadSubmission::where('funnel_id', $funnel->id)->count(),
            ];
        });

        return view('Template::user.funnels.index', compact('pageTitle', 'domains', 'funnels'));
    }

    public function storeDomain(Request $request)
    {
        $request->validate(['hostname' => ['required', 'string', 'max:253', 'regex:/^(?=.{1,253}$)([a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,63}$/i']]);
        $hostname = strtolower(trim($request->hostname));

        FunnelDomain::updateOrCreate(
            ['user_id' => auth()->id(), 'hostname' => $hostname],
            ['verification_token' => 'spamr-verify=' . Str::lower(Str::random(32)), 'verification_method' => 'dns_txt', 'verified_at' => null]
        );

        return back()->withNotify([['success', 'Domain added. Publish the displayed DNS TXT record, then verify it.']]);
    }

    public function verifyDomain($id)
    {
        $domain = FunnelDomain::where('user_id', auth()->id())->findOrFail($id);
        $records = dns_get_record('_spamr-verify.' . $domain->hostname, DNS_TXT) ?: [];
        $values = collect($records)->pluck('txt')->filter();

        if (!$values->contains($domain->verification_token)) {
            return back()->withNotify([['error', 'DNS TXT record was not found yet. DNS changes can take time to propagate.']]);
        }

        $cnameTarget = rtrim(strtolower((string) config('funnels.tracking_cname_target')), '.');
        $cnameRecords = dns_get_record($domain->hostname, DNS_CNAME) ?: [];
        $cnameMatches = $cnameTarget !== '' && collect($cnameRecords)->pluck('target')->map(fn ($value) => rtrim(strtolower($value), '.'))->contains($cnameTarget);
        $domain->update(['verified_at' => now(), 'cname_verified_at' => $cnameMatches ? now() : null]);
        $message = $cnameMatches ? 'Domain and branded tracking CNAME verified.' : 'Domain ownership verified. Add the CNAME record before using branded tracking links.';
        return back()->withNotify([['success', $message]]);
    }

    public function storeFunnel(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'funnel_domain_id' => ['required', 'integer'],
            'landing_url' => ['required', 'url', 'max:2048'],
            'goal_type' => ['required', 'in:lead,purchase,signup,appointment'],
        ]);
        $domain = FunnelDomain::where('user_id', auth()->id())->whereNotNull('verified_at')->findOrFail($request->funnel_domain_id);
        $host = strtolower((string) parse_url($request->landing_url, PHP_URL_HOST));

        abort_unless($host === $domain->hostname || Str::endsWith($domain->hostname, '.' . $host), 422, 'The landing-page URL must be the branded domain or its parent domain.');

        $funnel = Funnel::create([
            'user_id' => auth()->id(),
            'funnel_domain_id' => $domain->id,
            'public_id' => 'funnel_' . Str::lower(Str::random(20)),
            'name' => $request->name,
            'landing_url' => $request->landing_url,
            'goal_type' => $request->goal_type,
        ]);
        $rawToken = Str::random(40);
        FunnelLink::create([
            'user_id' => auth()->id(),
            'funnel_id' => $funnel->id,
            'label' => 'Default tracking link',
            'slug' => Str::slug($funnel->name) . '-' . Str::lower(Str::random(6)),
            'token_hash' => hash('sha256', $rawToken),
        ]);

        session()->flash('funnel_link_' . $funnel->id, route('funnels.redirect', ['linkToken' => $rawToken]));
        return redirect()->route('user.funnels.index')->withNotify([['success', 'Funnel created. Copy the new tracking link into an approved campaign.']]);
    }

    public function leads(Request $request)
    {
        $pageTitle = 'Spamr Leads Vault';
        $query = FunnelLeadSubmission::where('user_id', auth()->id())->with('funnel')->latest('submitted_at');
        if ($request->filled('search')) {
            $needle = mb_strtolower($request->string('search')->toString());
            $query->getQuery()->whereRaw('1 = 0'); // encrypted lead values cannot be searched safely at SQL level.
            $leads = FunnelLeadSubmission::where('user_id', auth()->id())->with('funnel')->latest('submitted_at')->get()
                ->filter(fn ($lead) => str_contains(mb_strtolower(implode(' ', $lead->fields ?? [])), $needle));
        } else {
            $leads = $query->paginate(getPaginate());
        }
        return view('Template::user.funnels.leads', compact('pageTitle', 'leads'));
    }
}
