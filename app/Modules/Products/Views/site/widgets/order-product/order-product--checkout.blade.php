@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var string $formattedPrice */
/** @var string $formattedAmount */
/** @var int $quantity */
/** @var int|null $dictionaryId */

$productLink = $product ? sprintf("href=\"%s\"", $product->site_link) : null;

/** @var \App\Core\Modules\Images\Models\Image|null $image */
$image = $product ? $product->preview : null;

$dictionary = Widget::show('products_dictionary::display-text', $dictionaryId ?? null);
@endphp
<div class="order-product order-product--checkout">
    <div class="grid _justify-end _sm-justify-between _items-center _sm-flex-nowrap _nm-xxs _sm-nm-sm">
        <div class="gcell gcell--auto order-product__cell _flex-noshrink _p-xxs _sm-p-sm">
            <a class="order-product__preview" {!! $productLink !!}>
                {!! Widget::show('image', $image, 'small', ['class' => 'order-product__image']) !!}
            </a>
        </div>
        <div class="gcell gcell--auto order-product__cell _flex-grow _p-xxs _sm-p-sm _mr-auto">
            <a class="order-product__link" {!! $productLink !!}>
                <div class="order-product__name">{{ $product ? ($product->name ?? '&mdash;') : trans('products::site.deleted') }}</div>
            </a>
            @if($dictionary)
            <div class="order-product__label _mt-xs">
                {!! $dictionary !!}
            </div>
            @endif
        </div>
        <div class="gcell gcell--auto order-product__cell _flex-noshrink _ptb-xxs _sm-ptb-sm">
            <div class="order-product__qty">{{ $quantity }} &times; <strong>{{ $formattedPrice }}</strong></div>
        </div>
    </div>
</div>
