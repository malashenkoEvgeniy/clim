@extends('admin.layouts.main')

@section('content')
    <div class="box-body">
        <div class="callout callout-warning">
            <h4>{{ __('admin.messages.zero-results-title') }}</h4>
            <p>
                {!! __('admin.messages.zero-results-description', [
                    'url' => CustomRoles::can('services_rubrics.create') ? route('admin.services_rubrics.create') : '#'
                ]) !!}
            </p>
        </div>
    </div>
@stop
