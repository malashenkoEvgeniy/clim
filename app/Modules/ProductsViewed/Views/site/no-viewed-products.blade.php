@php
/** @var \App\Core\Modules\SystemPages\Models\SystemPage|null $page */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            {!! Widget::show('h1', 'box') !!}
        </div>
    </div>
@endsection
