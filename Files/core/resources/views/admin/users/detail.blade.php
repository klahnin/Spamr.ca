@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">

                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="7" link="{{ route('admin.report.transaction', $user->id) }}" title="Balance" icon="las la-money-bill-wave-alt" value="{{ showAmount($user->balance) }}" bg="indigo" type="2" />
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="7" link="{{ route('admin.deposit.list', $user->id) }}" title="Deposits" icon="las la-wallet" value="{{ showAmount($totalDeposit) }}" bg="8" type="2" />
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="7" link="#" title="Purchases" icon="la la-cart-plus" value="{{ showAmount($totalPurchase) }}" bg="6" type="2" />
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <x-widget style="7" link="{{ route('admin.report.transaction', $user->id) }}" title="Transactions" icon="las la-exchange-alt" value="{{ $totalTransaction }}" bg="17" type="2" />
                </div>

            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.report.login.history') }}?search={{ $user->username }}" class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.users.notification.log', $user->id) }}" class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                <div class="flex-fill">
                    @if ($user->status == Status::USER_ACTIVE)
                        <button type="button" class="btn btn--warning btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-ban"></i>@lang('Ban User')
                        </button>
                    @else
                        <button type="button" class="btn btn--success btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-undo"></i>@lang('Unban User')
                        </button>
                    @endif
                </div>
            </div>

            @php($kyc = $user->kycVerification)
            <div class="card mt-30">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">@lang('KYC Verification')</h5>
                    @if (!$kyc || $kyc->status === 'not_required')
                        <span class="badge badge--dark">@lang('Not Required')</span>
                    @elseif ($kyc->status === 'required')
                        <span class="badge badge--warning">@lang('Awaiting Submission')</span>
                    @elseif ($kyc->status === 'submitted')
                        <span class="badge badge--info">@lang('Awaiting Review')</span>
                    @elseif ($kyc->status === 'verified')
                        <span class="badge badge--success">@lang('Verified')</span>
                    @else
                        <span class="badge badge--danger">@lang('Rejected')</span>
                    @endif
                </div>
                <div class="card-body">
                    @if ($kyc && $kyc->reason)
                        <p><strong>@lang('Reason'):</strong> {{ $kyc->reason }}</p>
                    @endif

                    @if ($kyc && $kyc->status === 'submitted')
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @if ($kyc->verification_type === 'business')
                                <a class="btn btn--info btn-sm" href="{{ route('admin.users.kyc.file', [$user->id, 'business']) }}"><i class="las la-building"></i> @lang('View business document')</a>
                                <a class="btn btn--info btn-sm" href="{{ route('admin.users.kyc.file', [$user->id, 'director_id']) }}"><i class="las la-id-card"></i> @lang('View director ID')</a>
                            @else
                                <a class="btn btn--info btn-sm" href="{{ route('admin.users.kyc.file', [$user->id, 'id']) }}"><i class="las la-id-card"></i> @lang('View ID front')</a>
                                <a class="btn btn--info btn-sm" href="{{ route('admin.users.kyc.file', [$user->id, 'selfie']) }}"><i class="las la-id-card"></i> @lang('View ID back')</a>
                            @endif
                        </div>
                        @if ($kyc->verification_data)
                            <div class="table-responsive mb-4">
                                <table class="table table--light">
                                    <tbody>
                                        @foreach ($kyc->verification_data as $field => $value)
                                            <tr><th class="text-capitalize">{{ str_replace('_', ' ', $field) }}</th><td>{{ $value }}</td></tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admin.users.kyc.review', $user->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('Decision')</label>
                                        <select name="decision" class="form-control" required>
                                            <option value="verified">@lang('Verify and unlock user')</option>
                                            <option value="rejected">@lang('Reject and request resubmission')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>@lang('Review note') <small class="text-muted">@lang('(shown to the user only if rejected)')</small></label>
                                        <textarea name="admin_note" class="form-control" rows="2" maxlength="2000"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn--success">@lang('Save KYC decision')</button>
                        </form>
                    @elseif ($kyc && $kyc->status === 'required')
                        <p class="text-muted mb-0">@lang('The account is locked to the KYC page until the user submits their documents.')</p>
                    @else
                        @if ($kyc && $kyc->status === 'rejected' && $kyc->admin_note)
                            <p><strong>@lang('Last review note'):</strong> {{ $kyc->admin_note }}</p>
                        @endif
                        <form method="POST" action="{{ route('admin.users.kyc.require', $user->id) }}">
                            @csrf
                            <div class="form-group">
                                <label>@lang('Reason for requiring KYC')</label>
                                <textarea name="reason" class="form-control" rows="3" maxlength="1000" required placeholder="@lang('Example: We need to verify account activity before continuing.')"></textarea>
                            </div>
                            <button type="submit" class="btn btn--warning">@lang('Require KYC and lock account')</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required value="{{ $user->firstname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required value="{{ $user->lastname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number')</label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code">+{{ $user->dial_code }}</span>
                                        <input type="number" name="mobile" value="{{ $user->mobile }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{ $user->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city" value="{{ $user->city }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state" value="{{ $user->state }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip" value="{{ $user->zip }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select name="country" class="form-control select2">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}" @selected($user->country_code == $key)>
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Email Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev" @if ($user->ev) checked @endif>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Mobile Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv" @if ($user->sv) checked @endif>
                                </div>
                            </div>
                            @php($hasSubmittedCompliance = (bool) $user->complianceProfile)
                            @php($hasAdminComplianceOverride = (bool) $user->complianceOverride)
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Compliance Onboarding')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Completed')" data-off="@lang('Incomplete')" name="compliance_completed" @checked($hasSubmittedCompliance || $hasAdminComplianceOverride) @disabled($hasSubmittedCompliance)>
                                    @if ($hasSubmittedCompliance)
                                        <small class="text-muted">@lang('Completed by the user submission')</small>
                                    @else
                                        <small class="text-muted">@lang('Manual administrator completion')</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.add.sub.balance', $user->id) }}" class="balanceAddSub disableSubmission" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($user->status == Status::USER_ACTIVE)
                            @lang('Ban User')
                        @else
                            @lang('Unban User')
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == Status::USER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $user->ban_reason }}</p>
                            <h4 class="text-center mt-3">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($user->status == Status::USER_ACTIVE)
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                            <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.users.login', $user->id) }}" target="_blank" class="btn btn-sm btn-outline--primary"><i class="las la-sign-in-alt"></i>@lang('Login as User')</a>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"


            $('.bal-btn').on('click', function() {

                $('.balanceAddSub')[0].reset();

                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

        })(jQuery);
    </script>
@endpush
