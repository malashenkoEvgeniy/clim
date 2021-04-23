@php
/** @var \App\Modules\Orders\Models\OrderStatus[] $statuses */
$className = \App\Modules\Orders\Models\OrderStatus::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('orders::admin.statuses.items', ['statuses' => $statuses])
            </ol>
        </div>
        <span id="parameters" data-url="{{ route('admin.orders-statuses.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
