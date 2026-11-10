@php
    $user = auth()->user();
@endphp
<div class="dashboard-nav d-flex flex-wrap align-items-center justify-content-between">
    <div class="nav-left d-flex gap-4 align-items-center">
        <div class="dash-sidebar-toggler d-xl-none" id="dash-sidebar-toggler">
            <i class="fas fa-bars"></i>
        </div>
        <div class="market-price-widget" role="status" aria-live="polite" aria-label="Live Bitcoin price">
            <span class="market-price-widget__symbol">BTC/USD:</span>
            <div class="market-price-widget__quote">
                <span class="market-price-widget__label">@lang('Bitcoin')</span>
                <strong class="market-price-widget__value" data-bitcoin-price>Loading price...</strong>
                <small class="market-price-widget__cad" data-bitcoin-cad>Loading CAD...</small>
            </div>
            <div class="market-price-widget__meta">
                <span class="bitcoin-price-widget__change" data-bitcoin-change>Live</span>
                <small data-bitcoin-updated>Updating...</small>
            </div>
        </div>
        <div class="market-price-widget" role="status" aria-live="polite" aria-label="Live Monero price">
            <span class="market-price-widget__symbol">XMR/USD:</span>
            <div class="market-price-widget__quote">
                <span class="market-price-widget__label">@lang('Monero')</span>
                <strong class="market-price-widget__value" data-monero-price>Loading price...</strong>
                <small class="market-price-widget__cad" data-monero-cad>Loading CAD...</small>
            </div>
            <div class="market-price-widget__meta">
                <span class="bitcoin-price-widget__change" data-monero-change>Live</span>
                <small data-monero-updated>Updating...</small>
            </div>
        </div>
    </div>
    <div class="nav-right d-flex flex-wrap align-items-center gap-3">
        <a href="{{ route('user.apk') }}" class="btn btn--dark btn--sm">@lang('Download APK')</a>

        <a href="{{ route('user.sms.send') }}" class="btn btn--base btn--sm">@lang('Send Single SMS')</a>
        <a href="{{ route('user.campaign.create') }}" class="btn btn--info btn--sm">@lang('Send Bulk SMS')</a>

        @if (gs('multi_language'))
            @php
                $language = App\Models\Language::all();
                $languageFlags = ['en' => 'en.svg', 'fr' => 'fr.svg', 'nl' => 'nl.svg', 'ru' => 'ru.svg', 'zh' => 'zh.svg'];
                $activeLanguage = $language->firstWhere('code', session('lang')) ?? $language->firstWhere('code', 'en') ?? $language->first();
            @endphp
            <details class="spamr-language-menu">
                <summary>
                    @if($activeLanguage)
                        <img src="{{ asset('assets/images/language/flags/' . ($languageFlags[$activeLanguage->code] ?? 'en.svg')) }}" alt="">
                        <span>{{ __($activeLanguage->name) }}</span>
                    @endif
                    <i class="las la-angle-down"></i>
                </summary>
                <div class="spamr-language-menu__list">
                @foreach ($language as $item)
                    <a href="{{ route('lang', $item->code) }}" @class(['is-active' => $activeLanguage?->code === $item->code])>
                        <img src="{{ asset('assets/images/language/flags/' . ($languageFlags[$item->code] ?? 'en.svg')) }}" alt="">
                        <span>{{ __($item->name) }}</span>
                    </a>
                @endforeach
                </div>
            </details>
        @endif
        <ul class="nav-header-link d-flex flex-wrap gap-2">
            <li>
                <a class="link fullscreen-btn fullscreen-open d-grid" onclick="openFullscreen()" href="javascript:void(0)"><i class="fas fa-expand"></i></a>
                <a class="link fullscreen-btn fullscreen-close d-none" onclick="closeFullscreen()" href="javascript:void(0)"><i class="fas fa-compress"></i></a>
            </li>
            <li>
                <a class="link short_name" href="javascript:void(0)">
                    {{ generateInitials(@$user->fullname) }}
                </a>
                <div class="dropdown-wrapper">
                    <div class="dropdown-header">
                        <h6 class="name text--base">{{ @$user->username }}</h6>
                        <div class="d-flex flex-wrap justify-content-between mt-2">
                            <h6 class="fs--14px">@lang('Balance')</h6>
                            <h6 class="fs--14px text--success">{{ showAmount(@$user->balance, currencyFormat: false) }}
                                {{ gs('cur_text') }}</h6>
                        </div>
                    </div>
                    <ul class="links">
                        <li><a href="{{ route('user.profile.setting') }}"><i class="las la-user"></i> @lang('Profile')
                            </a></li>
                        <li><a href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> @lang('Sign Out')
                            </a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>

