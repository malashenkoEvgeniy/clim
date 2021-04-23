@php
/** @var \App\Modules\Products\Models\ProductGroup $group */
/** @var \App\Modules\Products\Models\Product $product */
/** @var boolean $showDescription */
@endphp
<div class="item-card" data-product data-product-id="{{ $product->id }}">
    <div class="item-card__head">
        @include('products::site.widgets.item-card.item-card-preview.item-card-preview', [
            'link' => $product->site_link,
            'image' => $product->preview,
        ])
        @if($product->labels && $product->labels->isNotEmpty())
            <div class="item-card__badges">
                @foreach($product->labels as $label)
                    @include('products::site.widgets.item-badge.item-badge', [
                        'label' => $label,
                    ])
                @endforeach
            </div>
        @endif
    </div>
    <div class="item-card__body">
        @include('products::site.widgets.item-card.item-card-title.item-card-title', [
            'product' => $product,
            'group' => $group,
            'brand' => config('db.products.show-brand-in-item-card', true) ? $product->brand : null,
        ])
    </div>
    @if($showDescription === true)
        {!! Widget::show('products::description', $product) !!}
    @endif
    <div class="item-card__foot">
        {!! Widget::show('products::price', $product) !!}
        {!! Widget::show('products::controls', $product) !!}
    </div>
</div>
