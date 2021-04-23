<div class="order-product">
    <div class="grid _justify-between _items-center _ms-flex-nowrap _nm-sm">
        <div class="gcell gcell--auto order-product__cell _flex-noshrink _p-sm">
            <a class="order-product__link" href="#product-link">
                <img class="order-product__image" src="{{ $data->image }}" alt="{{ $data->name }}">
            </a>
        </div>
        <div class="gcell gcell--auto order-product__cell _flex-grow _p-sm _mr-auto">
            <a class="order-product__link" href="#product-link">
                <div class="order-product__name">{{ $data->name }}</div>
            </a>
        </div>
        <div class="gcell gcell--auto order-product__cell _flex-noshrink _ptb-sm">
            <div class="order-product__qty">{{ $data->count }} &times; <strong>111111111111{{ number_format($data->cost, 2, '.', ' ') }} грн</strong></div>
        </div>
        <div class="gcell gcell--auto order-product__cell _flex-noshrink _p-sm">
            <div class="order-product__cost"><strong>{{ number_format($data->count * $data->cost, 2, '.', ' ') }} грн</strong></div>
        </div>
    </div>
</div>
