@php
    $contactContent = @getContent('contact.content', true)->data_values;
@endphp
@extends('Template::layouts.frontend')
@section('content')

    @include('Template::sections.blog')

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif
@endsection
