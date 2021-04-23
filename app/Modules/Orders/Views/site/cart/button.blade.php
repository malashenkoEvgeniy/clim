@php
/** @var int $productId */
$data_dictionary = [
    'ru' => [
        'buy' => trans('orders::site.buy'),
        'in-cart' => trans('orders::site.in-cart'),
    ],
    'ua' => [
        'buy' => trans('orders::site.buy'),
        'in-cart' => trans('orders::site.in-cart'),
    ],
];
@endphp
<div class="item-card-controls__control _def-flex-grow">
    <button type="button"
            class="button button--theme-main {{ $withText ? 'button--size-normal' : 'button--size-collapse-normal' }} button--width-full"
            data-cart-action="add"
            data-product-id="{{ $productId }}"
            data-dictionary="{{ json_encode($data_dictionary) }}"
    >
        <span class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                'class' => 'button__icon button__icon--before'
            ]) !!}
            <span class="button__text">@lang('products::site.buy')</span>
        </span>
    </button>
</div>
