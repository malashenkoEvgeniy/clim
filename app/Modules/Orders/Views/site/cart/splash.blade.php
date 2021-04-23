@php
/** @var \App\Modules\Orders\Components\Cart $cart */
@endphp

<div class="action-bar__control _def-show">
    <div role="button" tabindex="0" class="action-bar-control action-bar-control--cart {{ $cart->getTotalQuantity() > 0 ? 'has-content' : null }}" data-cart-trigger="open" data-cart-splash>
        {!! SiteHelpers\SvgSpritemap::get('icon-shopping', ['class' => 'action-bar-control__icon']) !!}
        <div class="action-bar-control__title _ellipsis">@lang('orders::site.cart')</div>
        <div class="action-bar-control__count" data-cart-counter="total-quantity">{{ $cart->getTotalQuantity() ?: null }}</div>
    </div>
    <div class="popover">
        <div data-cart-container="briefly">
            @include('orders::site.cart.cart--briefly', [
                'cart' => $cart,
                'totalAmount' => Widget::show('products::amount', Cart::getQuantities()),
                'totalAmountOld' => Widget::show('products::amount-old', Cart::getQuantities()),
            ])
        </div>
    </div>
</div>
