@php
/** @var \App\Modules\Orders\Models\Order $order */
@endphp

<div class="pad margin no-print">
    <div class="callout callout-danger">
        <h4><i class="fa fa-warning"></i> @lang('global.attention')!</h4>
        @lang('orders::general.no-items-message')
    </div>

    <div class="row no-print">
        <div class="col-xs-12">
            <button href="{{ route('admin.orders.add-item', $order->id) }}" type="button" class="ajax-request btn btn-default pull-right">
                <i class="fa fa-plus"></i> @lang('orders::general.add-item')
            </button>
        </div>
    </div>
</div>
