@php
/** @var \App\Modules\Articles\Models\Article[] $articles */
@endphp
<div class="section _def-show">
    <div class="container _mtb-lg _def-mtb-xxl">
        <div class="grid grid--auto _justify-between _items-center _pb-def">
            <div class="gcell _mb-def _mr-def">
                <div class="title title--size-h2">@lang('articles::site.last')</div>
            </div>
            <div class="gcell _mb-def _self-end">
                @include('site._widgets.elements.goto.goto', [
                    'href' => route('site.articles'),
                    'to' => 'next',
                    'text' => trans('articles::site.all-articles'),
                ])
            </div>
        </div>

        @include('articles::site.widgets.articles-list', [
            'articles' => $articles,
            'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
        ])
    </div>
</div>
