@extends('Template::layouts.master')

@section('content')
@php
    $maxClicks = max(1, $clickSeries->max('count'));
    $chartWidth = 620;
    $chartHeight = 158;
    $points = $clickSeries->values()->map(function ($day, $index) use ($chartWidth, $chartHeight, $maxClicks, $clickSeries) {
        $x = round(($chartWidth / max(1, $clickSeries->count() - 1)) * $index, 1);
        $y = round($chartHeight - (($day['count'] / $maxClicks) * ($chartHeight - 18)) - 9, 1);
        return $x . ',' . $y;
    })->implode(' ');
@endphp

<div class="funnels-workspace">
    @include('Template::partials.alert_box')

    <section class="funnels-hero">
        <div>
            <span class="funnels-eyebrow">Permission-based measurement</span>
            <h3>Domain Analytics &amp; Tracking</h3>
            <p>Verify a domain, create branded campaign links, and measure consent-safe engagement without sharing hosting credentials.</p>
        </div>
        <div class="funnels-hero__meta">
            <span><i class="las la-shield-alt"></i> Verified origins only</span>
            <span><i class="las la-lock"></i> Sensitive fields blocked</span>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-lg-5">
            <section class="analytics-panel analytics-panel--domain h-100">
                <div class="panel-heading">
                    <div><span class="panel-kicker">Step 1</span><h5>Add a verified domain</h5></div>
                    <i class="las la-globe panel-icon"></i>
                </div>
                <form method="POST" action="{{ route('user.funnels.domains.store') }}" class="domain-form">
                    @csrf
                    <label class="form-label" for="domain-hostname">Domain</label>
                    <div class="domain-field">
                        <input id="domain-hostname" class="form-control form--control" name="hostname" placeholder="offers.example.com" required>
                        @if($domains->whereNotNull('verified_at')->isNotEmpty())<span class="domain-field__status"><i class="las la-check"></i> Verified</span>@endif
                    </div>
                    <button class="btn btn--base w-100 mt-3">Create DNS verification record</button>
                </form>

                <div class="domain-list">
                    @forelse($domains as $domain)
                        <article class="domain-record">
                            <div class="domain-record__top">
                                <strong>{{ $domain->hostname }}</strong>
                                @if($domain->verified_at)<span class="status-pill status-pill--success"><i class="las la-check-circle"></i> Verified</span>@else<span class="status-pill status-pill--pending">Pending</span>@endif
                            </div>
                            @if(!$domain->verified_at)
                                <p>Publish this TXT record, then check verification.</p>
                                <code>_spamr-verify.{{ $domain->hostname }}</code>
                                <code class="d-block mt-1">{{ $domain->verification_token }}</code>
                                <div class="d-flex gap-2 mt-3">
                                    <form method="POST" action="{{ route('user.funnels.domains.verify', $domain->id) }}">@csrf<button class="btn btn-sm btn-outline--base">Verify DNS</button></form>
                                    <form method="POST" action="{{ route('user.funnels.domains.destroy', $domain->id) }}" onsubmit="return confirm('Cancel this pending domain verification?')">@csrf @method('DELETE')<button class="btn btn-sm btn-link text-danger">Cancel</button></form>
                                </div>
                            @elseif(!$domain->cname_verified_at)
                                <p class="mb-1">Ownership is verified. Add the branded-tracking CNAME:</p>
                                <code>{{ $domain->hostname }} → {{ config('funnels.tracking_cname_target') }}</code>
                                <form method="POST" action="{{ route('user.funnels.domains.verify', $domain->id) }}" class="mt-3">@csrf<button class="btn btn-sm btn-outline--base">Check CNAME</button></form>
                            @else
                                <p class="mb-0 text-success"><i class="las la-link"></i> Branded tracking host is ready.</p>
                            @endif
                        </article>
                    @empty
                        <p class="empty-note">Your verified domains will appear here. DNS verification protects your tracking data from unauthorized origins.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-lg-7">
            <section class="analytics-panel h-100">
                <div class="panel-heading">
                    <div><span class="panel-kicker">Step 2</span><h5>Create an external-hosted funnel</h5></div>
                    <i class="las la-route panel-icon"></i>
                </div>
                <form method="POST" action="{{ route('user.funnels.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Funnel name</label><input class="form-control form--control" name="name" placeholder="Winter membership offer" required></div>
                        <div class="col-md-6"><label class="form-label">Goal</label><select class="form-select form--control" name="goal_type"><option value="lead">Lead</option><option value="signup">Sign-up</option><option value="purchase">Purchase</option><option value="appointment">Appointment</option></select></div>
                        <div class="col-12"><label class="form-label">Verified domain</label><select class="form-select form--control" name="funnel_domain_id" required><option value="">Select a verified domain</option>@foreach($domains->whereNotNull('verified_at') as $domain)<option value="{{ $domain->id }}">{{ $domain->hostname }}</option>@endforeach</select></div>
                        <div class="col-12"><label class="form-label">Landing-page URL</label><input class="form-control form--control" name="landing_url" placeholder="https://offers.example.com/winter-membership" required></div>
                    </div>
                    <button class="btn btn--base mt-3">Generate tracking link</button>
                </form>

                @foreach($funnels as $funnel)
                    @if(session('funnel_link_' . $funnel->id))
                        <div class="new-link-card">
                            <span class="panel-kicker">New tracking link</span>
                            <div class="new-link-card__url"><code>{{ session('funnel_link_' . $funnel->id) }}</code><button type="button" class="copy-link" data-copy="{{ session('funnel_link_' . $funnel->id) }}" aria-label="Copy tracking link"><i class="las la-copy"></i></button></div>
                            <p>Use this link only in permission-based campaigns.</p>
                        </div>
                    @endif
                @endforeach

                <div class="funnel-list mt-4">
                    @forelse($funnels as $funnel)
                        <article class="funnel-row">
                            <div><strong>{{ $funnel->name }}</strong><span>{{ ucfirst($funnel->goal_type) }} · {{ $funnel->domain?->hostname }}</span></div>
                            <div class="funnel-row__metrics"><span>{{ number_format($funnel->metrics['clicks']) }} clicks</span><span>{{ number_format($funnel->metrics['leads']) }} leads</span></div>
                            @if($funnel->domain?->cname_verified_at && $funnel->links->first()?->slug)<code>https://{{ $funnel->domain->hostname }}/s/{{ $funnel->links->first()->slug }}</code>@else <small>Activate the tracking CNAME to use a branded link.</small>@endif
                        </article>
                    @empty
                        <p class="empty-note">Create a funnel after verifying a domain to generate your first campaign tracking link.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="col-xl-8">
            <section class="analytics-panel h-100">
                <div class="panel-heading">
                    <div><span class="panel-kicker">Recipient engagement</span><h5>Permission-based link activity</h5></div>
                    <a href="{{ route('user.funnels.leads') }}" class="btn btn-sm btn-outline--base">View leads vault</a>
                </div>
                <div class="table-responsive">
                    <table class="table analytics-table align-middle mb-0">
                        <thead><tr><th>Visitor</th><th>Funnel</th><th>Clicked</th><th>Goal</th><th>Tracking</th></tr></thead>
                        <tbody>
                            @forelse($recentEngagement as $event)
                                <tr>
                                    <td><span class="masked-id"><i class="las la-user-shield"></i> {{ substr($event->recipient_hash ?: $event->visitor_hash, 0, 10) }}...</span></td>
                                    <td>{{ $event->funnel_name }}</td>
                                    <td>{{ $event->clicked_at->diffForHumans() }}</td>
                                    <td><span class="status-pill status-pill--success">{{ ucfirst($event->goal_type) }}</span></td>
                                    <td><span class="tracking-state"><i class="las la-link"></i> Recorded</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No tracked engagement yet. Analytics appear after a verified funnel link is used.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="privacy-note"><i class="las la-info-circle"></i> Visitor and recipient identifiers are hashed by default. Analytics are limited to verified domains and approved campaign links.</p>
            </section>
        </div>

        <div class="col-xl-4">
            <section class="analytics-panel analytics-panel--chart h-100">
                <div class="panel-heading"><div><span class="panel-kicker">Campaign analytics</span><h5>Last 14 days</h5></div><i class="las la-chart-line panel-icon"></i></div>
                <div class="metric-grid">
                    <div><strong>{{ number_format($analytics['clicks']) }}</strong><span>Link clicks</span></div>
                    <div><strong>{{ number_format($analytics['conversion_rate'], 1) }}%</strong><span>Conversion rate</span></div>
                    <div><strong>{{ number_format($analytics['leads']) }}</strong><span>Recorded leads</span></div>
                </div>
                <div class="analytics-chart" aria-label="Tracking clicks over the last fourteen days">
                    <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" preserveAspectRatio="none" role="img">
                        <defs><linearGradient id="clickFill" x1="0" x2="0" y1="0" y2="1"><stop offset="0%" stop-color="var(--base)" stop-opacity=".32"/><stop offset="100%" stop-color="var(--base)" stop-opacity="0"/></linearGradient></defs>
                        <line x1="0" y1="{{ $chartHeight - 1 }}" x2="{{ $chartWidth }}" y2="{{ $chartHeight - 1 }}" class="chart-axis"/>
                        <polygon points="0,{{ $chartHeight }} {{ $points }} {{ $chartWidth }},{{ $chartHeight }}" fill="url(#clickFill)"/>
                        <polyline points="{{ $points }}" fill="none" class="chart-line"/>
                        @foreach($clickSeries as $index => $day)
                            @php
                                $coordinates = explode(',', explode(' ', $points)[$index]);
                            @endphp
                            <circle cx="{{ $coordinates[0] }}" cy="{{ $coordinates[1] }}" r="4" class="chart-point"><title>{{ $day['label'] }}: {{ $day['count'] }} clicks</title></circle>
                        @endforeach
                    </svg>
                </div>
                <div class="chart-footer"><span><i class="las la-globe"></i> {{ $analytics['verified_domains'] }} verified domains</span><span><i class="las la-link"></i> {{ $analytics['active_links'] }} active links</span></div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .funnels-workspace { --panel-border: #dce6f5; --muted: #64748b; }
    .funnels-hero, .analytics-panel { border: 1px solid var(--panel-border); border-radius: 18px; background: #fff; box-shadow: 0 14px 34px rgba(15, 35, 73, .06); }
    .funnels-hero { padding: 26px 30px; display: flex; justify-content: space-between; gap: 24px; align-items: center; margin-bottom: 24px; background: radial-gradient(circle at 95% 0%, rgba(var(--base-rgb), .16), transparent 35%), #fff; }
    .funnels-hero h3, .panel-heading h5 { color: #102867; margin: 3px 0 6px; font-weight: 700; }
    .funnels-hero p { color: var(--muted); margin: 0; max-width: 760px; }
    .funnels-eyebrow, .panel-kicker { color: var(--base); display: block; font-size: 11px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
    .funnels-hero__meta { display: grid; gap: 8px; min-width: max-content; color: #1e3c7b; font-size: 13px; font-weight: 600; }
    .funnels-hero__meta i, .privacy-note i, .chart-footer i, .tracking-state i { color: var(--base); font-size: 17px; vertical-align: -1px; }
    .analytics-panel { padding: 23px; }
    .panel-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 18px; }
    .panel-heading h5 { font-size: 19px; }
    .panel-icon { color: var(--base); background: rgba(var(--base-rgb), .12); border-radius: 12px; font-size: 22px; padding: 8px; }
    .domain-field { position: relative; }
    .domain-field .form-control { padding-right: 105px; }
    .domain-field__status { position: absolute; right: 10px; top: 9px; color: #187d2e; background: #dcf7e4; border-radius: 7px; padding: 4px 8px; font-size: 12px; font-weight: 700; }
    .domain-list { margin-top: 20px; display: grid; gap: 11px; }
    .domain-record { border-top: 1px solid #e9eef7; padding-top: 13px; color: var(--muted); font-size: 13px; }
    .domain-record__top { display: flex; justify-content: space-between; align-items: center; gap: 8px; color: #172c5d; margin-bottom: 7px; }
    .domain-record p { margin: 0 0 7px; }
    code { overflow-wrap: anywhere; }
    .status-pill { display: inline-flex; align-items: center; gap: 4px; border-radius: 7px; padding: 4px 8px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .status-pill--success { color: #197332; background: #dcf7e4; }
    .status-pill--pending { color: #9a5b00; background: #fff0d6; }
    .empty-note { color: var(--muted); font-size: 14px; margin: 0; }
    .new-link-card { margin-top: 20px; background: linear-gradient(135deg, #102c65, #1f4f93); border-radius: 13px; color: #fff; padding: 17px; }
    .new-link-card .panel-kicker { color: #c9e5ff; }
    .new-link-card__url { display: flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,.55); border-radius: 9px; padding: 8px 10px; margin: 8px 0 5px; }
    .new-link-card code { color: #fff; flex: 1; }
    .new-link-card p { margin: 0; color: #d9e8ff; font-size: 13px; }
    .copy-link { border: 0; background: transparent; color: #fff; font-size: 19px; }
    .funnel-list { border-top: 1px solid #e8edf5; display: grid; gap: 0; }
    .funnel-row { display: grid; grid-template-columns: 1.1fr auto; gap: 8px 16px; padding: 13px 0; border-bottom: 1px solid #e8edf5; color: #182d5c; }
    .funnel-row > div span, .funnel-row small { display: block; color: var(--muted); font-size: 12px; margin-top: 2px; }
    .funnel-row__metrics { text-align: right; font-size: 13px; font-weight: 700; }
    .funnel-row code { grid-column: 1 / -1; color: #24519d; font-size: 12px; }
    .analytics-table thead th { border-bottom-color: #dce6f5; color: #18336f; font-size: 11px; letter-spacing: .04em; text-transform: uppercase; white-space: nowrap; }
    .analytics-table td { border-bottom-color: #eef2f8; color: #314467; font-size: 13px; }
    .masked-id { color: #243d73; font-weight: 700; }
    .masked-id i { color: var(--base); }
    .tracking-state { color: #197332; font-weight: 700; }
    .privacy-note { color: var(--muted); font-size: 12px; margin: 14px 0 0; }
    .metric-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 9px; }
    .metric-grid > div { border: 1px solid #d9e5f6; border-radius: 10px; padding: 10px; background: #f8fbff; }
    .metric-grid strong { display: block; color: #172e65; font-size: 22px; line-height: 1; }
    .metric-grid span { color: #526987; display: block; font-size: 11px; margin-top: 5px; }
    .analytics-chart { height: 182px; margin-top: 18px; }
    .analytics-chart svg { height: 100%; width: 100%; overflow: visible; }
    .chart-axis { stroke: #dce6f5; stroke-width: 1; }
    .chart-line { stroke: var(--base); stroke-linecap: round; stroke-linejoin: round; stroke-width: 4; vector-effect: non-scaling-stroke; }
    .chart-point { fill: #fff; stroke: var(--base); stroke-width: 3; vector-effect: non-scaling-stroke; }
    .chart-footer { border-top: 1px solid #e8edf5; display: flex; gap: 16px; justify-content: space-between; padding-top: 13px; color: #253b68; font-size: 12px; font-weight: 600; }
    @media (max-width: 767px) { .funnels-hero { align-items: flex-start; flex-direction: column; padding: 22px; } .funnels-hero__meta { min-width: 0; } .analytics-panel { padding: 18px; } .metric-grid { grid-template-columns: 1fr; } .funnel-row { grid-template-columns: 1fr; } .funnel-row__metrics { text-align: left; } .chart-footer { align-items: flex-start; flex-direction: column; gap: 6px; } }
</style>
@endpush

@push('script')
<script>
document.querySelectorAll('.copy-link').forEach((button) => button.addEventListener('click', async () => {
    await navigator.clipboard.writeText(button.dataset.copy);
    const icon = button.innerHTML;
    button.innerHTML = '<i class="las la-check"></i>';
    setTimeout(() => button.innerHTML = icon, 1400);
}));
</script>
@endpush
