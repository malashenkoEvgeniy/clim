@php
$centerH1 = true;
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section">
        <div class="container _mb-xl _def-mb-xxl">
            <div class="box">
                <div class="_text-center">
                    <div class="wysiwyg">
                        <p>@lang('messages.no-content')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Widget::show('labels-sorted-list') !!}
@endsection
