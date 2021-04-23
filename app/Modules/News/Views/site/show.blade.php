@php
/** @var \App\Modules\News\Models\News $news */
$hideH1 = true;
$addThisID = config('db.social_buttons.addthis');
@endphp

@extends('site._layouts.main')

@if (isset($addThisID))
    @push('scripts')
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid={{ $addThisID }}"></script>
    @endpush
@endif

@section('layout-body')
    {!! Widget::show('news::json-ld', $news) !!}
    <div class="section">
        <div class="container">
            <div class="news-view">
                <div class="box box--gap">
                    <div class="news-view__head">
                        <h1 class="news-view__title">{{ Seo::site()->getH1() }}</h1>
                        @if($news->show_short_content)
                            <div class="news-view__teaser">{{ $news->current->short_content }}</div>
                        @endif
                        <time class="news-view__datetime">{{ $news->formatted_published_at }}</time>
                    </div>
                </div>
                <div class="box box--gap">
                    <div class="news-view__body">
                        <div class="grid _flex-nowrap _mt-def">
                            @if (isset($addThisID))
                            <div class="gcell gcell--auto _flex-noshrink">
                                <div class="share share--vertical share--sticky _md-show">
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>
                            @endif
                            <div class="gcell gcell--auto _flex-grow">
                                <div class="news-view__cover">{!! $news->imageTag('big', [], true) !!}</div>
                                <div class="news-view__content">
                                    <article class="wysiwyg">
                                        <div class="scroll-text">
                                            <div class="scroll-text__content wysiwyg js-init"
                                                 data-wrap-media
                                                 data-prismjs
                                                 data-draggable-table
                                                 data-perfect-scrollbar
                                            >
                                                {!! $news->current->content !!}
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="grid _justify-between _items-center _text-center _xs-text-left">
                                    <div class="gcell gcell--12 gcell--xs-auto _flex-grow _mb-md _xs-mb-none">
                                        <time class="news-view__datetime">{{ $news->formatted_published_at }}</time>
                                    </div>
                                    @if (isset($addThisID))
                                        <div class="gcell gcell--12 gcell--xs-auto _flex-noshrink">
                                            <div class="share">
                                                <div class="addthis_inline_share_toolbox"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {!! Widget::show('same-news', $news->id) !!}
    </div>

    {!! Widget::show('products::new') !!}
@endsection
