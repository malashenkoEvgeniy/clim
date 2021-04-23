@php
    /** @var \App\Modules\Pages\Models\Page[] $pages */
    $className = \App\Modules\Pages\Models\Page::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('services::admin.services.items', ['services' => $services])
            </ol>
        </div>
        <input type="hidden" id="myNestJson">
    </div>
@stop
