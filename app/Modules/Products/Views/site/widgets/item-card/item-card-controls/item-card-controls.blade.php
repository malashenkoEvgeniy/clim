@php
/** @var \App\Modules\Products\Models\Product $product */
@endphp
<div class="grid _flex-nowrap _nml-xs">
    <div class="gcell _pl-xs _flex-grow">
        @if($product->is_available)
            {!! Widget::show('orders::cart::add-button', $product->id, $product->is_available) !!}
        @else
            {!! Widget::show('products-availability::button', $product->id) !!}
        @endif
    </div>
    <div class="gcell _pl-xs _flex-noshrink">
        {!! Widget::show('compare::button', $product->id) !!}
    </div>
    <div class="gcell _pl-xs _flex-noshrink">
        {!! Widget::show('wishlist::product-button', $product->id) !!}
    </div>
</div>
