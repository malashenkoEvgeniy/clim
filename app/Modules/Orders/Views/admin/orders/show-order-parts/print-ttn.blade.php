<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('orders::general.ttn-tab-h1')</h3>
    </div>
    <div class="box-body">
        <div class="col-md-4">
            {!!
                Html::link(
                    route('admin.orders.print-ttn', ['order' => $order->id]),
                    trans('orders::general.print-en'), [
                        'class' => 'btn btn-success btn-block', 'target' => '_blank',
                    ]
                )
            !!}
        </div>
        <div class="col-md-4">
            {!!
                Html::link(
                    route('admin.orders.get-status-ttn', ['order' => $order->id]),
                    trans('orders::general.get-status-en'), [
                        'class' => 'btn btn-warning btn-block ajax-request',
                    ]
                )
            !!}
        </div>
        <div class="col-md-4">
            {!!
                Html::link(
                    route('admin.orders.delete-ttn', ['order' => $order->id]),
                    trans('orders::general.delete-en'), [
                        'class' => 'btn btn-danger btn-block ajax-request',
                        'data-confirmation' => 'Удаление ЭН',
                    ]
                )
            !!}
        </div>
    </div>
</div>
