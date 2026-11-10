@extends('admin.layouts.app')

@push('style-lib')
    @vite('resources/ts/dashboard.tsx')
@endpush

@section('panel')
    <div data-react-dashboard data-dashboard-kind="admin" data-dashboard-name="{{ auth('admin')->user()->name }}" data-dashboard-detail="Your existing Blade administration tools stay in place while new dashboard modules can use React."></div>
    <section class="admin-dashboard-overview">
        <div class="admin-welcome-card">
            <div class="admin-welcome-icon"><i class="las la-shield-alt"></i></div>
            <div>
                <span class="admin-eyebrow">@lang('Spamr administration')</span>
                <h2>@lang('Control Center')</h2>
                <p>@lang('Monitor users, Android gateways, messaging activity, and platform revenue from one place.')</p>
            </div>
            <a class="admin-welcome-action" href="{{ route('admin.device.index') }}"><i class="las la-mobile"></i> @lang('Manage devices')</a>
        </div>

        <div class="admin-section-heading">
            <div><h3>@lang('Platform overview')</h3><p>@lang('Live totals across your Spamr workspace')</p></div>
            <button class="admin-cron-link" data-bs-toggle="modal" data-bs-target="#cronModal"><i class="las la-server"></i> @lang('Cron setup')</button>
        </div>

        <div class="admin-metric-grid admin-metric-grid--primary">
            <a class="admin-metric-card tone-violet" href="{{ route('admin.users.all') }}"><span class="admin-metric-icon"><i class="las la-users"></i></span><span class="admin-metric-copy"><small>@lang('Total users')</small><strong>{{ $widget['total_users'] }}</strong><em>@lang('All accounts')</em></span></a>
            <a class="admin-metric-card tone-green" href="{{ route('admin.users.active') }}"><span class="admin-metric-icon"><i class="las la-user-check"></i></span><span class="admin-metric-copy"><small>@lang('Active users')</small><strong>{{ $widget['verified_users'] }}</strong><em>@lang('Verified & active')</em></span></a>
            <a class="admin-metric-card tone-red" href="{{ route('admin.users.email.unverified') }}"><span class="admin-metric-icon"><i class="lar la-envelope"></i></span><span class="admin-metric-copy"><small>@lang('Email verification')</small><strong>{{ $widget['email_unverified_users'] }}</strong><em>@lang('Needs attention')</em></span></a>
            <a class="admin-metric-card tone-orange" href="{{ route('admin.users.mobile.unverified') }}"><span class="admin-metric-icon"><i class="las la-comment-slash"></i></span><span class="admin-metric-copy"><small>@lang('Mobile verification')</small><strong>{{ $widget['mobile_unverified_users'] }}</strong><em>@lang('Needs attention')</em></span></a>
        </div>

        <div class="admin-metric-grid">
            <a class="admin-metric-card compact tone-blue" href="{{ route('admin.device.index') }}"><span class="admin-metric-icon"><i class="las la-mobile"></i></span><span class="admin-metric-copy"><small>@lang('Android devices')</small><strong>{{ @$device['total'] }}</strong><em>@lang('Paired gateways')</em></span></a>
            <a class="admin-metric-card compact tone-green" href="{{ route('admin.device.index', ['status' => Status::CONNECTED]) }}"><span class="admin-metric-icon"><i class="las la-check-circle"></i></span><span class="admin-metric-copy"><small>@lang('Connected')</small><strong>{{ @$device['connected'] }}</strong><em>@lang('Online gateways')</em></span></a>
            <a class="admin-metric-card compact tone-cyan" href="{{ route('admin.contact.index') }}"><span class="admin-metric-icon"><i class="las la-address-book"></i></span><span class="admin-metric-copy"><small>@lang('Contacts')</small><strong>{{ @$contact['total'] }}</strong><em>@lang('Address book entries')</em></span></a>
            <a class="admin-metric-card compact tone-slate" href="{{ route('admin.contact.index', ['status' => Status::CONNECTED]) }}"><span class="admin-metric-icon"><i class="las la-check-double"></i></span><span class="admin-metric-copy"><small>@lang('Active contacts')</small><strong>{{ @$contact['active'] }}</strong><em>@lang('Ready to message')</em></span></a>
            <a class="admin-metric-card compact tone-violet" href="{{ route('admin.plan.list') }}"><span class="admin-metric-icon"><i class="far fa-file-alt"></i></span><span class="admin-metric-copy"><small>@lang('Plans')</small><strong>{{ @$plan['total'] }}</strong><em>{{ @$plan['active'] }} @lang('active')</em></span></a>
            <a class="admin-metric-card compact tone-cyan" href="{{ route('admin.device.index') }}"><span class="admin-metric-icon"><i class="las la-bullhorn"></i></span><span class="admin-metric-copy"><small>@lang('Campaigns')</small><strong>{{ @$campaign }}</strong><em>@lang('Total campaigns')</em></span></a>
            <a class="admin-metric-card compact tone-orange" href="{{ route('admin.batch.index') }}"><span class="admin-metric-icon"><i class="las la-layer-group"></i></span><span class="admin-metric-copy"><small>@lang('Batches')</small><strong>{{ @$batch }}</strong><em>@lang('Message batches')</em></span></a>
        </div>
    </section>

    <div class="row gy-4 mb-4 admin-summary-panels">
        <div class="col-xxl-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="admin-panel-title"><div><h5>@lang('Today’s SMS')</h5><p>@lang('Current message delivery activity')</p></div><i class="las la-sms"></i></div>
                    <div class="widget-card-wrapper">
                        <div class="widget-card bg--primary">
                            <a href="{{ route('admin.sms.index') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-sms"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $sms['total'] }}
                                    </h6>
                                    <p class="widget-card-title">@lang('Total SMS')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--warning">
                            <a href="{{ route('admin.sms.index') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $sms['scheduled'] }}</h6>
                                    <p class="widget-card-title">@lang('Scheduled SMS')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--success">
                            <a href="{{ route('admin.sms.index') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-check-circle"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $sms['delivered'] }}</h6>
                                    <p class="widget-card-title">@lang('Delivered SMS')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--danger">
                            <a href="{{ route('admin.sms.index') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="las la-times-circle"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $sms['failed'] }}
                                    </h6>
                                    <p class="widget-card-title">@lang('Failed SMS')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="admin-panel-title"><div><h5>@lang('Deposits')</h5><p>@lang('Payment and purchase totals')</p></div><i class="las la-wallet"></i></div>
                    <div class="widget-card-wrapper">

                        <div class="widget-card bg--success">
                            <a href="{{ route('admin.deposit.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($deposit['total_deposit_amount']) }}</h6>
                                    <p class="widget-card-title">@lang('Total Deposited')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--warning">
                            <a href="{{ route('admin.deposit.pending') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-spinner"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $deposit['total_deposit_pending'] }}</h6>
                                    <p class="widget-card-title">@lang('Pending Deposits')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--danger">
                            <a href="{{ route('admin.deposit.rejected') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ $deposit['total_deposit_rejected'] }}</h6>
                                    <p class="widget-card-title">@lang('Rejected Deposits')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                        <div class="widget-card bg--primary">
                            <a href="{{ route('admin.deposit.list') }}" class="widget-card-link"></a>
                            <div class="widget-card-left">
                                <div class="widget-card-icon">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div class="widget-card-content">
                                    <h6 class="widget-card-amount">{{ showAmount($deposit['total_deposit_charge']) }}</h6>
                                    <p class="widget-card-title">@lang('Deposited Charge')</p>
                                </div>
                            </div>
                            <span class="widget-card-arrow">
                                <i class="las la-angle-right"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">@lang('Deposit & Purchase Report')</h5>

                        <div id="dwDatePicker" class="border p-1 cursor-pointer rounded">
                            <i class="la la-calendar"></i>&nbsp;
                            <span></span> <i class="la la-caret-down"></i>
                        </div>
                    </div>
                    <div id="dArea"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">@lang('Transactions Report')</h5>

                        <div id="trxDatePicker" class="border p-1 cursor-pointer rounded">
                            <i class="la la-calendar"></i>&nbsp;
                            <span></span> <i class="la la-caret-down"></i>
                        </div>
                    </div>

                    <div id="transactionChartArea"></div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.cron_modal')
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm" data-bs-toggle="modal" data-bs-target="#cronModal">
        <i class="las la-server"></i>@lang('Cron Setup')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        "use strict";

        const start = moment().subtract(14, 'days');
        const end = moment();

        const dateRangeOptions = {
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
                'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            },
            maxDate: moment()
        }

        const changeDatePickerText = (element, startDate, endDate) => {
            $(element).html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        }

        let dwChart = barChart(
            document.querySelector("#dArea"),
            `{{ __(gs('cur_text')) }}`,
            [{
                    name: 'Deposited',
                    data: []
                },
                {
                    name: 'Purchased',
                    data: []
                }
            ],
            [],
        );

        let trxChart = lineChart(
            document.querySelector("#transactionChartArea"),
            [{
                    name: "Plus Transactions",
                    data: []
                },
                {
                    name: "Minus Transactions",
                    data: []
                }
            ],
            []
        );


        const depositPurchaseChart = (startDate, endDate) => {

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }

            const url = `{{ route('admin.chart.deposit.purchase') }}`;

            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {
                        dwChart.updateSeries(data.data);
                        dwChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }

        const transactionChart = (startDate, endDate) => {

            const data = {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            }

            const url = `{{ route('admin.chart.transaction') }}`;


            $.get(url, data,
                function(data, status) {
                    if (status == 'success') {

                        trxChart.updateSeries(data.data);
                        trxChart.updateOptions({
                            xaxis: {
                                categories: data.created_on,
                            }
                        });
                    }
                }
            );
        }



        $('#dwDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#dwDatePicker span',
            start, end));
        $('#trxDatePicker').daterangepicker(dateRangeOptions, (start, end) => changeDatePickerText('#trxDatePicker span',
            start, end));

        changeDatePickerText('#dwDatePicker span', start, end);
        changeDatePickerText('#trxDatePicker span', start, end);

        depositPurchaseChart(start, end);
        transactionChart(start, end);

        $('#dwDatePicker').on('apply.daterangepicker', (event, picker) => depositPurchaseChart(picker.startDate, picker
            .endDate));
        $('#trxDatePicker').on('apply.daterangepicker', (event, picker) => transactionChart(picker.startDate, picker
            .endDate));
    </script>
