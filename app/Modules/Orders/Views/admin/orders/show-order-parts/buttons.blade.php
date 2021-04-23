@php
/** @var \App\Modules\Orders\Models\Order $order */
$canDelete = CustomRoles::can('orders.destroy');
$canEdit = CustomRoles::can('orders.edit');
@endphp
@if($canDelete || $canEdit)
    <div class="margin-bottom">
        @if($canEdit)
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-large btn-success btn-flat">
                @lang('orders::general.edit-order')
            </a>
        @endif
        @if($canDelete)
            <a href="{{ route('admin.orders.destroy', $order->id) }}" class="btn btn-large btn-default btn-flat pull-right" data-toggle="confirmation">
                <i class="fa fa-trash"></i>
            </a>
        @endif
    </div>
@endif
