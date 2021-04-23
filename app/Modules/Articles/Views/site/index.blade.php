@php
/** @var \App\Modules\Articles\Models\Article[]|\Illuminate\Pagination\LengthAwarePaginator $articles */
/** @var \App\Core\Modules\SystemPages\Models\SystemPage $page */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container _mb-xl _def-mb-xxl">
            <div class="box">
                @include('articles::site.widgets.articles-list', [
                    'articles' => $articles,
                    'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
                ])
                {!! $articles->links('pagination.site') !!}
                <hr class="separator _color-white _mtb-xl">
            </div>
        </div>
    </div>

    {!! Widget::show('products::new') !!}
@endsection
