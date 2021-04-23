@php
/** @var \App\Modules\SlideshowSimple\Models\SlideshowSimple[] $sliders */
$className = App\Modules\SlideshowSimple\Models\SlideshowSimple::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('slideshow_simple::admin.items', ['slides' => $sliders])
            </ol>
        </div>
        <span id="parameters"
              data-url="{{ route('admin.slideshow_simple.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
