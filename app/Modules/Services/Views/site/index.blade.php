@php
/** @var \App\Core\Modules\SystemPages\Models\SystemPage $page */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container _mb-xl _def-mb-xxl">
            <div class="box">
                @include('services::site.widgets.services-list', [
                    'services' => $services,
                    'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
                ])
                <hr class="separator _color-white _mtb-xl">
            </div>
        </div>
    </div>

    {!! Widget::show('products::new') !!}
@endsection
