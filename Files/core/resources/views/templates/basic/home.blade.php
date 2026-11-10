@extends('Template::layouts.frontend')
@section('content')
    @include('Template::sections.banner')

    @php $campaignCoveragePlaced = false; @endphp
    @if (isset($sections->secs) && $sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
            @if ($sec === 'service')
                @include('Template::sections.campaign_country_coverage')
                @php $campaignCoveragePlaced = true; @endphp
            @endif
        @endforeach
    @endif

    @if (!$campaignCoveragePlaced)
        @include('Template::sections.campaign_country_coverage')
    @endif
@endsection