<style>
        .market-price-widget {
            min-width: 0;
            min-height: 28px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 11px;
            color: #516780;
            background: #f8fbff;
            border: 1px solid #dbe5f0;
            border-radius: 7px;
            box-shadow: 0 1px 2px rgba(34, 64, 102, .03);
        }

        .market-price-widget__symbol { color: #233f61; font-size: 11px; font-weight: 700; line-height: 1; white-space: nowrap; }
        .market-price-widget__quote { display: contents; }
        .market-price-widget__label { display: none; }
        .market-price-widget__value { color: #405975; font-size: 11px; font-weight: 700; line-height: 1; white-space: nowrap; }
        .market-price-widget__cad { color: #7085a0; font-size: 10px; line-height: 1; white-space: nowrap; }
        .market-price-widget__meta { display: flex; gap: 4px; color: #7b8da6; font-size: 10px; line-height: 1; }
        .bitcoin-price-widget__change { display: block; color: #12a56a; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .bitcoin-price-widget__change.is-positive { color: #16a34a; }
        .bitcoin-price-widget__change.is-negative { color: #ef4444; }
        .market-price-widget__meta small { display: none; }

        .dashboard-nav .nav-left {
            flex-wrap: wrap;
            gap: 8px !important;
        }

        @media (max-width: 767px) {
            .market-price-widget { min-width: 0; }
        }

        @media (max-width: 575px) {
            .market-price-widget { width: auto; }
            .dashboard-nav .nav-left { width: 100%; }
        }
 </style>

@push('script')
    <script>
        (() => {
            const widgets = [
                { coinId: 'bitcoin', price: '[data-bitcoin-price]', cad: '[data-bitcoin-cad]', change: '[data-bitcoin-change]', updated: '[data-bitcoin-updated]' },
                { coinId: 'monero', price: '[data-monero-price]', cad: '[data-monero-cad]', change: '[data-monero-change]', updated: '[data-monero-updated]' },
            ];
            const endpoint = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,monero&vs_currencies=usd,cad&include_24hr_change=true&include_last_updated_at=true';
            const usdFormatter = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 0 });
            const cadFormatter = new Intl.NumberFormat('en-CA', { style: 'currency', currency: 'CAD', maximumFractionDigits: 0 });

            async function updateBitcoinPrice() {
                try {
                    const response = await fetch(endpoint, { headers: { Accept: 'application/json' } });
                    if (!response.ok) throw new Error('Price service unavailable');

                    const prices = await response.json();
                    widgets.forEach(({ coinId, price, cad, change, updated }) => {
                        const coin = prices[coinId];
                        const priceElement = document.querySelector(price);
                        const cadElement = document.querySelector(cad);
                        const changeElement = document.querySelector(change);
                        const updatedElement = document.querySelector(updated);
                        if (!coin || typeof coin.usd !== 'number' || typeof coin.cad !== 'number' || !priceElement || !cadElement || !changeElement || !updatedElement) return;

                        priceElement.textContent = usdFormatter.format(coin.usd);
                        cadElement.textContent = cadFormatter.format(coin.cad);
                        const dailyChange = Number(coin.usd_24h_change);
                        changeElement.classList.remove('is-positive', 'is-negative');
                        if (Number.isFinite(dailyChange)) {
                            changeElement.textContent = `${dailyChange >= 0 ? '+' : ''}${dailyChange.toFixed(2)}% - 24h`;
                            changeElement.classList.add(dailyChange >= 0 ? 'is-positive' : 'is-negative');
                        } else {
                            changeElement.textContent = 'Live';
                        }
                        const updatedAt = coin.last_updated_at ? new Date(coin.last_updated_at * 1000) : new Date();
                        updatedElement.textContent = `Updated ${updatedAt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                    });
                } catch (error) {
                    widgets.forEach(({ cad, change, updated }) => {
                        const cadElement = document.querySelector(cad);
                        const changeElement = document.querySelector(change);
                        const updatedElement = document.querySelector(updated);
                        if (!cadElement || !changeElement || !updatedElement) return;
                        cadElement.textContent = 'CAD unavailable';
                        changeElement.classList.remove('is-positive', 'is-negative');
                        changeElement.textContent = 'Unavailable';
                        updatedElement.textContent = 'Retrying shortly';
                    });
                }
            }

            updateBitcoinPrice();
            window.setInterval(updateBitcoinPrice, 60000);
        })();
    </script>
@endpush
