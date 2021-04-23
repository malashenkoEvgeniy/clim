@php
/** @var \App\Modules\Orders\Models\Order $order */
$customerTemplate = ($order->user && $order->user->exists) ? 'customer' : 'receiver';
$canEdit = CustomRoles::can('orders.edit');
$canDelete = CustomRoles::can('orders.destroy');
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
        @include('orders::admin.orders.show-order-parts.receiver', ['order' => $order])
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
        @if($order->ttn)
            <b>@lang('orders::general.ttn-number'):</b> {{ $order->ttn }}<br>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        $(document).ajaxComplete(function (event, jqxhr) {
            var response = prepareIncomingData(jqxhr.responseJSON);
            if (!response) {
                return false;
            }
            if (response.insert !== undefined) {
                $('#order-items-list').html(response.insert);
            }
        });

        $('#order-items-list').on('click', '.update-item', function () {
            var $button = $(this), $tr = $button.closest('tr'),
                url = $tr.data('url'), quantity = $tr.find('input[name="quantity"]').val(), dictionary = $tr.find('select[name="dictionary"]').val();
            $.ajax({
                url,
                method: 'POST',
                data: {
                    _method: 'PUT',
                    quantity,
                    dictionary
                }
            });
        });
    </script>
@endpush

<div id="order-items-list">
    @if($order->items && $order->items->isNotEmpty())
        @include('orders::admin.orders.show-order-parts.invoice-items', [
            'order' => $order,
        ])
    @else
        @include('orders::admin.orders.show-order-parts.no-items', ['order' => $order])
    @endif
</div>
