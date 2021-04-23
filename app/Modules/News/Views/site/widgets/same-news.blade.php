@php
/** @var \App\Modules\News\Models\News[] $news */
@endphp

<div class="container">
    <div class="box">
        <div class="title title--size-h1 _mb-lg _text-center _sm-text-left">@lang('news::site.same-news')</div>
        @include('news::site.widgets.news-list', [
            'news' => $news,
            'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
        ])
    </div>
</div>
