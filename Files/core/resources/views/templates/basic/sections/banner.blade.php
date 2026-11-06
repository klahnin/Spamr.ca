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
                    <h1 class="banner-content__title">{!! str_replace('|', '<br>', e(__(@$bannerContent->heading))) !!}</h1>
                    <p class="banner-content__text">{{ __(@$bannerContent->subheading) }}</p>
                    <div class="banner-content__button">
                        <a href="{{ @$bannerContent->left_button_link }}"
                            class="btn btn--gr pill">{{ __(@$bannerContent->left_button_text) }}</a>
                        <a href="{{ @$bannerContent->right_button_link }}"
                            class="btn btn-outline--base pill">{{ __(@$bannerContent->right_button_text) }}</a>
                    </div>
                    <p class="banner-content__trial">@lang('No credit card required to get started.')</p>
                </div>
            </div>
        </div>
    </div>
</section>
