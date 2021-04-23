@extends('site._layouts.main')

@php
    $_query_value = $_GET['query'] ?? null;
@endphp

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="box">
                <div class="title title--size-h1">
                    @if(!$_query_value)
                        Задайте поисковый запрос
                    @else
                        По запросу
                        <span class="_color-main">«{{ $_query_value }}»</span>
                        нашлось
                        <span class="_color-main">24 товара</span>
                    @endif
                </div>
            </div>
            <div class="box">
                @include('site._widgets.sort-controls.sort-controls', [
                    'form' => true,
                    'action' => '/html/search',
                    'query_value' => $_query_value
                ])
            </div>
        </div>


        <div class="container _mb-xl _def-mb-xxl">
            <div class="js-search-result" data-query="{{ $_query_value }}">
                @include('site._widgets.item-list.item-list', [
                    'list' => [
                       config('mock.items')[0],
                       config('mock.items')[1],
                       config('mock.items')[2],
                       config('mock.items')[3],
                    ],
                    'full_width' => true
                ])
                @include('site._widgets.pagination.pagination', ['show_all' => true])
                <hr class="separator _color-gray3 _mtb-xl">
            </div>
        </div>
    </div>

    <div class="section _mb-xl _lg-mb-xxl">
        <div class="container">
            <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                <div class="gcell _mb-def _mr-def">
                    <div class="title title--size-h2">Просмотренные товары</div>
                </div>
                <div class="gcell _mb-def _self-end">
                    @include('site._widgets.elements.goto.goto', [
                        'href' => '#',
                        'to' => 'next',
                        'text' => 'смотреть все'
                    ])
                </div>
            </div>
            @include('site._widgets.item-list.item-slider')
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
