@php
/** @var \App\Modules\Orders\Models\Order $order */
@endphp
<address>
    <strong>{{ $order->user->name }}</strong><br>
    @if($order->user->phone)
        @lang('orders::general.phone'): {!! Html::link("tel:{$order->user->cleared_phone}", $order->user->phone) !!}<br>
    @endif
    @if($order->user->email)
        @lang('orders::general.email'): {!! Html::mailto($order->user->email) !!}
    @endif
</address>
