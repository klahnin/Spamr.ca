@extends('templates.basic.layouts.master')
@section('content')
<div class="card"><div class="card-body p-4">
 <h4>KYC verification required</h4>
 @if($kyc->reason)<p class="text-muted">Reason: {{ $kyc->reason }}</p>@endif
 @if($kyc->status === 'submitted')<div class="alert alert-info">Your documents are under review. Access will be restored after verification.</div>
 @elseif($kyc->status === 'verified')<div class="alert alert-success">Your KYC has been verified.</div>
 @else
  @if($kyc->status === 'rejected' && $kyc->admin_note)<div class="alert alert-danger">{{ $kyc->admin_note }}</div>@endif
  <p>Upload a government-issued ID and a clear selfie. Your documents are securely submitted for manual review.</p>
  <form method="POST" action="{{ route('user.kyc.submit') }}" enctype="multipart/form-data">@csrf
   <div class="form-group"><label>Government-issued ID</label><input class="form-control" type="file" name="id_document" accept="image/png,image/jpeg,application/pdf" required></div>
   <div class="form-group"><label>Selfie</label><input class="form-control" type="file" name="selfie" accept="image/png,image/jpeg" required></div>
   <div class="form-group form-check"><input class="form-check-input" type="checkbox" name="consent" id="kycConsent" required><label class="form-check-label" for="kycConsent">I consent to Spamr processing these documents solely to verify my identity.</label></div>
   <button class="btn btn--base" type="submit">Submit for review</button>
  </form>
 @endif
</div></div>
@endsection
