@extends('Template::layouts.master')

@section('content')
<section class="spamr-dashboard">
    <div class="spamr-status-banner {{ $widget['connected_device'] ? '' : 'is-empty' }}">
        <span class="status-icon"><i class="las la-mobile"></i></span>
        <div><strong>{{ $widget['connected_device'] ? $widget['connected_device'].' '.trans('Android Device(s) Connected & Operational') : trans('Connect Your First Android Device') }}</strong><p>{{ $widget['connected_device'] ? __('Your Spamr relay is online and ready to process messages.') : __('Pair an Android phone to start using Spamr as your SMS gateway.') }}</p></div>
        <a href="{{ route('user.device.index', ['pair' => 1]) }}" class="btn btn--base status-action"><i class="las la-qrcode"></i> @lang('Pair a Device')</a>
    </div>

    <div class="spamr-heading"><div><h2>@lang('Dashboard Overview')</h2><p>@lang('Real-time status of your linked Android SIM gateways and messaging queues.')</p></div><a href="{{ route('user.device.index', ['pair' => 1]) }}" class="pair-action"><i class="las la-qrcode"></i> @lang('Pair New Android Phone')</a></div>

    <div class="spamr-metrics">
        @php $metrics = [ ['Total Device','total_device','las la-mobile','info','Linked SIM nodes'], ['Connected','connected_device','las la-check-circle','success','Online & ready'], ['Disconnected','disconnected_device','las la-times-circle','danger','Offline nodes'], ['Sent SMS','sent','las la-check-double','success','Successfully delivered'], ['Initiated','initiated','las la-paper-plane','info','Processing'], ['Scheduled','scheduled','las la-clock','primary','Queued'], ['Failed SMS','failed','las la-exclamation-triangle','danger','Needs attention'] ]; @endphp
        @foreach($metrics as [$label, $key, $icon, $color, $caption])
            @php $value = in_array($key, ['total_device','connected_device','disconnected_device']) ? $widget[$key] : $widget['sms'][$key]; @endphp
            <div class="spamr-metric"><span>{{ __($label) }}</span><i class="{{ $icon }} text--{{ $color }}"></i><strong class="{{ in_array($color,['success','danger']) ? 'text--'.$color : '' }}">{{ $value }}</strong><small>{{ __($caption) }}</small></div>
        @endforeach
    </div>

    <div class="spamr-panel">
        <div class="spamr-panel-head"><div><h3><i class="las la-mobile text--base"></i> @lang('Active Android Hardware Gateways')</h3><p>@lang('Devices paired to the Spamr Cloud Engine.')</p></div><a href="{{ route('user.device.index') }}">@lang('Manage devices') <i class="las la-arrow-right"></i></a></div>
        <div class="spamr-devices" id="gateway-devices" aria-live="polite">
            @forelse($devices as $device)
                <article class="spamr-device {{ $device->status == Status::YES ? 'online' : '' }}">
                    <div class="device-top"><span class="device-icon"><i class="las la-mobile"></i></span><div><strong>{{ $device->device_name ?: __('Unnamed Android device') }}</strong><p>{{ $device->brand ?: $device->device_model ?: __('Android gateway') }}</p></div><em>{{ $device->status == Status::YES ? __('Online') : __('Offline') }}</em></div>
                    <div class="device-stats"><span>@lang('Battery')<b>{{ $device->battery_level_percent !== null ? $device->battery_level_percent.'%' : '—' }}</b></span><span>@lang('CPU temp')<b>{{ $device->cpu_temperature_celsius !== null ? number_format($device->cpu_temperature_celsius, 1).' °C' : '—' }}</b></span><span>@lang('RAM usage')<b>{{ $device->ram_used_percent !== null ? $device->ram_used_percent.'%' : '—' }}</b></span><span>@lang('Last sync')<b>{{ $device->profile_updated_at ? diffForHumans($device->profile_updated_at) : __('Pending') }}</b></span></div>
                    <div class="device-details-grid">
                        <span>@lang('Device')<b>{{ collect([$device->brand, $device->model])->filter()->implode(' ') ?: __('Not synced') }}</b></span>
                        <span>@lang('Android')<b>{{ $device->android_version ?: __('Not synced') }}</b></span>
                        <span>@lang('SIM carriers')<b>{{ collect($device->sim_carriers ?? [])->filter()->take(2)->implode(', ') ?: __('Not synced') }}</b></span>
                        <span>@lang('RAM')<b>{{ $device->ram_used_mb !== null && $device->ram_total_mb !== null ? $device->ram_used_mb.' / '.$device->ram_total_mb.' MB' : __('Not synced') }}</b></span>
                        <span>@lang('Charging')<b>{{ $device->is_charging === null ? __('Not synced') : ($device->is_charging ? __('Yes') : __('No')) }}</b></span>
                        <span>@lang('Today sent')<b>{{ number_format($device->today_sent_count) }}</b></span>
                    </div>
                </article>
            @empty
                <div class="spamr-empty"><i class="las la-mobile"></i><strong>@lang('No Android devices paired yet')</strong><span>@lang('Pair a phone to see its live gateway status here.')</span></div>
            @endforelse
        </div>
        @if($devices->count() > 2)
            <div class="gateway-show-more"><button type="button" class="show-devices-btn" aria-controls="gateway-devices" aria-expanded="false"><span>@lang('Show all devices')</span> <i class="las la-angle-down"></i></button></div>
        @endif
    </div>

    <div class="spamr-panel spamr-activity">
        <div class="spamr-panel-head"><div><h3>@lang('Recent Live SMS Activity') <em class="live-label">@lang('Live')</em></h3><p>@lang('Latest messages flowing through your connected gateways.')</p></div><a href="{{ route('user.sms.index') }}">@lang('View all messages') <i class="las la-arrow-right"></i></a></div>
        <div class="table-responsive"><table class="activity-table"><thead><tr><th>@lang('Time')</th><th>@lang('Device')</th><th>@lang('Target number')</th><th>@lang('Carrier')</th><th>@lang('SMS message')</th><th>@lang('Status')</th></tr></thead><tbody>
            @forelse($sms as $message)
                @php $carrier = $message->device?->carrierForSlot($message->device_slot_number); @endphp
                <tr><td>{{ diffForHumans($message->created_at) }}</td><td><i class="las la-mobile text--base"></i> {{ $message->device?->device_name ?: __('Unknown device') }}</td><td>{{ $message->mobile_number }}</td><td><span class="carrier-name">{{ $carrier ?: __('Unavailable') }}</span></td><td>{{ strLimit($message->formatted_message ?: $message->message, 64) }}</td><td><em class="sms-status status-{{ $message->status }}">{{ $message->status == Status::SMS_DELIVERED ? __('Sent') : ($message->status == Status::SMS_FAILED ? __('Failed') : __('Queued')) }}</em></td></tr>
            @empty
                <tr><td colspan="6" class="activity-empty">@lang('No SMS activity yet. Your message stream will appear here once a device is paired.')</td></tr>
            @endforelse
        </tbody></table></div>
    </div>

    <div class="spamr-campaign"><div><span><i class="las la-layer-group"></i></span><div><h3>@lang('Ready to reach your audience?')</h3><p>@lang('Create a bulk SMS campaign using your connected Android gateways.')</p></div></div><a href="{{ route('user.campaign.create') }}" class="btn btn--base"><i class="las la-paper-plane"></i> @lang('Launch Bulk SMS Campaign')</a></div>
