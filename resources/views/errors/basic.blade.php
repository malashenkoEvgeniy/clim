@php
$centerH1 = true;
Seo::site()->set([
    'name' => trans('messages.page-not-found'),
    'h1' => trans('global.error-code', ['code' => 404]),
]);
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section">
        <div class="container _mb-xl _def-mb-xxl">
            <div class="box">
                <div class="_text-center">
                    <div class="wysiwyg">
                        <p>@lang('messages.page-does-not-exist')</p>
                        <p>{!! trans('messages.go-to-the-home-page', ['url' => route('site.home')]) !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Widget::show('viewed::products') !!}
    {!! Widget::show('products::new') !!}
@endsection
