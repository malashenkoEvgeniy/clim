@php
/** @var \App\Modules\Orders\Components\Cart\Cart $cart */
$amount = Widget::show('products::amount', Cart::getQuantities());
$amountOld = Widget::show('products::amount-old', Cart::getQuantities());
@endphp

<div class="cart-checkout">
    <div class="cart-checkout__head">
        <div class="cart-checkout__title">@lang('orders::site.your-order')</div>
    </div>
    <div class="cart-checkout__body">
        @foreach($cart->getItems() as $cartItem)
            {!!
                Widget::show(
                    'products::checkout',
                    $cartItem->getProductId(),
                    $cartItem->getQuantity(),
                    $cartItem->getDictionaryId()
                )
            !!}
        @endforeach
    </div>
    <div class="cart-checkout__footer">
        <div class="cart-checkout__total-amount">
            <div class="grid _justify-between _items-center">
                <div class="gcell gcell--auto _pr-sm">
                    <div>@lang('orders::site.total')</div>
                </div>
                <div class="gcell gcell--auto _pl-sm">
                    @if($amount != $amountOld)
                        <div class="cart-detailed__old-total-price">{{ $amountOld }}</div>
                    @endif
                    <div><strong>{{ $amount }}</strong></div>
                </div>
            </div>
        </div>
        <div class="_text-center _mt-lg">
            <span class="link link--sm js-init" data-cart-trigger="open" data-mfp>
                @lang('orders::site.edit-order')
            </span>
        </div>
    </div>
</div>
