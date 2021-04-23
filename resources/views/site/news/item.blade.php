@extends('site._layouts.main')

@push('scripts')
    @php
        $key = config('db.news.addthis-key')
    @endphp
    @if($key)
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid={{ $key }}"></script>
    @endif
@endpush

@section('layout-body')
    @php
        $news_item = config('mock.news-item');
    @endphp
    <div class="section">
        <div class="container">
            <div class="news-view">
                <div class="box box--gap">
                    <div class="news-view__head">
                        <h1 class="news-view__title">{{ $news_item->title }}</h1>
                        <div class="news-view__teaser">{{ $news_item->teaser }}</div>
                        <time class="news-view__datetime">{{ $news_item->datetime_formatted }}</time>
                    </div>
                </div>
                {{--@include('site._widgets.pager.pager')--}}
                <div class="box box--gap">
                    <div class="news-view__body">
                        <div class="grid _flex-nowrap _mt-def">
                            <div class="gcell gcell--auto _flex-noshrink">
                                <div class="share share--vertical share--sticky _md-show">
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>
                            <div class="gcell gcell--auto _flex-grow">
                                <div class="news-view__cover">
                                    <img src="{{ $news_item->image }}" alt="Some alt for this image">
                                </div>
                                <div class="news-view__content">
                                    <article class="wysiwyg">
                                        <div class="scroll-text">
                                            <div class="scroll-text__content wysiwyg js-init"
                                                 data-wrap-media
                                                 data-prismjs
                                                 data-draggable-table
                                                 data-perfect-scrollbar
                                            >
                                                {!! $news_item->content !!}
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="grid _justify-between _items-center _text-center _xs-text-left">
                                    <div class="gcell gcell--12 gcell--xs-auto _flex-grow _mb-md _xs-mb-none">
                                        <time class="news-view__datetime">{{ $news_item->datetime_formatted }}</time>
                                    </div>
                                    <div class="gcell gcell--12 gcell--xs-auto _flex-noshrink">
                                        <div class="share">
                                            <div class="addthis_inline_share_toolbox"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--@include('site._widgets.pager.pager')--}}
            </div>
        </div>

        <div class="container">
            <div class="box box--gap">
                <div class="title title--size-h1">Похожие публикации</div>
            </div>
        </div>

        <div class="container">
            <div class="box">
                @include('site._widgets.news.news-list', [
                    'title' => 'Новости',
                    'all_news_href' => route('news'),
                    'all_news_title' => 'Все новости',
                    'list' => config('mock.news'),
                    'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
                    'limit' => 4
                ])
            </div>
        </div>
    </div>
@endsection
