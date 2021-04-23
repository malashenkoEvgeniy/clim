@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var int $quantity */
$productLink = sprintf("href=\"%s\"", $product->site_link);
$productId = $product->id;
$productName = $product->name;
$image = $product->preview;

$productPrice = $product->formatted_price;
$itemPrice = $product->price * $quantity;
if (Catalog::currenciesLoaded()) {
    $itemPrice = Catalog::currency()->format($itemPrice);
}
@endphp

<div class="cart-item" data-product data-product-id="{{ $productId }}" {!! isset($dictionaryId) ? 'data-dictionary-id="'. $dictionaryId .'"' : null !!}>
    <form onsubmit="event.preventDefault()">
        {!! Form::hidden('old_dictionary_id', $dictionaryId ?? '') !!}
        <div class="grid _flex-nowrap">
            <div class="gcell gcell--auto _pr-md _sm-pr-def _flex-noshrink">
                <div class="cart-item__options">
                    <div class="dropdown dropdown--to-right js-init" data-toggle>
                        <div class="dropdown__head" data-toggle-trigger>
                            <div class="dropdown__head-svg">{!! SiteHelpers\SvgSpritemap::get('icon-close-rounded-sm', []) !!}</div>
                        </div>
                        <div class="dropdown__body" data-toggle-content>
                            <div class="grid" style="height: 100%;">
                                <div class="gcell gcell--12 gcell--ms-auto _ms-pl-def _flex-grow">
                                    <div class="grid _justify-center _items-center _nmlr-sm _md-nmlr-lg _text-center" style="height: 100%;">
                                        {!! Widget::show('wishlist::move', $productId) !!}
                                        <div class="gcell gcell--4 _plr-sm _md-plr-lg _ptb-sm">
                                            <a
                                               class="cart-item__action cart-item__action--delete"
                                               data-cart-action="delete"
                                               data-product-id="{{ $productId }}"
                                            >
                                                {!! SiteHelpers\SvgSpritemap::get('icon-close', []) !!}
                                                <div class="cart-item__action-text">@lang('products::site.cart.delete')</div>
                                            </a>
                                        </div>
                                        <div class="gcell gcell--4 _plr-sm _md-plr-lg _ptb-sm">
                                            <a class="cart-item__action cart-item__action--cancel" data-toggle-close>
                                                {!! SiteHelpers\SvgSpritemap::get('icon-back', []) !!}
                                                <div class="cart-item__action-text">@lang('products::site.cart.cancel')</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--auto _md-plr-def _flex-noshrink">
                <a {!! $productLink !!} class="cart-item__image">
                    {!! Widget::show('image', $image, 'small') !!}
                </a>
            </div>
            <div class="gcell gcell--auto _pl-def _flex-grow">
                <div class="grid">
                    <div class="gcell gcell--12 _pb-def">
                        <a {!! $productLink !!} class="cart-item__name">{{ $productName }}</a>
                    </div>
                    @if($dictionaryId)
                        {!! Widget::show('products_dictionary::show-in-cart', $productId, $dictionaryId) !!}
                    @endif
                    <div class="gcell gcell--12">
                        <div class="grid _justify-between _items-center _sm-flex-nowrap">
                            <div class="gcell _flex-noshrink _pr-lg _sm-show">
                                <div class="cart-item__unit-price">{{ $productPrice }}</div>
                            </div>
                            <div class="gcell _flex-noshrink">
                                <div class="cart-item__unit-quantity">
                                    <div class="input-quantity js-init" data-quantity>
                                        <div class="grid _justify-between _items-center _flex-nowrap">
                                            <div class="gcell gcell--auto _flex-grow _flex-order-2">
                                                <input class="input-quantity__field" type="tel" name="quantity" value="{{ $quantity }}" data-quantity="input" data-product-quantity>
                                            </div>
                                            <div class="gcell gcell--auto _flex-noshrink _flex-order-3">
                                                <div class="input-quantity__increase" data-quantity="increase">+</div>
                                            </div>
                                            <div class="gcell gcell--auto _flex-noshrink _flex-order-1">
                                                <div class="input-quantity__decrease" data-quantity="decrease">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell _flex-noshrink _pl-lg">
                                <div class="cart-item__unit-price-total">{{ $itemPrice }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
