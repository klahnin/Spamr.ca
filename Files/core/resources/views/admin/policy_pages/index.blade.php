@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        @foreach ($pages as $page)
            <div class="col-md-6 mb-30">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <span class="text--base mb-2"><i class="las la-file-contract fs-3"></i></span>
                        <h5 class="mb-2">{{ __($page->data_values->title) }}</h5>
                        <p class="text-muted mb-4">{{ url('policy/' . $page->slug) }}</p>
                        <div class="mt-auto d-flex gap-2">
                            <a class="btn btn--primary btn-sm" href="{{ route('admin.policy.pages.edit', $page->slug) }}"><i class="las la-pen"></i> @lang('Edit content')</a>
                            <a class="btn btn--outline-primary btn-sm" href="{{ url('policy/' . $page->slug) }}" target="_blank" rel="noopener noreferrer"><i class="las la-external-link-alt"></i> @lang('View page')</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
