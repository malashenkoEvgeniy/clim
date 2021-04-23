@php
/** @var \App\Modules\Orders\Models\Order $order */
@endphp

<div class="box box-danger">
    <div class="box-body">
        <strong><i class="fa fa-calendar margin-r-5"></i> @lang('validation.attributes.created_at')</strong>
        <p class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</p>

        @if($order->status && $order->status->exists)
            <strong><i class="glyphicon glyphicon-transfer margin-r-5"></i> @lang('orders::general.order-status')</strong>
            <p id="order-status">
                <span class="label" style="background-color: {{ $order->status->color }}!important;">
                    {{ $order->status->current->name }}
                </span>
            </p>
        @endif

        <strong><i class="fa fa-credit-card margin-r-5"></i> @lang('orders::general.payment-status')</strong>
        <p id="paid-block">
            <strong class="label label-{{ $order->paid ? 'success' : 'danger' }}">
                {{ $order->paid ? trans('orders::general.paid') : trans('orders::general.not-paid') }}
            </strong>
        </p>

        @if($order->comment)
            <strong><i class="fa fa-file-text-o margin-r-5"></i> @lang('orders::general.order-comment')</strong>
            <p>{{ $order->comment }}</p>
        @endif
    </div>
</div>
