@php
/** @var \App\Modules\Orders\Models\Order $order */
$form = \App\Modules\Orders\Forms\ChangeStatusForm::make($order);
@endphp

@push('scripts')
    <script>
        $(document).ajaxComplete(function (event, jqxhr) {
            var response = prepareIncomingData(jqxhr.responseJSON);
            if (!response) {
                return false;
            }
            if (response.insertStatus !== undefined) {
                $('#order-statuses-list').html(response.insertStatus);
            }
            if (response.status !== undefined) {
                var $status = $('#order-status span');
                $status.text(response.status.name);
                $status.attr('style', `background-color: ${response.status.color}!important;`);
            }
        });
    </script>
@endpush

@if(CustomRoles::can('orders', 'edit'))
    {!! $form->open(['route' => ['admin.orders.status', $order->id], 'class' => 'ajax-form', 'id' => 'change-order-status']) !!}
    {!! $form->render() !!}
    {!! $form->close() !!}
@endif

<div class="box-body table-responsive no-padding _mb-lg">
    <h2 class="page-header">@lang('orders::general.status-change-history')</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>@lang('orders::general.status-date')</th>
            <th>@lang('orders::general.order-status')</th>
            <th>@lang('orders::general.status-comment')</th>
        </tr>
        </thead>
        <tbody id="order-statuses-list">
        @include('orders::admin.orders.show-order-parts.status-history', ['order' => $order])
        </tbody>
    </table>
</div>
