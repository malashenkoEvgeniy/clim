@php
/** @var \App\Modules\Products\Models\Product $product */
@endphp
<div class="grid _flex-nowrap _justify-center _def-justify-start _nml-sm">
    <div class="gcell _pl-sm">
        {!! Widget::show('orders::cart::add-button', $product->id, $product->is_available, true) !!}
    </div>
    <div class="gcell _pl-sm">
        <div class="grid _flex-nowrap _justify-end _nml-sm">
            <div class="gcell _pl-sm">
                {!! Widget::show('compare::button', $product->id) !!}
            </div>
            <div class="gcell _pl-sm">
                {!! Widget::show('wishlist::product-button', $product->id) !!}
            </div>
        </div>
    </div>
</div>
