@php
/** @var int $productId */
@endphp
<div class="gcell gcell--4 _plr-sm _md-plr-lg _ptb-sm">
    <a
        class="cart-item__action cart-item__action--move-to-wish-list"
        data-cart-action="move-to-wishlist"
        data-product-id="{{ $productId }}"
    >
        {!! SiteHelpers\SvgSpritemap::get('icon-wishlist', []) !!}
        <div class="cart-item__action-text">@lang('wishlist::site.move-to-wishlist')</div>
    </a>
</div>
