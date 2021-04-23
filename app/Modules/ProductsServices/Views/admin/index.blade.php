@php
/** @var \App\Modules\ProductsServices\Models\ProductService[] $services */
$className = \App\Modules\ProductsServices\Models\ProductService::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('products_services::admin.items', ['services' => $services])
            </ol>
        </div>
        <span id="parameters" data-url="{{ route('admin.products-services.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
