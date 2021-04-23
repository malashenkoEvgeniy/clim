@php
/** @var \App\Modules\Orders\Models\Order $order */
$showAddress = $showAddress ?? true;
@endphp
<address>
    <strong>{{ $order->client->name }}</strong><br>
    @if($showAddress)
        {{ $order->city }}<br>
        {{ $order->delivery_address }}<br>
    @endif
    @if($order->client->phone)
        @lang('orders::general.phone'): {!! Html::link("tel:{$order->client->cleared_phone}", $order->client->phone) !!}<br>
    @endif
    @if($order->client->email)
        @lang('orders::general.email'): {!! Html::mailto($order->client->email) !!}
    @endif
</address>
