@php
/** @var string $categoryLink */
/** @var \App\Modules\Products\Models\Product[] $products */
@endphp
<div class="compare-table" data-comparelist-table>
    <div class="compare-table__row compare-table__row--head _mb-md">
        <div class="compare-table__cell compare-table__cell--first grid _items-center _justify-center _def-show">
            <div class="gcell">
                <a href="{{ $categoryLink }}" class="button button--size-normal button--theme-main">
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-plus', [
                            'class' => 'button__icon button__icon--before'
                        ]) !!}
                        <span class="button__text">@lang('products::site.add-product')</span>
                    </span>
                </a>
            </div>
        </div>
        @foreach($products as $product)
            <div class="compare-table__cell compare-table__cell--head {{ $product->is_available ? '' : 'is-not-available' }}">
                <div class="compare-card" data-comparelist-card data-product-id="{{ $product->id }}">
                    <div class="compare-card__head">
                        <div class="compare-card__preview">
                            <a href="{{ $product->site_link }}" class="compare-card__image">
                                {!! $product->preview->imageTag('small', ['width' => 60]) !!}
                            </a>
                            <div class="compare-card__title">
                                <a href="{{ $product->site_link }}" class="link link--black" title="{{$product->name}}">{{$product->name}}</a>
                            </div>
                            <div class="compare-card__options">
                                <div class="dropdown dropdown--to-left js-init" data-toggle>
                                    <div class="dropdown__head" data-toggle-trigger>
                                        <div class="dropdown__head-svg">{!! SiteHelpers\SvgSpritemap::get('icon-options', []) !!}</div>
                                    </div>
                                    <div class="dropdown__body" data-toggle-content>
                                        <div class="grid">
                                            @if($product->is_available)
                                                <div class="gcell gcell--12 _pt-sm _pb-sm">
                                                    <button class="button button--air _color-main _fill-main" data-cart-action="add" data-product-id="{{ $product->id }}">
                                                        <span class="button__body">
                                                            {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                                                                'class' => 'button__icon button__icon--before',
                                                                'style' => 'width: 20px; height: 20px',
                                                            ]) !!}
                                                            <span class="button__text">@lang('products::site.buy')</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            @endif
                                            <div class="gcell gcell--12 _pt-sm _pb-md">
                                                <button class="button button--air {{ Wishlist::has($product->id) ? 'is-active' : null }}" data-wishlist-toggle="{{ $product->id }}">
                                                    <span class="button__body button__body">
                                                        {!! SiteHelpers\SvgSpritemap::get('icon-wishlist', [
                                                            'class' => 'button__icon button__icon--before button__icon--in-active',
                                                            'style' => 'width: 20px; height: 20px;'
                                                        ]) !!}
                                                        {!! SiteHelpers\SvgSpritemap::get('icon-to-wishlist', [
                                                            'class' => 'button__icon button__icon--before button__icon--is-active _fill-secondary',
                                                            'style' => 'width: 20px; height: 20px;'
                                                        ]) !!}
                                                        <span class="button__text button__text--in-active">@lang('products::site.wishlist')</span>
                                                        <span class="button__text button__text--is-active">@lang('products::site.in-wishlist')</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="gcell gcell--12 _pt-md _pb-sm" style="border-top: 1px solid #f2f2f2;">
                                                <button class="button button--air" data-comparelist-toggle="{{ $product->id }}">
                                                    <span class="button__body">
                                                        {!! SiteHelpers\SvgSpritemap::get('icon-close', [
                                                            'class' => 'button__icon button__icon--before',
                                                            'style' => 'width: 15px; height: 15px; margin-left: 2px; margin-right: 3px;',
                                                        ]) !!}
                                                        <span class="button__text">@lang('products::site.delete')</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid _items-center">
                            <div class="gcell">
                                <div class="compare-card__price">{{ $product->formatted_price }}</div>
                            </div>
                            @if($product->is_available)
                                <div class="gcell _pl-def">
                                    <button type="button"
                                        class="button button--theme-main button--size-small"
                                        data-cart-action="add"
                                        data-product-id="{{ $product->id }}"
                                    >
                                        <span class="button__body">
                                            {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                                                'class' => 'button__icon button__icon--before'
                                            ]) !!}
                                        </span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="compare-table__row compare-table__row--char">
        <div class="compare-table__cell compare-table__cell--first">@lang('products::site.brand')</div>
        @foreach($products as $product)
            <div class="compare-table__cell compare-table__cell--char">
                <div class="compare-card" data-comparelist-card data-product-id="{{ $product->id }}">
                    <div class="compare-card__body">
                        {!! $product->brand ? $product->brand->current->name : '&mdash;' !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @foreach($features as $key => $value)
        <div class="compare-table__row compare-table__row--char">
            <div class="compare-table__cell compare-table__cell--first">{{ $value }}</div>
            @foreach($products as $product)
                <div class="compare-table__cell compare-table__cell--char">
                    <div class="compare-card" data-comparelist-card data-product-id="{{ $product->id }}">
                        @if(isset($values->get($product->id)[$value]))
                            <div class="compare-card__body">
                                @if(!is_array($values->get($product->id)[$value]))
                                    {{ $values->get($product->id)[$value] }}
                                @else
                                    @foreach($values->get($product->id)[$value] as $item)
                                        {{ $item }}
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