</section>
@endsection

@push('style')
<style>
.spamr-dashboard{color:#27415f}.spamr-status-banner,.spamr-panel,.spamr-campaign{border:1px solid #dce5f1;border-radius:16px;background:#fff;box-shadow:0 8px 20px rgba(33,56,91,.05)}.spamr-status-banner{display:flex;align-items:center;gap:14px;padding:16px 18px;border-color:#8eecc7;background:#effdf6}.spamr-status-banner.is-empty{border-color:#ffd7b5;background:#fff9f3}.status-icon{display:grid;width:34px;height:34px;place-items:center;color:#fff;border-radius:10px;background:#11bd82;font-size:20px}.is-empty .status-icon{background:#ff6900}.spamr-status-banner strong{color:#123f45;font-size:15px}.spamr-status-banner p,.spamr-heading p,.spamr-panel-head p{margin:2px 0 0;color:#6480a2;font-size:12px}.status-action{margin-left:auto;font-size:12px}.spamr-heading{display:flex;justify-content:space-between;align-items:center;gap:20px;margin:25px 0 20px}.spamr-heading h2{margin:0;color:#102c53;font-size:24px;font-weight:700}.pair-action{padding:9px 14px;color:#28517d;border:1px solid #cbd8e8;border-radius:10px;background:#fff;box-shadow:0 3px 8px rgba(33,56,91,.05);font-size:12px;font-weight:600}.spamr-metrics{display:grid;grid-template-columns:repeat(7,minmax(130px,1fr));gap:12px;overflow-x:auto;padding-bottom:5px}.spamr-metric{position:relative;min-width:130px;padding:15px;border:1px solid #dce5f1;border-radius:14px;background:#fff;box-shadow:0 5px 12px rgba(33,56,91,.05)}.spamr-metric span{display:block;color:#597398;font-size:11px}.spamr-metric>i{position:absolute;top:16px;right:13px;font-size:18px}.spamr-metric strong{display:block;margin-top:14px;color:#112d52;font-size:22px;line-height:1}.spamr-metric small{display:block;margin-top:8px;color:#8397b3;font-size:10px}.spamr-panel{margin-top:22px;padding:20px}.spamr-panel-head{display:flex;justify-content:space-between;gap:15px;align-items:flex-start;padding-bottom:14px;border-bottom:1px solid #e7edf5}.spamr-panel-head h3{margin:0;color:#112d52;font-size:16px;font-weight:700}.spamr-panel-head>a{color:#ff5a16;font-size:12px;font-weight:600}.spamr-devices{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:14px}.spamr-device{padding:14px;border:1px solid #dce5f1;border-radius:12px}.spamr-device.online{border-color:#c4f0da}.device-top{display:flex;align-items:center;gap:10px}.device-icon{display:grid;width:35px;height:35px;place-items:center;color:#ff6900;background:#fff0e4;border-radius:9px;font-size:21px}.device-top strong{display:block;color:#1d3454;font-size:13px}.device-top p{margin:2px 0 0;color:#7d91ad;font-size:11px}.device-top em,.sms-status,.live-label{margin-left:auto;padding:3px 7px;border-radius:20px;color:#009c6b;background:#dcfaeb;font-size:9px;font-style:normal;font-weight:700;text-transform:uppercase}.spamr-device:not(.online) .device-top em{color:#8b97aa;background:#edf1f5}.device-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:7px;margin-top:12px;padding-top:11px;border-top:1px solid #edf1f5}.device-stats span{color:#8a9bb2;font-size:9px}.device-stats b{display:block;overflow:hidden;color:#385574;font-size:10px;font-weight:600;text-overflow:ellipsis;white-space:nowrap}.spamr-empty{display:grid;min-height:120px;place-items:center;align-content:center;gap:5px;grid-column:1/-1;color:#7890ac;text-align:center}.spamr-empty i{color:#ff6900;font-size:26px}.spamr-empty strong{color:#405d80;font-size:13px}.spamr-empty span{font-size:11px}.activity-table{width:100%;min-width:760px;border-collapse:collapse}.activity-table th{padding:13px 10px;color:#5c7395;background:#f7faff;border-bottom:1px solid #dce5f1;font-size:10px;letter-spacing:.04em;text-align:left;text-transform:uppercase}.activity-table td{max-width:240px;padding:13px 10px;overflow:hidden;color:#526b8d;border-bottom:1px solid #edf1f5;font-size:12px;text-overflow:ellipsis;white-space:nowrap}.sms-status{margin:0}.sms-status.status-9{color:#d52f44;background:#ffebee}.live-label{margin-left:5px;vertical-align:middle}.activity-empty{padding:28px!important;color:#8195af!important;text-align:center}.spamr-campaign{display:flex;justify-content:space-between;align-items:center;gap:20px;margin:22px 0 5px;padding:18px 20px;background:linear-gradient(100deg,#fff8f2,#fff)}.spamr-campaign>div{display:flex;align-items:center;gap:12px}.spamr-campaign span{display:grid;width:37px;height:37px;place-items:center;color:#169fdf;border-radius:11px;background:#e3f5ff;font-size:21px}.spamr-campaign h3{margin:0;color:#173655;font-size:15px}.spamr-campaign p{margin:3px 0 0;color:#7790ad;font-size:12px}@media(max-width:991px){.spamr-metrics{grid-template-columns:repeat(4,minmax(145px,1fr))}.spamr-devices{grid-template-columns:1fr}}@media(max-width:575px){.spamr-status-banner,.spamr-heading,.spamr-campaign{align-items:flex-start;flex-direction:column}.status-action{margin-left:48px}.spamr-heading h2{font-size:21px}.device-stats{grid-template-columns:1fr}.spamr-campaign .btn{width:100%}.spamr-panel{padding:14px}}
</style>
<style>
    .activity-table { min-width: 860px; }
    .carrier-name { display: inline-block; max-width: 130px; overflow: hidden; color: #405d80; text-overflow: ellipsis; vertical-align: bottom; }
    #gateway-devices > .spamr-device:nth-child(n+3) { display: none; }
    #gateway-devices.is-expanded { max-height: 510px; overflow-y: auto; padding-right: 6px; scrollbar-color: #b9c8d9 transparent; scrollbar-width: thin; }
    #gateway-devices.is-expanded > .spamr-device:nth-child(n+3) { display: block; }
    .device-details-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 7px; margin-top: 8px; }
    .device-details-grid span { min-width: 0; padding: 7px 8px; color: #8a9bb2; border: 1px solid #edf1f5; border-radius: 8px; font-size: 9px; }
    .device-details-grid b { display: block; overflow: hidden; margin-top: 2px; color: #385574; font-size: 10px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
    .gateway-show-more { display: flex; justify-content: center; padding-top: 14px; }
    .show-devices-btn { padding: 8px 14px; color: #28517d; border: 1px solid #cbd8e8; border-radius: 9px; background: #fff; font-size: 12px; font-weight: 700; }
    .show-devices-btn i { display: inline-block; margin-left: 4px; transition: transform .2s ease; }
    .show-devices-btn[aria-expanded="true"] i { transform: rotate(180deg); }
    .device-stats { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    @media (max-width: 575px) { .device-details-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    @media (max-width: 575px) { .device-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
</style>
@endpush

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.querySelector('.show-devices-btn');
        const devices = document.getElementById('gateway-devices');
        if (!button || !devices) return;

        button.addEventListener('click', function () {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', String(!expanded));
            devices.classList.toggle('is-expanded', !expanded);
            button.querySelector('span').textContent = expanded ? "{{ trans('Show all devices') }}" : "{{ trans('Show fewer devices') }}";
        });
    });
</script>
@endpush
