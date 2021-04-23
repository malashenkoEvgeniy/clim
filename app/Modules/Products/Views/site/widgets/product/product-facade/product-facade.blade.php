@php
    /** @var \App\Modules\Products\Models\Product $product */
@endphp
<div class="grid _nmlr-def">
    <div class="gcell gcell--12 gcell--ms-6 _plr-def">
        <div class="_posr">
            @if($product->labels && $product->labels->isNotEmpty())
                <div class="product-badges">
                    @foreach($product->labels as $label)
                        @include('products::site.widgets.item-badge.item-badge', [
                            'label' => $label,
                        ])
                    @endforeach
                </div>
            @endif
            @include('products::site.widgets.product.product-facade.product-facade-slider', [
                'images' => $product->gallery(),
                'product' => $product,
            ])
        </div>
        <div class="text--size-15 _pt-def _ms-show">
            {!! Widget::show('products::description', $product) !!}
        </div>
        <div class="text--size-15 _pt-def _ms-show">
            {!! Widget::show('products::tab-desc-features', $product) !!}
        </div>
        <div class="text--size-15 _pt-def _ms-show">
            {!! Widget::show('products::tab-description', $product) !!}
        </div>
    </div>
    <div class="gcell gcell--12 gcell--ms-6 _plr-def _separator-left" data-product>
        <div class="grid _justify-between _separator-bottom _mb-md">
            <div class="gcell _pr-sm">
                @if($product->group->products->count() > 1)
                    <div class="packages grid _nm-xs _pb-def">
                        @foreach($product->group->sorted_products as $modification)
                            <div class="gcell _p-xs">
                                <div class="packages__item">
                                    <a href="{{ $modification->site_link }}" class="packages__link packages__link--big{{ $modification->id === $product->id ? ' is-active' : null }}">
                                        @if($modification->value_id)
                                            {{ $modification->value->current->name }}
                                        @else
                                            {{ $modification->name }}
                                        @endif
                                    </a>
                                    @if ($modification->id !== $product->id)
                                        <div class="packages__dropdown">
                                            @include('products::site.widgets.product.item-availability.item-availability', [
                                                'available' => $modification->available,
                                                'text' => __(config('products.availability.' . $modification->available)),
                                            ])
                                            <div class="product-price">
                                                <div class="product-price__old">{{ $modification->formatted_old_price ?? '' }}</div>
                                                <div class="product-price__current">
                                                    @if($modification->formatted_price > 0)
                                                        {{ $modification->formatted_price }}
                                                    @else
                                                        @lang('products::site.price-request')
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="product-inform">
                    @include('products::site.widgets.product.item-availability.item-availability', [
                    'available' => $product->available,
                    'text' => __(config('products.availability.' . $product->available)),
                ])
                    {!! Widget::show('products::price', $product) !!}
                </div>
            </div>
            <div class="gcell">
                @if($product->vendor_code)
                    @include('site._widgets.elements.vendor-code.vendor-code', [
                        'code' => $product->vendor_code,
                    ])
                @endif
            </div>
        </div>
        {!!  Widget::show('products_dictionary::show-in-product', $product->id)  !!}
        <div class="product-sticky">
            <div class="grid _items-center _justify-center _def-justify-start _mb-def _nml-sm">
                <div class="gcell _pl-sm">
                    {!! Widget::show('products::controls', $product, true) !!}
                </div>
                <div class="gcell _pl-sm">
                    @if($product->is_available)
                        {!! Widget::show('fast-orders::button', $product->id) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="_pb-md _text-right">
            @if(config('db.products.sizes_text'))
                <div class="conditions-item__link js-init" data-mfp="ajax" data-mfp-src="{{ route('site.product.info-popup', 'sizes') }}">
                    @lang('products::site.sizes')
                </div>
            @endif
        </div>

        {!! Widget::show('products-services::product-page') !!}
    </div>
</div>
