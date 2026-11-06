@php
    $planContent = @getContent('plan.content', true)->data_values;
@endphp

<section class="plan-section py-120" id="pricing">
    <div class="plan-section__vector">
        <img class="fit-image" src="{{ frontendImage('plan', @$planContent->background_image_left, '875x975') }}"
            alt="">
    </div>
    <div class="plan-section__vector style-right">
        <img class="fit-image" src="{{ frontendImage('plan', @$planContent->background_image_right, '740x975') }}"
            alt="">
    </div>
    <div class="container">
        <div class="section-heading wow fadeInDown" data-wow-duration="1">
            <p class="section-heading__name">{{ __(@$planContent->title) }}</p>
            <h3 class="section-heading__title">{{ __(@$planContent->heading) }}</h3>
            <p class="section-heading__desc">{{ __(@$planContent->subheading) }}</p>
        </div>
        <aside class="bitcoin-payment-card wow fadeInUp" data-wow-duration="1" aria-labelledby="bitcoin-payment-title">
            <div class="bitcoin-payment-card__icon" aria-hidden="true"><i class="fab fa-bitcoin"></i></div>
            <div class="bitcoin-payment-card__content">
                <p class="bitcoin-payment-card__eyebrow">Bitcoin-friendly payments</p>
                <h4 id="bitcoin-payment-title">Proud supporters of Bitcoin</h4>
                <p>Pay for your Spamr plan using crypto at checkout. Choose our crypto payment method to pay simply and securely.</p>
            </div>
            <div class="bitcoin-payment-card__price" aria-live="polite">
                <span class="bitcoin-payment-card__price-label">Live Bitcoin price</span>
                <strong id="bitcoinPrice">Loading…</strong>
                <small id="bitcoinPriceStatus">BTC / CAD</small>
            </div>
        </aside>
        @include('Template::partials.plan')
    </div>
</section>

@push('script')
    <script>
        (() => {
            const price = document.getElementById('bitcoinPrice');
            const status = document.getElementById('bitcoinPriceStatus');
            if (!price || !status) return;

            const loadBitcoinPrice = async () => {
                try {
                    const response = await fetch('{{ route('bitcoin.price') }}', { headers: { Accept: 'application/json' } });
                    if (!response.ok) throw new Error('Price unavailable');
                    const data = await response.json();
                    price.textContent = new Intl.NumberFormat('en-CA', {
                        style: 'currency', currency: data.currency, maximumFractionDigits: 0
                    }).format(data.price);
                    status.textContent = 'BTC / ' + data.currency + ' · updates every minute';
                } catch (error) {
                    price.textContent = 'Unavailable';
                    status.textContent = 'Try again shortly';
                }
            };

            loadBitcoinPrice();
            setInterval(loadBitcoinPrice, 60000);
        })();
    </script>
@endpush
