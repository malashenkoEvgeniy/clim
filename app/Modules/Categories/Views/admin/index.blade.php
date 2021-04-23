@php
    /** @var \App\Modules\Categories\Models\Category[] $categories */
    $className = \App\Modules\Categories\Models\Category::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="10">
            <ol class="dd-list">
                @include('categories::admin.items', ['categories' => $categories, 'parentId' => 0])
            </ol>
        </div>
        <span id="parameters" data-url="{{ route('admin.categories.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
