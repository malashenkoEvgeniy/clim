@php
/** @var \App\Modules\Orders\Models\Order $order */
$customerTemplate = $order->user ? 'customer-print' : 'receiver-print';
@endphp

<div class="row">
    <div class="col-xs-12">
        <h2 class="page-header">
            <i class="fa fa-globe"></i> {{ env('APP_NAME') }}
            <small class="pull-right">@lang('validation.attributes.created_at'): {{ $order->created_at->format('d.m.Y') }}</small>
        </h2>
    </div>
</div>

<div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
        @lang('orders::general.customer')
        @include("orders::admin.orders.show-order-parts.{$customerTemplate}", ['order' => $order, 'showAddress' => false])
    </div>
    <div class="col-sm-4 invoice-col">
        @lang('orders::general.receiver')
        @include('orders::admin.orders.show-order-parts.receiver-print', ['order' => $order])
    </div>
    <div class="col-sm-4 invoice-col">
        <b>@lang('orders::general.order-id'):</b> #{{ $order->id }}<br>
        <br>
        @if($order->payment_method)
            <b>@lang('orders::general.payment-method'):</b> @lang("orders::general.payment-methods.{$order->payment_method}")<br>
        @endif
        @if($order->delivery)
            <b>@lang('orders::general.delivery-type'):</b> @lang("orders::general.deliveries.{$order->delivery}")<br>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>@lang('orders::general.order-item')</th>
                <th>@lang('orders::general.quantity')</th>
                <th>@lang('orders::general.price-for-one')</th>
                <th>@lang('orders::general.total')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{!! Widget::show('products::in-invoice', $item->product_id) !!}</td>
                    <td>{{ $item->quantity }} @lang('orders::general.pieces')</td>
                    <td>{{ $item->formatted_price }}</td>
                    <td>{{ $item->formatted_amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-6">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>@lang('orders::general.all-items-cost'):</th>
                    <td>{{ $order->total_amount }}</td>
                </tr>
                @if($order->total_amount != $order->total_amount_old)
                    <tr>
                        <th>@lang('orders::general.all-items-cost-wholesale'):</th>
                        <td>{{ $order->total_amount_old }}</td>
                    </tr>
                @endif
                <tr>
                    <th>@lang('orders::general.delivery'):</th>
                    <td>@lang('orders::general.by-delivery-service-tariff')</td>
                </tr>
                <tr>
                    <th>@lang('orders::general.total-to-pay'):</th>
                    <td>{{ $order->total_amount }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
