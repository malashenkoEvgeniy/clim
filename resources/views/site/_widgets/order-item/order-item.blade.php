@php
    $order_status_list = [
        'is-new' => 'Новый заказ',
        'in-processing' => 'В обработке',
        'is-fulfilled' => 'Выполнен',
        'is-rejected' => 'Отменен',
    ];

    $order_extended_info_keys = [
        'Способ оплаты',
        'Способ доставки',
        'Получатель',
        'Телефон',
        'Адрес доставки',
        'Эл. почта',
        'Этот элемент никогда не выведется',
        'Номер ТТН',
    ];

    $total_amount = 0;
    $total_quantity = 0; // вычисляем суммарное кол-во товарных единиц в заказе
    foreach ($data->items as $product) {
        $total_amount += $product->cost * $product->count;
        $total_quantity += $product->count;
    }
@endphp

<div id="order-item-{{ $data->id }}" class="order-item {{ array_keys($order_status_list)[$data->status] ?? 'is-unknown' }} js-init" data-accordion data-toggle data-user-config="{{ json_encode(['closeOnClickOutSide' => false]) }}">
    <div class="order-item__head" data-toggle-trigger>
        <div class="grid _justify-between _items-center _lg-flex-nowrap">
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__id" title="Номер заказа">№&nbsp;{{ $data->id }}</div>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__date" title="Дата заказа"><strong>{{ $data->created_date }}</strong> {{ $data->created_time }}</div>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="grid _items-center _flex-nowrap _lg-flex-wrap _xl-flex-nowrap _nmlr-xxs" title="Товары в заказе">
                    @foreach($data->items as $product)
                        @php
                            $_max = 5; // не стоит выводить более 5 елементов, иначе не хватит места по горизонтали
                        @endphp

                        <div class="gcell gcell--auto _plr-xxs">
                            {!! Widget::show('image', $product->preview, 'small', ['class' => 'order-item__product-preview']) !!}
                        </div>

                        @if($loop->iteration === $_max && count(array_slice($data->items, $_max)) > 0)
                            <div class="gcell gcell--auto gcell--lg-12 gcell--xl-auto _plr-xxs _lg-mt-xs _xl-mt-none">
                                <span style="font-size: 12px; white-space: nowrap;">+ еще {{ count(array_slice($data->items, $_max)) }}</span>
                            </div>
                        @endif

                        @if($loop->iteration === $_max)
                            @break
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__total-quantity" title="Товары в заказе">{{ count($data->items) }} {{ site_plural(count($data->items)) }}</div>
                <button class="button button--air order-item__inform" data-wstabs-ns="extended-info-{{ $data->id }}" data-wstabs-button="1" data-toggle-prevent>
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-info', [
                            'class' => 'button__icon button__icon--before'
                        ]) !!}
                        {!! SiteHelpers\SvgSpritemap::get('icon-arrow-bottom', [
                            'class' => 'button__icon button__icon--after',
                        ]) !!}
                        <span class="button__text">Полная информацию о заказе</span>
                    </span>
                </button>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__total-amount" title="Сумма заказа"><strong>{{ number_format($total_amount, 2, '.', ' ') }}</strong>&nbsp;грн</div>
                <button class="button button--air order-item__print" data-print data-toggle-prevent>
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-print', [
                            'class' => 'button__icon button__icon--before'
                        ]) !!}
                        <span class="button__text">Распечатать заказ</span>
                    </span>
                </button>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__status" title="Статус заказа">{{ array_values($order_status_list)[$data->status] ?? 'Неизвестно' }}</div>
            </div>
            <div class="gcell gcell--auto order-item__cell">
                <div class="order-item__options order-item__options--more" title="Подробнее">
                    {!! SiteHelpers\SvgSpritemap::get('icon-options', []) !!}
                </div>
                <div class="order-item__options order-item__options--less" title="Закрыть">
                    {!! SiteHelpers\SvgSpritemap::get('icon-options', []) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="order-item__body" data-toggle-content>
        <div class="grid">
            <div class="gcell gcell--12 gcell--lg-8">
                <div class="order-item__main-details">
                    <div class="_nmtp-xs" style="display: none;" data-wstabs-ns="extended-info-{{ $data->id }}" data-wstabs-block="1">
                        <div class="_plr-def _ms-plr-xl _ptb-sm _ms-ptb-lg" style="border-bottom: 1px solid #f2f2f2;">
                            @foreach($data->extended_info as $index => $info)
                                @if($info)
                                    <div class="grid _justify-between _sm-flex-nowrap _ptb-xs">
                                        <div class="gcell gcell--12 gcell--sm-auto _flex-noshrink _pr-sm">
                                            <div class="_color-black">{{ $order_extended_info_keys[$index] }}:</div>
                                        </div>
                                        <div class="gcell gcell--12 gcell--sm-auto _flex-grow _pl-sm">
                                            <div class="_color-gray6 _sm-text-right">{{ $info }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="_plr-def _ms-plr-xl _ms-ptb-lg" style="border-bottom: 1px solid #f2f2f2;">
                        @foreach($data->items as $product)
                            @include('site._widgets.order-product.order-product', [
                                'data' => $product
                            ])
                        @endforeach
                    </div>
                    <div class="_plr-def _ms-plr-xl _ptb-md" style="border-bottom: 1px solid #f2f2f2; font-size: 1rem;">
                        <div class="grid _justify-between _ptb-xs">
                            <div class="gcell gcell--auto">
                                <div class="_color-gray5" style="font-weight: 300;">Доставка (Курьер Новая почта)</div>
                            </div>
                            <div class="gcell gcell--auto">
                                <div class="_color-gray5"><strong>50 грн</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="_plr-def _ms-plr-xl _ptb-md _ms-ptb-lg" style="font-size: 1.125rem;">
                        <div class="grid _justify-between _ptb-xs">
                            <div class="gcell gcell--auto">
                                <div class="_color-black" style="font-weight: 300;">Итого к оплате</div>
                            </div>
                            <div class="gcell gcell--auto">
                                <div class="_color-black"><strong>{{ number_format($total_amount, 2, '.', ' ') }} грн</strong></div>
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
                                <div class="order-item__status" title="Статус заказа">{{ array_values($order_status_list)[$data->status] ?? 'Неизвестно' }}</div>
                            </div>
                            {{--<div class="gcell gcell--auto">
                                <button class="button button--air order-item__history">
                                    <span class="button__body">
                                        {!! SiteHelpers\SvgSpritemap::get('icon-arrow-bottom', [
                                            'class' => 'button__icon button__icon--after',
                                        ]) !!}
                                        <span class="button__text">История заказа</span>
                                    </span>
                                </button>
                            </div>--}}
                        </div>
                    </div>
                    <div class="_plr-def _ms-plr-xl _pb-sm _ms-pb-lg _pt-sm _ms-pt-def">
                        <div class="grid _items-center _nm-xs">
                            <div class="gcell gcell--auto _p-xs">
                                <img src="{{ site_media('static/images/payment-methods/mastercard.png') }}" alt="Mastercard">
                            </div>
                            <div class="gcell gcell--auto _p-xs">
                                <img src="{{ site_media('static/images/payment-methods/visa.png') }}" alt="VISA">
                            </div>
                            <div class="gcell gcell--auto gcell--lg-12 _p-xs">
                                <img src="{{ site_media('static/images/payment-methods/nova-poshta.png') }}" alt="Nova Poshta">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
