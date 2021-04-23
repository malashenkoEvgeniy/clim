@php
    /** @var \App\Modules\FastOrders\Models\FastOrder[] $fastOrders */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.ip') }}</th>
                        <th>{{ __('validation.attributes.phone') }}</th>
                        <th>{{ __('validation.attributes.created_at') }}</th>
                        <th>{{ __('fast_orders::general.status') }}</th>
                        <th></th>
                    </tr>
                    @foreach($fastOrders AS $order)
                        <tr>
                            <td>{{ $order->ip }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->created_at->toDateTimeString() }}</td>
                            <td>{!! Widget::active($order, 'admin.fast_orders.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.fast_orders.edit', $order->id) !!}
                                {!! \App\Components\Buttons::delete('admin.fast_orders.destroy', $order->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $fastOrders->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
