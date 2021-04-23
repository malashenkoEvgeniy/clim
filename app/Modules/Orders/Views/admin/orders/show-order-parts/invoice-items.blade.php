@php
    /** @var \App\Modules\Orders\Models\Order $order */
    $canEdit = CustomRoles::can('orders.edit');

    $siteStatusTitle = config('db.products_dictionary.'. Lang::getLocale() .'_title', null);
    $siteStatus = config('db.products_dictionary.site_status');
@endphp

<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>@lang('orders::general.order-item')</th>
                @if($siteStatus)
                    <th>{{ $siteStatusTitle }}</th>
                @endif
                <th>@lang('orders::general.quantity')</th>
                <th>@lang('orders::general.price-for-one')</th>
                <th>@lang('orders::general.total')</th>
                @if($canEdit)
                    <th></th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                @php($formId = 'edit-item-' . $item->id)
                <tr data-url="{{ route('admin.orders.update-item', $item->id) }}">
                    <td>
                        {!! Widget::show('products::in-invoice', $item->product_id, true) !!}
                    </td>
                    @if($siteStatus)
                        @if($canEdit)
                            <td>{!! Widget::show('products_dictionary::choose-in-order-view', $item) !!}</td>
                        @else
                            <td>{!! Widget::show('products_dictionary::display-text', $item->id) !!}</td>
                        @endif
                    @endif
                    <td>
                    @if($canEdit)
                        <div class="form-group" style="display: inline-block;">
                            {!! Form::input('number', 'quantity', (int)$item->quantity, ['min' => 1, 'style' => 'width: 70px;', 'class' => 'form-control']) !!}
                        </div>
                        @else
                        {{ $item->quantity }}
                        @endif
                        @lang('orders::general.pieces')
                        </td>
                        <td>{{ $item->formatted_price }}</td>
                        <td>{{ $item->formatted_amount }}</td>
                        @if($canEdit)
                            <td>
                                {!! Form::button(Html::tag('i', '', ['class' => ['fa', 'fa-save']]), ['class' => ['btn', 'btn-xs', 'btn-flat', 'btn-primary', 'update-item'], 'type' => 'button']) !!}
                                {!! Form::button(
                                    Html::tag('i', '', ['class' => ['fa', 'fa-trash']]),
                                    [
                                        'href' => route('admin.orders.remove-item', $item->id),
                                        'class' => ['btn', 'btn-xs', 'btn-flat', 'btn-danger', 'ajax-request'],
                                        'type' => 'button',
                                        'data-confirmation' => trans('orders::general.delete-item-confirmation'),
                                    ]
                                ) !!}
                            </td>
                        @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-xs-6"></div>
    <div class="col-xs-6">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>@lang('orders::general.all-items-cost'):</th>
                    <td>{{ $order->total_amount }}</td>
                </tr>
                @if($order->total_amount != $order->total_amount_old)
                    <tr>
                        <th>@lang('orders::general.all-items-cost-wholesale'):</th>
                        <td>{{ $order->total_amount_old }}</td>
                    </tr>
                @endif
                <tr>
                    <th>@lang('orders::general.delivery'):</th>
                    <td>@lang('orders::general.by-delivery-service-tariff')</td>
                </tr>
                <tr>
                    <th>@lang('orders::general.total-to-pay'):</th>
                    <td>{{ $order->total_amount }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row no-print">
    <div class="col-xs-12">
        {!! Html::link(
            route('admin.orders.print', $order->id),
            Html::tag('i', '', ['class' => ['fa', 'fa-print']])->toHtml() . ' ' . trans('global.print'),
            [
                'target' => '_blank',
                'class' => ['btn', 'btn-default'],
            ],
            null, false
        ) !!}
        @if($canEdit)
            <button href="{{ route('admin.orders.add-item', $order->id) }}" type="button"
                    class="ajax-request btn btn-primary pull-right">
                <i class="fa fa-plus"></i> @lang('orders::general.add-item')
            </button>
        @endif
    </div>
</div>
