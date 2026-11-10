@extends('Template::layouts.master')
@section('content')
<div class="card custom--card"><div class="card-body"><div class="d-flex justify-content-between align-items-center gap-3 mb-3"><div><h4 class="mb-1">Spamr Leads Vault</h4><p class="text-muted mb-0">Encrypted, consented form submissions from verified funnels.</p></div><form class="d-flex gap-2"><input class="form-control form--control" name="search" value="{{ request('search') }}" placeholder="Search decrypted leads"><button class="btn btn--base">Search</button></form></div>
<div class="table-responsive"><table class="table"><thead><tr><th>Submitted</th><th>Funnel</th><th>Lead fields</th><th>Status</th></tr></thead><tbody>@forelse($leads as $lead)<tr><td>{{ $lead->submitted_at?->format('M j, Y H:i') }}</td><td>{{ $lead->funnel?->name }}</td><td>@foreach($lead->fields ?? [] as $key=>$value)<div><strong>{{ ucfirst(str_replace('_',' ',$key)) }}:</strong> {{ \Illuminate\Support\Str::limit($value,100) }}</div>@endforeach</td><td><span class="badge badge--primary">{{ ucfirst($lead->status) }}</span></td></tr>@empty<tr><td colspan="4" class="text-center text-muted">No leads submitted yet.</td></tr>@endforelse</tbody></table></div>
@if($leads instanceof \Illuminate\Contracts\Pagination\Paginator){{ $leads->links() }}@endif
</div></div>
@endsection
