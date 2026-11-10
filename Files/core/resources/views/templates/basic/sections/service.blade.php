@php
    $serviceContent = @getContent('service.content', true)->data_values;
    $serviceElements = @getContent('service.element', orderById: true);
@endphp
<div class="container spamr-dashboard-showcase-container">
    <div class="spamr-dashboard-showcase wow fadeInUp" data-wow-duration="1s">
        <div class="spamr-dashboard-showcase__frame">
            <img src="{{ asset('assets/images/frontend/about/spamr-dashboard-preview.png') }}"
                alt="Spamr dashboard preview">
        </div>
    </div>
</div>
<div class="container spamr-dashboard-details">
    <div class="spamr-dashboard-details__intro wow fadeInUp" data-wow-duration="1s">
        <span>Built for every message moment</span>
        <p>Move seamlessly from real-time message visibility to launching your next campaign.</p>
    </div>
    <div class="spamr-dashboard-details__layout">
        <div class="spamr-dashboard-details__activity wow fadeInLeft" data-wow-duration="1s">
            <img src="{{ asset('assets/images/frontend/about/spamr-live-sms-activity.png') }}"
                alt="Spamr recent live SMS activity">
        </div>
        <div class="spamr-dashboard-details__campaign wow fadeInRight" data-wow-duration="1s" data-wow-delay=".15s">
            <img src="{{ asset('assets/images/frontend/about/spamr-bulk-campaign.png') }}"
                alt="Spamr bulk SMS campaign launch panel">
        </div>
    </div>
</div>
<section class="service-section py-120" id="service">
    <div class="container">
        <div class="section-heading wow fadeInDown" data-wow-duration="1">
            <p class="section-heading__name">{{ __(@$serviceContent->title) }}</p>
            <h3 class="section-heading__title">{{ __(@$serviceContent->heading) }}</h3>
            <p class="section-heading__desc">{{ __(@$serviceContent->subheading) }}</p>
        </div>

        <div class="row service-card-wrapper justify-content-center gy-4">
            @foreach ($serviceElements as $serviceElement)
                <div class="col-lg-4 col-md-6">
                    <div class="service-card wow fadeInDown" data-wow-duration="1">
                        <span class="service-card__icon">
                            <img src="{{ frontendImage('service', $serviceElement->data_values->icon_image, '100x100') }}"
                                alt="message">
                        </span>
                        <h6 class="service-card__title"> {{ __(@$serviceElement->data_values->title) }} </h6>

                        <p class="service-card__desc">{{ __(@$serviceElement->data_values->description) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('style')
    <style>
        .spamr-dashboard-showcase-container { margin-top: 55px; }
        .spamr-dashboard-showcase {
            position: relative;
            padding: 12px;
            overflow: hidden;
            border-radius: 22px;
            background: linear-gradient(118deg, #f45c10 0%, #ff8b42 28%, #ffe6cf 64%, #fff4e9 100%);
            box-shadow: 0 26px 55px rgba(239, 91, 18, .18);
        }
        .spamr-dashboard-showcase::before {
            position: absolute;
            top: -55%;
            right: 10%;
            width: 360px;
            height: 220px;
            content: '';
            border-radius: 50%;
            background: rgba(255, 255, 255, .25);
            filter: blur(28px);
        }
        .spamr-dashboard-showcase__frame {
            position: relative;
            z-index: 1;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .8);
            border-radius: 13px;
            background: #fff;
            box-shadow: 0 14px 30px rgba(65, 29, 10, .18);
        }
        .spamr-dashboard-showcase__frame img {
            display: block;
            width: calc(100% + 1px);
            height: auto;
            margin: -1px 0 0 -1px;
        }

        .spamr-dashboard-details {
            position: relative;
            margin-top: 54px;
            padding: 42px 42px 25px;
            overflow: hidden;
            border: 1px solid #ffe5d0;
            border-radius: 24px;
            background: linear-gradient(135deg, #fff9f4 0%, #fff 48%, #fff4e9 100%);
        }

        .spamr-dashboard-details::before {
            position: absolute;
            top: 39%;
            left: 41%;
            width: 26%;
            height: 2px;
            content: '';
            background: linear-gradient(90deg, rgba(255, 102, 0, 0), rgba(255, 102, 0, .65), rgba(255, 102, 0, 0));
        }

        .spamr-dashboard-details__intro { margin-bottom: 25px; }
        .spamr-dashboard-details__intro span { color: #ef5b12; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
        .spamr-dashboard-details__intro p { margin: 4px 0 0; color: #6e7180; font-size: 15px; }

        .spamr-dashboard-details__layout {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(260px, .8fr);
            align-items: center;
            gap: 0;
        }

        .spamr-dashboard-details__activity,
        .spamr-dashboard-details__campaign {
            overflow: hidden;
            background: #fff;
            border: 1px solid #e5e9f0;
            box-shadow: 0 18px 36px rgba(42, 57, 81, .12);
        }

        .spamr-dashboard-details__activity { border-radius: 16px; }
        .spamr-dashboard-details__campaign {
            position: relative;
            z-index: 2;
            margin-left: -8%;
            border: 8px solid #ff6600;
            border-radius: 20px;
            box-shadow: 0 18px 36px rgba(255, 102, 0, .22);
            transform: translateY(28px);
        }

        .spamr-dashboard-details__activity img,
        .spamr-dashboard-details__campaign img { display: block; width: 100%; height: auto; }

        @media (max-width: 767px) {
            .spamr-dashboard-showcase-container { margin-top: 35px; }
            .spamr-dashboard-showcase { padding: 7px; border-radius: 15px; }
            .spamr-dashboard-showcase__frame { border-radius: 10px; }
            .spamr-dashboard-details { margin-top: 35px; padding: 25px 15px 18px; border-radius: 16px; }
            .spamr-dashboard-details::before { display: none; }
            .spamr-dashboard-details__layout { display: block; }
            .spamr-dashboard-details__activity { border-radius: 10px; }
            .spamr-dashboard-details__campaign { width: 82%; margin: 18px 0 0 auto; border-width: 5px; border-radius: 13px; transform: none; }
        }
    </style>
@endpush
