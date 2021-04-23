@php
/** @var \App\Modules\Orders\Components\Cart $cart */
@endphp

<div class="cart-detailed {{ $cart->getTotalQuantity() ? null : 'is-empty' }}">
    <div class="cart-detailed__title _mt-none _mb-def">@lang('orders::site.cart-is-empty')</div>
    <div class="cart-detailed__involve _mb-def">{!! __('orders::site.cart-is-empty-text') !!}</div>
    <button class="button button--theme-default button--size-normal" data-cart-trigger="close">
        <span class="button__body">
            <span class="button__text">@lang('categories::general.buy-something')</span>
        </span>
    </button>
</div>
