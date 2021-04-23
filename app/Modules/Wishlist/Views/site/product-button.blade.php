@php
/** @var int $productId */
/** @var bool $isInWishlist */
@endphp

<div class="item-card-controls__control _flex-noshrink">
    <button class="button button--theme-item-action button--size-normal {{ $isInWishlist ? 'is-active' : null }}" type="button" data-wishlist-toggle="{{ $productId }}">
        <span class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-to-wishlist', [
                'class' => 'button__icon button__icon--before'
            ]) !!}
        </span>
    </button>
</div>
