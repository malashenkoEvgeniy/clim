@php
/** @var \App\Modules\Pages\Models\Page $page */
$hideH1 = true;
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-def">
        <div class="container">
            <div class="box box--gap">
                <div class="grid _items-center _sm-flex-nowrap">
                    <div class="gcell _flex-grow">
                        <h1 class="title title--size-h1">{{ $page->current->h1 ?? $page->current->name }}</h1>
                    </div>
                </div>
            </div>
            <div class="grid _flex-nowrap _items-start">
                {!! Widget::show('pages-menu',$page) !!}
                <div class="gcell _flex-grow">
                    <div class="box">
                        <article class="wysiwyg">
                            <div class="scroll-text">
                                <div class="scroll-text__content wysiwyg js-init"
                                     data-wrap-media
                                     data-prismjs
                                     data-draggable-table
                                     data-perfect-scrollbar
                                     >
                                    {!! $page->current->content !!}
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Widget::show('products::new') !!}
@endsection
