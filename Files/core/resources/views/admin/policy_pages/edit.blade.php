@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.policy.pages.update', $slug) }}" method="POST" class="disableSubmission">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Page title')</label>
                            <input type="text" name="title" class="form-control" maxlength="120" value="{{ old('title', $page->data_values->title) }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Page content')</label>
                            <textarea name="details" rows="18" class="form-control nicEdit">{{ old('details', $page->data_values->details) }}</textarea>
                            <small class="text-muted">@lang('Use the editor to write and format the public policy content.')</small>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.policy.pages.index') }}" class="btn btn--dark">@lang('Back')</a>
                            <button type="submit" class="btn btn--primary"><i class="las la-save"></i> @lang('Save page')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
