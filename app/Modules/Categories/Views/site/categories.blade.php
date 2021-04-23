@php
/** @var \App\Modules\Categories\Models\Category[] $categories */
/** @var \App\Core\Modules\SystemPages\Models\SystemPage $page */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container _mb-xl _def-mb-xxl">
            <div class="_nmlr-xxs">
                @include('categories::site.catalog-group-list.catalog-group-list', [
                   'categories' => $categories,
               ])
            </div>
        </div>
    </div>

    {!! Widget::show('products::new') !!}
@endsection
