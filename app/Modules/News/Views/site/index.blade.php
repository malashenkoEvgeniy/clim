@php
/** @var \App\Modules\News\Models\News[]|\Illuminate\Pagination\LengthAwarePaginator $news */
/** @var \App\Core\Modules\SystemPages\Models\SystemPage $page */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container _mb-xl _def-mb-xxl">
            <div class="box">
                @if($news->count() > 0)
                    @include('news::site.widgets.news-list', [
                        'news' => $news,
                        'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
                    ])
                    {!! $news->links('pagination.site') !!}
                @else
                    {{ trans('news::site.no-news') }}
                @endif
                <hr class="separator _color-white _mtb-xl">
            </div>
        </div>
    </div>

    {!! Widget::show('products::new') !!}
@endsection
