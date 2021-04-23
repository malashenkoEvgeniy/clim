@php
/** @var \App\Modules\Features\Models\Feature[] $features */
$className = \App\Modules\Features\Models\Feature::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('features::admin.items', ['features' => $features])
            </ol>
        </div>
        <span id="parameters" data-url="{{ route('admin.features.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
