<section class="campaign-coverage-section">
    <div class="container">
        <div class="campaign-coverage-heading text-center">
            <span class="campaign-coverage-kicker">@lang('Campaign coverage')</span>
            <h2>@lang('Explore campaign availability')</h2>
            <p>@lang('Click a country to check whether campaign delivery is currently available.')</p>
        </div>

        <div class="campaign-world-card" id="campaign-world-card" data-check-url="{{ route('campaign.coverage.check') }}">
            <div class="campaign-world-card__toolbar">
                <div><strong>@lang('Interactive delivery map')</strong><span>@lang('Select a country to check it')</span></div>
                <div class="campaign-map-legend" aria-label="@lang('Map legend')"><span><i class="campaign-map-legend__orange"></i>@lang('Not checked')</span><span><i class="campaign-map-legend__green"></i>@lang('Available')</span><span><i class="campaign-map-legend__red"></i>@lang('Unavailable')</span></div>
            </div>
            <div class="campaign-map-wrap"><div id="campaign-world-map" aria-label="@lang('Interactive world map')"></div></div>
            <div class="campaign-map-result" id="campaign-map-result" aria-live="polite"><span class="campaign-map-result__icon"><i class="las la-hand-pointer"></i></span><p>@lang('Choose a country on the map to see its campaign-delivery status.')</p></div>
            <input type="hidden" id="campaign-map-token" value="{{ csrf_token() }}">
        </div>
    </div>
</section>

@push('style')
<style>
.campaign-coverage-section{padding:82px 0;background:linear-gradient(180deg,#fbfdff,#fff)}.campaign-coverage-heading{max-width:700px;margin:0 auto 32px}.campaign-coverage-kicker{display:inline-block;margin-bottom:10px;padding:5px 11px;color:#ff5a1f;border-radius:99px;background:#fff1e9;font-size:12px;font-weight:700;letter-spacing:.04em;text-transform:uppercase}.campaign-coverage-heading h2{margin-bottom:10px;color:#172d4d;font-size:clamp(26px,3vw,38px)}.campaign-coverage-heading p{margin:0;color:#7085a0}.campaign-world-card{overflow:hidden;border:1px solid #dce6f1;border-radius:20px;background:#fff;box-shadow:0 16px 40px rgba(33,56,91,.08)}.campaign-world-card__toolbar{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:21px 26px;border-bottom:1px solid #eaf0f6}.campaign-world-card__toolbar strong{display:block;color:#173655;font-size:16px}.campaign-world-card__toolbar>div:first-child span{display:block;margin-top:3px;color:#7890ab;font-size:12px}.campaign-map-legend{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:13px}.campaign-map-legend span{display:inline-flex;align-items:center;gap:5px;color:#617893;font-size:11px;white-space:nowrap}.campaign-map-legend i{width:10px;height:10px;border-radius:50%}.campaign-map-legend__orange{background:#ff6a32}.campaign-map-legend__green{background:#14b881}.campaign-map-legend__red{background:#ef5a51}.campaign-map-wrap{min-height:420px;padding:18px 26px 3px;background:radial-gradient(circle at 50% 20%,#f7fbff,#fff 65%)}#campaign-world-map{width:100%;min-height:395px}#campaign-world-map svg{max-width:100%}.campaign-map-result{display:flex;align-items:center;gap:10px;margin:0 26px 24px;padding:13px 15px;color:#60758e;border:1px solid #dce6f1;border-radius:12px;background:#f8fbff;font-size:13px}.campaign-map-result p{margin:0}.campaign-map-result__icon{display:grid;flex:0 0 28px;width:28px;height:28px;place-items:center;color:#fff;border-radius:50%;background:#7192b4}.campaign-map-result--checking .campaign-map-result__icon{background:#f29a37}.campaign-map-result--supported{color:#28705b;border-color:#c6efdc;background:#f3fcf7}.campaign-map-result--supported .campaign-map-result__icon{background:#14b881}.campaign-map-result--restricted{color:#a24a45;border-color:#ffd1ca;background:#fff8f6}.campaign-map-result--restricted .campaign-map-result__icon{background:#ef5a51}.campaign-map-result--unknown{color:#5e7187;border-color:#d9e3ed;background:#fff}.campaign-map-result--unknown .campaign-map-result__icon{background:#7192b4}@media(max-width:767px){.campaign-coverage-section{padding:58px 0}.campaign-world-card__toolbar{align-items:flex-start;flex-direction:column;padding:18px}.campaign-map-legend{justify-content:flex-start}.campaign-map-wrap{min-height:250px;padding:12px}.campaign-map-result{margin:0 12px 14px}#campaign-world-map{min-height:230px}}
</style>
@endpush

@push('script-lib')
<script src="{{ asset(activeTemplate(true) . 'js/campaign-worldmap/mapdata.js') }}"></script>
<script>simplemaps_worldmap_mapdata.main_settings.div = 'campaign-world-map';</script>
<script src="{{ asset(activeTemplate(true) . 'js/campaign-worldmap/worldmap.js') }}"></script>
@endpush

@push('script')
<script>
document.addEventListener('DOMContentLoaded',function(){const card=document.getElementById('campaign-world-card');if(!card||!window.simplemaps_worldmap)return;const result=document.getElementById('campaign-map-result'),token=document.getElementById('campaign-map-token').value,mapData=window.simplemaps_worldmap_mapdata,write=(state,message,icon)=>{result.className='campaign-map-result campaign-map-result--'+state;result.innerHTML='';const badge=document.createElement('span'),text=document.createElement('p');badge.className='campaign-map-result__icon';badge.innerHTML='<i class="las '+icon+'"></i>';text.textContent=message;result.append(badge,text)},paint=(id,color)=>{mapData.state_specific[id].color=color;mapData.state_specific[id].hover_color=color;window.simplemaps_worldmap.refresh_state(id)};window.simplemaps_worldmap.hooks.click_state=function(id){const state=mapData.state_specific[id];if(!state)return;const country=state.name;write('checking','Checking '+country+'…','la-spinner la-spin');fetch(card.dataset.checkUrl,{method:'POST',headers:{Accept:'application/json','Content-Type':'application/x-www-form-urlencoded;charset=UTF-8','X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':token},body:new URLSearchParams({countries:country,_token:token})}).then(response=>response.json()).then(payload=>{const check=payload?.data?.results?.[0];if(!check)throw new Error('Invalid response');if(check.status==='supported'){paint(id,'#14b881');write('supported',country+': '+check.message,'la-check')}else if(check.status==='restricted'){paint(id,'#ef5a51');write('restricted',country+': '+check.message,'la-times')}else{write('unknown',country+': '+check.message,'la-question')}}).catch(()=>write('unknown','Unable to check '+country+'. Please try again.','la-question'))};});
</script>
@endpush
