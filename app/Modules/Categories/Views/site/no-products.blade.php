@php
$hideH1 = true;
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="box">
                <h1 class="title title--size-h1">
                    {{ $page->current->name }}
                </h1>
            </div>
            <div class="grid grid--1" id="filter">
                <div class="gcell gcell--def-3 gcell--lg-1-of-5">
                    <div class="box">
                        <div class="_def-show">
                            {!! Widget::show('categories::in-filter') !!}
                            {!! Widget::show('categories::kids', $page->id) !!}
                            {!! Widget::show('products::filter', $page->id) !!}
                        </div>
                    </div>
                </div>
                <div class="gcell gcell--def-9 gcell--lg-4-of-5">
                    <div class="box _def-ml-xxs">
                        {!! Widget::show('products::chosen-parameters-in-filter') !!}
                    </div>
                    <div class="_def-ml-xxs">
                        <div class="box">
                            <div class="_text-center">
                                <div class="wysiwyg">
                                    <p>@lang('messages.no-content')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="separator _color-gray3 _mtb-xl">
        </div>
    </div>

    {!! Widget::show('products::new') !!}
@endsection
