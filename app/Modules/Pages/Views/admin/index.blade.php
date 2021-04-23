@php
    /** @var \App\Modules\Pages\Models\Page[] $pages */
    $className = \App\Modules\Pages\Models\Page::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('pages::admin.items', ['pages' => $pages])
            </ol>
        </div>
        <span id="parameters" data-url="{{ route('admin.pages.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
