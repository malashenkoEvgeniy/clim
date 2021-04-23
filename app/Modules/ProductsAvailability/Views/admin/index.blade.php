@php
    /** @var \App\Modules\ProductsAvailability\Models\ProductsAvailability[] $orders */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.email') }}</th>
                        <th>{{ __('products-availability::general.product') }}</th>
                        <th>{{ __('validation.attributes.user') }}</th>
                        <th>{{ __('validation.attributes.created_at') }}</th>
                        <th></th>
                    </tr>
                    @foreach($orders AS $order)
                        <tr>
                            <td>{{ $order->email }}</td>
                            <td>{{ Html::link(route('site.product', $order->product->current->slug), $order->product->name, ['target' => '_blank']) }}</td>
                            @if($order->user_id)
                                <td>{{ Html::link(route('admin.users.edit', $order->user_id), $order->user->name, ['target' => '_blank']) }}</td>
                            @else
                                <td>-----</td>
                            @endif
                            <td>{{ $order->created_at->toDateTimeString() }}</td>
                            <td>
                                {!! \App\Components\Buttons::delete('admin.products_availability.destroy', $order->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $orders->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
