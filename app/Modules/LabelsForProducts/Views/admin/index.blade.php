@php
/** @var \App\Modules\LabelsForProducts\Models\Label[] $labels */
$className = \App\Modules\LabelsForProducts\Models\Label::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('labels::admin.items', ['labels' => $labels])
            </ol>
        </div>
        <span id="parameters" data-url="{{ route('admin.product-labels.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
