@php
/** @var \App\Modules\Products\Models\ProductGroup $group */
/** @var \App\Modules\Products\Models\Product $product */
/** @var boolean $showDescription */
@endphp
<div class="item-card" data-product data-product-id="{{ $product->id }}">
    <div class="item-card__head">
        @include('products::site.widgets.item-card.item-card-preview.item-card-preview', [
            'link' => $product->site_link,
            'image' => $group->preview,
        ])
        @if($group->labels && $group->labels->isNotEmpty())
            <div class="item-card__badges">
                @foreach($group->labels as $label)
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
            'brand' => config('db.products.show-brand-in-item-card', true) ? $group->brand : null,
            'showGroupName' => true,
        ])
    </div>
    @if($group->filtered_products->count() > 1)
        <div class="packages grid _nm-xxs">
            @foreach($group->filtered_products as $modification)
                <div class="gcell _p-xxs">
                    <a href="{{ $modification->site_link }}" class="packages__link packages__link--small{{ $modification->id === $product->id ? ' is-active' : null }}">
                        @if($modification->value_id)
                            {{ $modification->value->current->name }}
                        @else
                            {{ $modification->name }}
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    @endif
    @if($showDescription === true)
        {!! Widget::show('products::group-description', $group) !!}
    @endif
    <div class="item-card__foot">
        {!! Widget::show('products::price', $product) !!}
        {!! Widget::show('products::controls', $product) !!}
    </div>
</div>