@endpush
@push('style')
    <style>
        .admin-dashboard-overview { margin-bottom: 1.5rem; }
        .admin-welcome-card { display:flex; align-items:center; gap:16px; padding:18px 20px; margin-bottom:22px; border:1px solid #ffc8a6; border-radius:16px; background:linear-gradient(115deg,#fffaf5 0%,#fff 53%,#fff1e8 100%); box-shadow:0 10px 26px rgba(242,91,37,.07); }
        .admin-welcome-icon { display:grid; place-items:center; width:48px; height:48px; flex:0 0 48px; border-radius:13px; color:#fff; background:linear-gradient(135deg,#ff7b32,#f05222); font-size:25px; }
        .admin-eyebrow { display:block; margin-bottom:1px; color:#f05222; font-size:10px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
        .admin-welcome-card h2 { color:#112d58; font-size:18px; font-weight:700; }
        .admin-welcome-card p,.admin-section-heading p,.admin-panel-title p { margin:1px 0 0; color:#6f82a0; font-size:11px; }
        .admin-welcome-action { display:inline-flex; align-items:center; gap:6px; margin-left:auto; padding:9px 13px; border-radius:9px; background:#f05222; color:#fff; font-size:11px; font-weight:600; box-shadow:0 6px 14px rgba(240,82,34,.18); }
        .admin-welcome-action:hover { color:#fff; background:#db4318; }
        .admin-section-heading { display:flex; align-items:center; justify-content:space-between; margin:0 0 13px; }
        .admin-section-heading h3 { color:#102f5b; font-size:20px; font-weight:700; }
        .admin-cron-link { border:1px solid #d5dfed; border-radius:9px; padding:8px 11px; background:#fff; color:#385173; font-size:11px; font-weight:600; }
        .admin-cron-link:hover { border-color:#f05222; color:#f05222; }
        .admin-metric-grid { display:grid; grid-template-columns:repeat(7,minmax(0,1fr)); gap:11px; margin-bottom:11px; }
        .admin-metric-grid--primary { grid-template-columns:repeat(4,minmax(0,1fr)); margin-bottom:15px; }
        .admin-metric-card { display:flex; gap:11px; min-width:0; padding:16px; border:1px solid #dbe5f2; border-radius:14px; background:#fff; box-shadow:0 7px 18px rgba(41,73,121,.05); transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease; }
        .admin-metric-card:hover { transform:translateY(-2px); border-color:#ffc8a6; box-shadow:0 11px 24px rgba(41,73,121,.1); }
        .admin-metric-card.compact { display:block; padding:13px; }
        .admin-metric-card.compact .admin-metric-icon { float:right; width:30px; height:30px; border-radius:9px; font-size:16px; }
        .admin-metric-icon { display:grid; place-items:center; width:40px; height:40px; flex:0 0 40px; border-radius:11px; font-size:20px; }
        .admin-metric-copy { display:flex; min-width:0; flex-direction:column; }
        .admin-metric-copy small { overflow:hidden; color:#607697; font-size:10px; text-overflow:ellipsis; white-space:nowrap; }
        .admin-metric-copy strong { margin:2px 0; color:#102f5b; font-size:24px; font-weight:700; line-height:1.1; }
        .admin-metric-copy em { color:#90a0b7; font-size:9px; font-style:normal; white-space:nowrap; }
        .tone-violet .admin-metric-icon { background:#ede9fe; color:#6c4ff6; }.tone-green .admin-metric-icon { background:#ddf8eb; color:#00a86b; }.tone-red .admin-metric-icon { background:#ffe5e5; color:#f0444c; }.tone-orange .admin-metric-icon { background:#fff0df; color:#f46a22; }.tone-blue .admin-metric-icon { background:#e1efff; color:#159ce8; }.tone-cyan .admin-metric-icon { background:#dff7fa; color:#11a8bc; }.tone-slate .admin-metric-icon { background:#edf0f5; color:#4f6079; }
        .admin-summary-panels .card,.row.mb-none-30 .card { border:1px solid #dce6f2; border-radius:15px; box-shadow:0 8px 24px rgba(41,73,121,.06); }
        .admin-summary-panels .card-body { padding:17px 19px; }
        .admin-panel-title { display:flex; align-items:flex-start; justify-content:space-between; padding-bottom:13px; margin-bottom:2px; border-bottom:1px solid #e7eef6; }
        .admin-panel-title h5 { color:#102f5b; font-size:15px; font-weight:700; }.admin-panel-title>i { color:#f05222; font-size:22px; }
        .admin-summary-panels .widget-card-wrapper { margin:0; }.admin-summary-panels .widget-card { min-height:67px; background:transparent!important; }.admin-summary-panels .widget-card-icon { box-shadow:none; }.admin-summary-panels .widget-card-amount { color:#102f5b; font-weight:700; }.admin-summary-panels .widget-card-title { color:#8596b0; }
        @media (max-width:1500px) { .admin-metric-grid { grid-template-columns:repeat(4,minmax(0,1fr)); } }
        @media (max-width:991px) { .admin-metric-grid,.admin-metric-grid--primary { grid-template-columns:repeat(2,minmax(0,1fr)); }.admin-welcome-action { margin-left:0; }.admin-welcome-card { flex-wrap:wrap; } }
        @media (max-width:575px) { .admin-metric-grid,.admin-metric-grid--primary { grid-template-columns:1fr; }.admin-section-heading { align-items:flex-start; gap:10px; }.admin-welcome-action { width:100%; justify-content:center; }.admin-welcome-card { padding:15px; } }
        .apexcharts-menu {
            min-width: 120px !important;
        }
    </style>
@endpush
