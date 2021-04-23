@php
/** @var \App\Modules\Products\Models\Product $product */
$productId = $product->id;
$productImage = $product->preview;
$productLink = $product->site_link;
$productOldPrice = $product->formatted_old_price;
$productCurrentPrice = $product->formatted_price;
@endphp

<div class="wishlist-card {{ $product->is_available ? '' : 'is-not-available' }}" data-wishlist-card data-product data-product-id="{{ $productId }}" data-product-price="{{ $product->price }}">
    <div class="grid _flex-nowrap">
        <div class="gcell _pr-sm _flex-noshrink">
            <div class="wishlist-card__checker">
                @include('site._widgets.checker.checker', [
                    'attributes' => [
                        'type' => 'checkbox',
                        'name' => 'wishlist-product',
                        'value' => $productId,
                        'data-wishlist-manager-item' => true,
                        'disabled' => !$product->is_available
                    ],
                    'disabled' => $product->is_available === false ? ' disabled' : null
                ])
            </div>
        </div>
        <div class="gcell _plr-sm _flex-grow">
            <div class="grid _xs-flex-nowrap">
                <div class="gcell gcell--12 gcell--xs-auto _flex-noshrink _pb-sm _xs-pb-none _xs-pr-xs">
                    <a href="{{ $productLink }}" class="wishlist-card__image">{!! $productImage->imageTag('small') !!}</a>
                </div>
                <div class="gcell gcell--12 gcell--xs-auto _flex-grow _pt-sm _xs-pt-none _xs-pl-xs _text-center _xs-text-left">
                    <div class="grid _flex-nowrap _mb-lg _xs-mb-sm _nmlr-def">
                        <div class="gcell _flex-grow _plr-def">
                            <a href="{{ $productLink }}" class="wishlist-card__name">{{ $product->name }}</a>
                        </div>
                    </div>
                    <div class="grid _items-center _nm-def _md-flex-nowrap">
                        <div class="gcell gcell--12 gcell--md-auto _flex-grow _p-def">
                            @if($product->is_available === false)
                                <div class="product-status _mb-xs">
                                    <div class="product-status__icon">
                                        {!! SiteHelpers\SvgSpritemap::get($product->is_available ? 'icon-available' : 'icon-not-available') !!}
                                    </div>
                                    <div class="product-status__text">@lang(config('products.availability.' . $product->available))</div>
                                </div>
                            @endif
                            <div class="grid _justify-center _xs-justify-start _items-center _md-flex-nowrap _nmtb-xs">
                                @if($productOldPrice)
                                    <div class="gcell gcell--12 gcell--md-auto _ptb-xs _xs-pr-md">
                                        <div class="wishlist-card__price-old">{{ $productOldPrice }}</div>
                                    </div>
                                @endif
                                <div class="gcell gcell--auto _ptb-xs _pr-def">
                                    <div class="wishlist-card__price-current">{{ $productCurrentPrice }}</div>
                                </div>
                                @if($product->is_available)
                                    <div class="gcell gcell--auto _ptb-xs _plr-md">
                                        <button class="button button--theme-main button--size-normal" data-cart-action="add" data-product-id="{{ $productId }}">
                                            <span class="button__body">
                                                {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                                                    'class' => 'button__icon button__icon--before',
                                                    'style' => 'width: 20px; height: 20px'
                                                ]) !!}
                                            </span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gcell _pl-sm _flex-noshrink _text-right">
            <div class="wishlist-card__options">
                <div class="dropdown dropdown--to-left js-init" data-toggle>
                    <div class="dropdown__head" data-toggle-trigger>
                        <div class="dropdown__head-svg">{!! SiteHelpers\SvgSpritemap::get('icon-options', []) !!}</div>
                    </div>
                    <div class="dropdown__body _pl-xl" data-toggle-content>
                        <div class="grid">
                            @if($product->is_available)
                                <div class="gcell gcell--12 _pt-md _pb-sm">
                                    <button class="button button--air _color-main _fill-main" data-cart-action="add" data-product-id="{{ $productId }}">
                                        <span class="button__body">
                                            {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                                                'class' => 'button__icon button__icon--before',
                                                'style' => 'width: 20px; height: 20px',
                                            ]) !!}
                                            <span class="button__text">@lang('wishlist::site.buy')</span>
                                        </span>
                                    </button>
                                </div>
                            @endif
                            <div class="gcell gcell--12 _pt-sm _pb-md">
                                <button class="button button--air" data-wishlist-toggle="{{ $productId }}">
                                    <span class="button__body">
                                        {!! SiteHelpers\SvgSpritemap::get('icon-close', [
                                            'class' => 'button__icon button__icon--before',
                                            'style' => 'width: 15px; height: 15px; margin-left: 2px; margin-right: 3px;',
                                        ]) !!}
                                        <span class="button__text">@lang('wishlist::site.delete')</span>
                                    </span>
                                </button>
                            </div>
                            <div class="gcell gcell--12 _pt-md _pb-sm" style="border-top: 1px solid #f2f2f2;">
                                <button class="button button--air {{ CompareProducts::has($product->id) ? 'is-active' : null }}" data-comparelist-toggle="{{ $productId }}">
                                    <span class="button__body button__body">
                                        {!! SiteHelpers\SvgSpritemap::get('icon-to-compare', [
                                            'class' => 'button__icon button__icon--before button__icon--in-active',
                                            'style' => 'width: 20px; height: 20px; color: #ccc;'
                                        ]) !!}
                                        {!! SiteHelpers\SvgSpritemap::get('icon-compare', [
                                            'class' => 'button__icon button__icon--before button__icon--is-active _fill-secondary',
                                            'style' => 'width: 20px; height: 20px;'
                                        ]) !!}
                                        <span class="button__text button__text--in-active">@lang('wishlist::site.compare')</span>
                                        <span class="button__text button__text--is-active">@lang('wishlist::site.in-compare')</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
