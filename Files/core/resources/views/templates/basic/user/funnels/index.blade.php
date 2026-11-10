@extends('Template::layouts.master')
@section('content')
<div class="row gy-4">
 @include('Template::partials.alert_box')
 <div class="col-12"><div class="card custom--card"><div class="card-body"><h4>Spamr Funnels</h4><p class="text-muted mb-0">Track permission-based campaign links on your own verified website. Spamr does not need your hosting password.</p></div></div></div>
 <div class="col-lg-5"><div class="card custom--card"><div class="card-body"><h5>Add a verified domain</h5><form method="POST" action="{{ route('user.funnels.domains.store') }}">@csrf
  <label class="form-label">Domain</label><input class="form-control form--control" name="hostname" placeholder="offers.example.com" required>
  <button class="btn btn--base mt-3 w-100">Create DNS verification record</button></form>
  @foreach($domains as $domain)<hr><div class="small"><strong>{{ $domain->hostname }}</strong><br>
   @if($domain->verified_at)<span class="text-success">✓ Verified {{ $domain->verified_at->diffForHumans() }}</span>
   @else <span class="text-warning">Pending DNS TXT verification</span><br><code>_spamr-verify.{{ $domain->hostname }}</code><br><code>{{ $domain->verification_token }}</code>
   <form method="POST" action="{{ route('user.funnels.domains.verify',$domain->id) }}">@csrf<button class="btn btn-sm btn-outline--base mt-2">Verify DNS record</button></form>@endif
  </div>@if($domain->verified_at && !$domain->cname_verified_at)<div class="small mt-2 text-warning">Add CNAME <code>{{ $domain->hostname }}</code> → <code>{{ config('funnels.tracking_cname_target') }}</code>, then verify again.</div>@elseif($domain->cname_verified_at)<div class="small mt-2 text-success">✓ Branded tracking host ready</div>@endif
  @endforeach
 </div></div></div>
 <div class="col-lg-7"><div class="card custom--card"><div class="card-body"><h5>Create external-hosted funnel</h5><form method="POST" action="{{ route('user.funnels.store') }}">@csrf
  <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Funnel name</label><input class="form-control form--control" name="name" required></div><div class="col-md-6 mb-3"><label class="form-label">Goal</label><select class="form-control form--control" name="goal_type"><option value="lead">Lead</option><option value="purchase">Purchase</option><option value="signup">Sign-up</option><option value="appointment">Appointment</option></select></div></div>
  <label class="form-label">Verified domain</label><select class="form-control form--control mb-3" name="funnel_domain_id" required><option value="">Select a verified domain</option>@foreach($domains->whereNotNull('verified_at') as $domain)<option value="{{ $domain->id }}">{{ $domain->hostname }}</option>@endforeach</select>
  <label class="form-label">Landing-page URL</label><input class="form-control form--control" name="landing_url" placeholder="https://offers.example.com/summer" required>
  <button class="btn btn--base mt-3">Create tracking link</button></form></div></div></div>
<div class="col-12"><div class="card custom--card"><div class="card-body"><h5>Your funnels</h5><div class="table-responsive"><table class="table"><thead><tr><th>Funnel</th><th>Performance</th><th>Landing page</th><th>Tracking script</th><th>Branded tracking link</th></tr></thead><tbody>@forelse($funnels as $funnel)<tr><td><strong>{{ $funnel->name }}</strong><br><small>{{ $funnel->goal_type }}</small></td><td><small>Clicks <strong>{{ $funnel->metrics['clicks'] }}</strong> · Unique <strong>{{ $funnel->metrics['unique_clicks'] }}</strong><br>Views <strong>{{ $funnel->metrics['views'] }}</strong> · Leads <strong>{{ $funnel->metrics['leads'] }}</strong></small></td><td class="text-break">{{ $funnel->landing_url }}</td><td><code>&lt;script src=&quot;{{ route('funnels.script',$funnel->public_id) }}&quot;&gt;&lt;/script&gt;</code></td><td>@if($funnel->domain?->cname_verified_at && $funnel->links->first()?->slug)<code>https://{{ $funnel->domain->hostname }}/s/{{ $funnel->links->first()->slug }}</code>@else <small>Verify the tracking-host CNAME to activate branded links.</small>@endif</td></tr>@empty<tr><td colspan="5" class="text-center text-muted">No funnels yet.</td></tr>@endforelse</tbody></table></div><p class="small text-muted mb-0">The script records only approved engagement events. Use <code>Spamr.trackLead({email: '…'})</code> for consented lead forms; password, payment, government-ID, seed phrase, and authentication fields are blocked.</p></div></div></div>
</div>
@endsection
