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
                <div class="gcell gcell--def-12">
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
@endsection
