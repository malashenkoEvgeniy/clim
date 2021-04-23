@php
/** @var \App\Core\Modules\SystemPages\Models\SystemPage $page */
$hideH1 = true;
@endphp

@extends('site._layouts.main')

@push('expandedCatalog', false)

@section('layout-body')
    <div class="_def-hide _text-center _pt-md">
        <a href="{{ route('site.categories') }}" class="button button--size-normal button--theme-main button--width-lg">
            <span class="button__body">
                <span class="button__text">@lang('home::general.catalog')</span>
            </span>
        </a>
    </div>
    {!! Widget::show('labels::products') !!}
    {!! Widget::show('reviews') !!}
    {!! Widget::show('labels::products') !!}
    {!! Widget::show('brands::our-brands') !!}
    {!! Widget::show('news') !!}
    {!! Widget::show('viewed::products') !!}
    {!! Widget::show('articles::last') !!}
    {!! Widget::show('services-rubrics') !!}}
    {!! Widget::show('labels::products') !!}
@endsection
