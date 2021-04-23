@php
/** @var \App\Modules\Brands\Models\Brand $brand */
$addThisID = config('db.social_buttons.addthis');
@endphp

@extends('site._layouts.main')

@if($addThisID)
    @push('scripts')
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid={{ $addThisID }}"></script>
    @endpush
@endif

@section('layout-body')
    <div class="section">
        <div class="container">
            <div class="news-view">
                <div class="box box--gap">
                    <div class="news-view__body">
                        <div class="grid _flex-nowrap _mt-def">
                            @if($addThisID)
                            <div class="gcell gcell--auto _flex-noshrink">
                                <div class="share share--vertical share--sticky _md-show">
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>
                            @endif
                            <div class="gcell gcell--auto _flex-grow">
                                <div class="news-view__cover">{!! $brand->imageTag('big') !!}</div>
                                <div class="news-view__content">
                                    <article class="wysiwyg">
                                        <div class="scroll-text">
                                            <div class="scroll-text__content wysiwyg js-init"
                                                 data-wrap-media
                                                 data-prismjs
                                                 data-draggable-table
                                                 data-perfect-scrollbar
                                            >
                                                {!! $brand->current->content !!}
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="grid _justify-between _items-center _text-center _xs-text-left">
                                    @if($addThisID)
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
    </div>
@endsection
