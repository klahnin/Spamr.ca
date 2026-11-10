@php
    $bannerContent = @getContent('banner.content', true)->data_values;
@endphp
<section class="banner-section banner-section--centered">
    <div class="banner-ring"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="banner-content text-center wow fadeInUp" data-wow-duration="1">
                    <p class="banner-content__subtitle">{{ __(@$bannerContent->title) }}</p>
                    <h1 class="banner-content__title"><span>@lang('Bad spam gets blocked')</span><span>@lang('Good spam gets you paid')</span></h1>
                    <p class="banner-content__text">{{ __(@$bannerContent->subheading) }}</p>
                    <div class="banner-content__button">
                        <a href="{{ @$bannerContent->left_button_link }}"
                            class="btn btn--gr pill">{{ __(@$bannerContent->left_button_text) }}</a>
                        <a href="{{ @$bannerContent->right_button_link }}"
                            class="btn btn-outline--base pill">{{ __(@$bannerContent->right_button_text) }}</a>
                    </div>
                    <p class="banner-content__trial"><strong>@lang('Proud supporter of')</strong></p>
                    <div class="banner-supporters" aria-label="@lang('Spamr supporters')">
                        <div class="banner-supporters__logos">
                            <img src="{{ asset('assets/images/frontend/partners/bitcoin.webp') }}" alt="Bitcoin">
                            <img src="{{ asset('assets/images/frontend/partners/monero.webp') }}" alt="Monero">
                            <img src="{{ asset('assets/images/frontend/partners/brave.webp') }}" alt="Brave">
                            <img class="banner-supporters__linux" src="{{ asset('assets/images/frontend/partners/linux-logo.png') }}" alt="Linux">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('style')
    <style>
        .banner-supporters {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px 13px;
            margin-top: 12px;
            color: #7b8ba3;
            font-size: 11px;
            font-weight: 600;
        }

        .banner-supporters__logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 13px;
        }

        .banner-supporters__logos img {
            display: block;
            width: auto;
            height: 19px;
            max-width: 72px;
            object-fit: contain;
            opacity: .78;
            filter: grayscale(1);
            transition: filter .2s ease, opacity .2s ease;
        }

        .banner-supporters__logos img:hover {
            filter: grayscale(0);
            opacity: 1;
        }

        .banner-supporters__logos .banner-supporters__linux {
            height: 25px;
            max-width: 88px;
        }

        @media (max-width: 575px) {
            .banner-supporters { gap: 7px 10px; padding-inline: 16px; }
            .banner-supporters__logos { gap: 10px; }
            .banner-supporters__logos img { height: 16px; max-width: 60px; }
            .banner-supporters__logos .banner-supporters__linux { height: 21px; max-width: 74px; }
        }
    </style>
@endpush
