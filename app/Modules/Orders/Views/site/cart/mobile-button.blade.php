@php
/** @var \App\Modules\Cart\Components\Cart $cart */
@endphp

<div class="gcell _xs-ml-xs">
    <div role="button" tabindex="0" class="menu-button" data-cart-trigger="open" data-cart-splash>
        {!! \SiteHelpers\SvgSpritemap::get('icon-shopping', ['class' => 'menu-button__icon']) !!}
        <div class="menu-button__count" data-cart-counter="total-quantity">{{ $cart->getTotalQuantity() ?: null }}</div>
    </div>
</div>