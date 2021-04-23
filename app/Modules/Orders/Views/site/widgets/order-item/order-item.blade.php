@php
/** @var \App\Modules\Orders\Models\Order $order */
$information = [
    'orders::general.receiver' => $order->client ? $order->client->name : '',
    'orders::general.phone' => $order->client ? $order->client->phone : '',
    'orders::general.email' => $order->client ? $order->client->email : '',
    'orders::general.payment-method' => trans('orders::general.payment-methods.' . $order->payment_method),
    'orders::general.delivery-type' => trans('orders::general.deliveries.' . $order->delivery),
    'orders::general.delivery-address' => $order->delivery_address,
    'orders::general.ttn' => $order->ttn ?? null,
];
@endphp

<div id="order-item-{{ $order->id }}" class="order-item js-init" data-accordion data-toggle data-user-config="{{ json_encode(['closeOnClickOutSide' => false]) }}">
    <div class="order-item__head" data-toggle-trigger>
        <div class="order-item__bg" style="color: {{ $order->status ? $order->status->color : '#f8f8f8' }};"></div>
        <div class="grid _justify-between _items-center _lg-flex-nowrap _posr">
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__id" style="color: {{ $order->status ? $order->status->color : '#f8f8f8' }};" title="@lang('orders::general.order-id')">№&nbsp;{{ $order->id }}</div>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__date" title="@lang('orders::general.order-created-at')">
                    <strong>{{ $order->formatted_date }}</strong> {{ $order->created_at->format('H:i') }}
                </div>
            </div>
            <div class="gcell gcell--auto order-item__cell"></div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__total-quantity"
                     title="@lang('orders::general.order-items')">{{ $order->items->count() }} {{ site_plural($order->items->count()) }}</div>
                <button class="button button--air order-item__inform" data-wstabs-ns="extended-info-{{ $order->id }}"
                        data-wstabs-button="1" data-toggle-prevent>
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-info', [
                            'class' => 'button__icon button__icon--before'
                        ]) !!}
                        {!! SiteHelpers\SvgSpritemap::get('icon-arrow-bottom', [
                            'class' => 'button__icon button__icon--after',
                        ]) !!}
                        <span class="button__text">@lang('orders::site.order-full-information')</span>
                    </span>
                </button>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__total-amount" title="@lang('orders::general.order-amount')">
                    <strong>{{ $order->total_amount }}</strong>
                </div>
                <a href="{{ route('site.print', $order->id) }}" class="button button--air order-item__print" target="_blank" data-print data-toggle-prevent>
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-print', [
                            'class' => 'button__icon button__icon--before'
                        ]) !!}
                        <span class="button__text">@lang('orders::general.print-order')</span>
                    </span>
                </a>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__status" style="color: {{ $order->status ? $order->status->color : '#f8f8f8' }};" title="@lang('orders::general.order-status')">{{ $order->status ? $order->status->current->name : '&mdash;' }}</div>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__options order-item__options--more" title="@lang('global.more')">
                    {!! SiteHelpers\SvgSpritemap::get('icon-options', []) !!}
                </div>
                <div class="order-item__options order-item__options--less" title="@lang('global.close')">
                    {!! SiteHelpers\SvgSpritemap::get('icon-options', []) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="order-item__body" data-toggle-content>
        <div class="grid">
            <div class="gcell gcell--12 gcell--lg-8">
                <div class="order-item__main-details">
                    <div class="_nmtp-xs" style="display: none;" data-wstabs-ns="extended-info-{{ $order->id }}" data-wstabs-block="1">
                        <div class="_plr-def _ms-plr-xl _ptb-sm _ms-ptb-lg" style="border-bottom: 1px solid #f2f2f2;">
                            @foreach($information as $label => $value)
                                @if($order->delivery == 'other' && $label == 'orders::general.delivery-address')
                                    @continue
                                @endif
                                @if($value)
                                    <div class="grid _justify-between _sm-flex-nowrap _ptb-xs">
                                        <div class="gcell gcell--12 gcell--sm-auto _flex-noshrink _pr-sm">
                                            <div class="_color-black">@lang($label):</div>
                                        </div>
                                        <div class="gcell gcell--12 gcell--sm-auto _flex-grow _pl-sm">
                                            @if($label == 'orders::general.delivery-type' && $order->delivery == 'other')
                                                <div class="_color-gray6 _sm-text-right">{{ $order->delivery_address }}</div>
                                            @else
                                                <div class="_color-gray6 _sm-text-right">{{ $value }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="_plr-def _ms-plr-xl _ms-ptb-lg" style="border-bottom: 1px solid #f2f2f2;">
                        @foreach($order->items as $item)
                            {!! Widget::show('products::in-order', $item->product_id, $item->price, $item->quantity, $item->dictionary_id) !!}
                        @endforeach
                    </div>
                    <div class="_plr-def _ms-plr-xl _ptb-md" style="border-bottom: 1px solid #f2f2f2; font-size: 1rem;">
                        <div class="grid _justify-between _ptb-xs">
                            <div class="gcell gcell--auto">
                                @if($order->delivery == 'other')
                                    <div class="_color-gray5" style="font-weight: 300;">{{ $order->delivery_address }}</div>
                                @else
                                    <div class="_color-gray5" style="font-weight: 300;">@lang('orders::general.deliveries.' . $order->delivery)</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="_plr-def _ms-plr-xl _ptb-md _ms-ptb-lg" style="font-size: 1.125rem;">
                        <div class="grid _justify-between _ptb-xs">
                            <div class="gcell gcell--auto">
                                <div class="_color-black" style="font-weight: 300;">@lang('orders::site.money-to-pay')</div>
                            </div>
                            <div class="gcell gcell--auto">
                                <div class="_color-black"><strong>{{ $order->total_amount }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--12 gcell--lg-4" style="border-left: 1px solid #f2f2f2;">
                <div class="order-item__aside-details">
                    <div class="_plr-def _ms-plr-xl _pt-sm _lg-pt-lg _pb-sm _lg-pb-def">
                        <div class="grid _justify-between _items-center">
                            <div class="gcell gcell--auto">
                                <div class="order-item__status" style="color: {{ $order->status ? $order->status->color : '#f8f8f8' }};" title="@lang('orders::general.order-status')">{{ $order->status ? $order->status->current->name : '&mdash;' }}</div>
                            </div>
                        </div>
                    </div>
                    @if($order->ttn && ($order->delivery === 'nova-poshta-self' || $order->delivery === 'nova-poshta'))
                        <div class="_plr-def _ms-plr-xl _pt-sm _lg-pt-lg _pb-sm _lg-pb-def">
                            <a class="js-init" data-mfp="ajax" data-mfp-src="{{ route('site.orders.get-delivery-status', ['order' => $order->id]) }}" href="#" style="
                                display: inline-block;
                                margin: 0 8px 5px 0;
                                vertical-align: middle;
                                text-decoration: none;
                                border-bottom: 1px dotted;
                            ">@lang('orders::site.delivery-history')</a>
                        </div>
                    @endif
                    <div class="_plr-def _ms-plr-xl _pb-sm _ms-pb-lg _pt-sm _ms-pt-def">
                        <div class="grid _items-center _nm-xs">
                            @if($order->payment_method === 'bank_transaction' || $order->payment_method === 'liqpay')
                                <div class="gcell gcell--auto _p-xs">
                                    <img src="{{ site_media('static/images/payment-methods/mastercard.png') }}" alt="Mastercard">
                                </div>
                                <div class="gcell gcell--auto _p-xs">
                                    <img src="{{ site_media('static/images/payment-methods/visa.png') }}" alt="VISA">
                                </div>
                            @endif
                            @if($order->delivery === 'nova-poshta-self' || $order->delivery === 'nova-poshta')
                                <div class="gcell gcell--auto gcell--lg-12 _p-xs">
                                    <img src="{{ site_media('static/images/payment-methods/nova-poshta.png') }}" alt="Nova Poshta">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
