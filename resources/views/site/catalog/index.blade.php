@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container _mb-xl _def-mb-xxl">
            <div class="box box--gap">
                <div class="title title--size-h1">Каталог товаров</div>
            </div>
            <div class="_nmlr-xxs">
                @include('site._widgets.catalog-group-list.catalog-group-list', [
                   'list' => config('mock.nav-links-catalogs')
               ])
            </div>
        </div>
    </div>

    <div class="section _mb-xl _lg-mb-xxl">
        <div class="container">
            @include('site._widgets.feature-slider.feature-slider', [
               'list' => [
                   config('mock.features')[5],
                   config('mock.features')[6],
                   config('mock.features')[7],
                   config('mock.features')[8]
               ],
               'slides_to_show' => 4,
               'split' => true
           ])
        </div>
    </div>
@endsection
