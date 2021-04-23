@php
/** @var \App\Modules\Orders\Components\Cart\Cart $cart */
/** @var array $addedProducts */
/** @var string $totalAmount */
/** @var bool $showButton */
/** @var int|null $dictionaryId */

$addedProducts = $addedProducts ?? [];
@endphp

<div class="cart-detailed {{ $cart->getTotalQuantity() > 0 ? null : 'is-empty' }}">
    <div class="cart-detailed__body">
        @if (count($addedProducts) > 0)
            <div class="cart-detailed__section">
                <div class="cart-detailed__title">@lang('orders::site.item-added-to-cart')</div>
                <div class="cart-detailed__items-list">
                    @foreach($addedProducts as $addedProduct)
                        @php($cartItem = $cart->getItem($addedProduct, $dictionaryId))
                        @if($cartItem)
                            {!!
                                Widget::show(
                                    'products::cart-item',
                                    $cartItem->getProductId(),
                                    $cartItem->getQuantity(),
                                    $cartItem->getDictionaryId()
                                )
                            !!}
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        @if($cart->getItems()->count() > count($addedProducts))
            <div class="cart-detailed__section">
                <div class="cart-detailed__title">{{ $addedProducts ? __('orders::site.other-items') : __('orders::site.cart') }}</div>
                <div class="cart-detailed__items-list">
                    @foreach($cart->getItems() as $cartItem)
                        @if(in_array($cartItem->getProductId(), $addedProducts) && $cartItem->getDictionaryId() === $dictionaryId)
                            @continue
                        @endif
                        {!!
                            Widget::show(
                                'products::cart-item',
                                $cartItem->getProductId(),
                                $cartItem->getQuantity(),
                                $cartItem->getDictionaryId()
                            )
                        !!}
                    @endforeach
                </div>
            </div>
        @endif
        <div class="cart-detailed__summary">
            <div class="hint hint--decore _text-right"><span>@lang('orders::site.total')</span></div>
            @if($totalAmountOld != $totalAmount)
                <div class="cart-detailed__old-total-price">{{ $totalAmountOld }}</div>
            @endif
            <div class="cart-detailed__total-price"><strong>{{ $totalAmount }}</strong></div>
        </div>
    </div>
    <div class="cart-detailed__footer">
        <div class="grid _items-center _justify-center _justify-between">
            <div class="gcell gcell--auto _flex-noshrink">
                <button class="button button--theme-default button--size-collapse-normal" data-cart-trigger="close">
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-back', [
                        'class' => 'button__icon button__icon--before'
                    ]) !!}
                        <span class="button__text">@lang('categories::general.buy-something')</span>
                    </span>
                </button>
            </div>
            <div class="gcell gcell--auto _pl-md _flex-noshrink">
                {!! Widget::show('orders::checkout-button') !!}
            </div>
        </div>
    </div>
</div>
