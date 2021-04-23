@extends('site._layouts.main')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Новости')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@php
    $_query_value = $_GET['query'] ?? null;
@endphp

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="box box--gap">
                <div class="title title--size-h1">
                    Список новостей
                </div>
            </div>
        </div>


        <div class="container _mb-xl _def-mb-xxl">
            <div class="box">
                @include('site._widgets.news.news-list', [
                    'title' => 'Новости',
                    'all_news_href' => route('news'),
                    'all_news_title' => 'Все новости',
                    'list' => config('mock.news'),
                    'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
                    'limit' => 0
                ])
                @include('site._widgets.pagination.pagination', ['show_all' => false])
                <hr class="separator _color-white _mtb-xl">
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
