<div class="product-aside _separator-left _p-def _def-show">
    <div class="product-aside__sticky">
        <div class="item-offer _separator-bottom _pb-def _mb-def">
            <div class="item-offer__media item-offer__media--big">
                {!! $product->preview->imageTag('small', ['class' => 'item-card-preview__image', 'width' => 60, 'height' => 40]) !!}
            </div>
            <span class="item-offer__name item-offer__name--big">{{ $product->name }}</span>
        </div>
        @include('products::site.widgets.product.item-availability.item-availability', [
            'available' => $product->available,
            'text' => __(config('products.availability')[$product->available]),
        ])
        <div class="_separator-bottom _mb-md">
            @include('products::site.widgets.product.item-card-price.item-card-price', [
                'old_value' => $product->formatted_old_price,
                'value' => $product->formatted_price,
            ])
        </div>
        @include('products::site.widgets.product.item-card-controls.item-card-controls', [
            'product' => $product,
        ])
        {!!  Widget::show('fast-order',$product->id)  !!}
    </div>
</div>
