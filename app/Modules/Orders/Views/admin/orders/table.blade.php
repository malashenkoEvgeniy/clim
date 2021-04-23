@php
/** @var \App\Modules\Orders\Models\Order[] $orders */
@endphp

<table class="table {{ $class ?? '' }}">
    <thead>
    <tr>
        <th>@lang('orders::general.order-id')</th>
        <th>@lang('orders::general.receiver')</th>
        <th>@lang('orders::general.order-created-at')</th>
        <th>@lang('orders::general.order-amount')</th>
        <th>@lang('orders::general.order-status')</th>
        <th>@lang('orders::general.payment-status')</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders AS $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>
                <div><strong>{{ $order->client->name }}</strong></div>
                @if($order->client->email)
                    <div>{!! Html::mailto($order->client->email) !!}</div>
                @endif
                @if($order->client->phone)
                    <div>{!! Html::link("tel:{$order->client->cleared_phone}", $order->client->phone) !!}</div>
                @endif
            </td>
            <td>{{ $order->formatted_date }}, {{ $order->created_at->format('H:i') }}</td>
            <td>{{ $order->total_amount }}</td>
            <td>
                @if($order->status)
                    <span class="label" style="background-color: {{ $order->status->color }}!important;">
                        {{ $order->status->current->name }}
                    </span>
                @else
                    <span class="label" style="background-color: #8F8F8F!important;">
                        @lang('orders::general.unknown')
                    </span>
                @endif
            </td>
            <td>
                <span class="label label-{{ $order->paid ? 'success' : 'danger' }}">
                    {{ $order->paid ? trans('orders::general.paid') : trans('orders::general.not-paid') }}
                </span>
            </td>
            <td>
                @if($order->trashed())
                    {!! \App\Components\Buttons::restore('admin.orders.restore', $order->id) !!}
                @else
                    {!! \App\Components\Buttons::view('admin.orders.show', $order->id) !!}
                    {!! \App\Components\Buttons::edit('admin.orders.edit', $order->id) !!}
                    {!! \App\Components\Buttons::delete('admin.orders.destroy', $order->id) !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
