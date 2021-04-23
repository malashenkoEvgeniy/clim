@php
/** @var \App\Modules\Orders\Models\Order[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator $orders */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                @if($orders && $orders->count() > 0)
                    @include('orders::admin.orders.table', ['orders' => $orders, 'class' => 'table-hover'])
                @else
                    @include('orders::admin.orders.no-orders')
                @endif
            </div>
        </div>
        <div class="text-center">{{ $orders->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
