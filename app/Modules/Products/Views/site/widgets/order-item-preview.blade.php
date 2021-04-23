@php
/** @var \App\Modules\Products\Models\Product $product */
@endphp

@if($product->preview && $product->preview->isImageExists())
    <div class="gcell gcell--auto _plr-xxs">
        {!! $product->preview->imageTag('small', ['class' => 'order-item__product-preview']) !!}
    </div>
@endif
