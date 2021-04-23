@php
    /** @var \App\Core\Modules\Translates\Models\Translate[] $translates */
@endphp

@extends('admin.layouts.main')


@section('content-no-row')
    <table class="table no-side-padding education-table">
        <thead>
        <tr>
            <th>{{ __('translates::list.keys') }}</th>
            <th>{{ __('translates::general.translate') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($translates as $key => $translate)
            <tr>
                <th>{{$key}}</th>
                <th>{{$translate}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
