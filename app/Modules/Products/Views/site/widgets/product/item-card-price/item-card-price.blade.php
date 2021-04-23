<div class="product-price">
    <div class="product-price__old">{{ $old_value ?? '' }}</div>
    <div class="product-price__current">
        @if($value > 0)
            {{ $value }}
        @else
            @lang('products::site.price-request')
        @endif
    </div>
</div>
