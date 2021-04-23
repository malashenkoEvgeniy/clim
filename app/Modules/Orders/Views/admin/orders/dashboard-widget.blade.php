@php
/** @var \App\Modules\Orders\Models\Order[] $orders */
@endphp

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('orders::general.last-orders')</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            @if($orders && $orders->count() > 0)
                @include('orders::admin.orders.table', ['orders' => $orders, 'class' => 'no-margin'])
            @else
                @include('orders::admin.orders.no-orders')
            @endif
        </div>
    </div>
    <div class="box-footer clearfix">
        @if(CustomRoles::can('orders.create'))
            <a href="{{ route('admin.orders.create') }}" class="btn btn-sm btn-info btn-flat pull-left">
                @lang('orders::general.create-new')
            </a>
        @endif
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-default btn-flat pull-right">
            @Lang('orders::general.full-list')
        </a>
    </div>
</div>