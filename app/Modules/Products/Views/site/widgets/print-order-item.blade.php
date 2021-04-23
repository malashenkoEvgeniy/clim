@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var string $formattedPrice */
/** @var string $formattedAmount */
/** @var int $quantity */
$productName = $product ? ($product->name ?? '&mdash;') : trans('products::site.deleted');
@endphp
<div class="grid _justify-center _nm-md">
    <div class="gcell _p-md">
        {!! Widget::show('image', $product->preview, 'small', ['width' => 80]) !!}
    </div>
    <div class="gcell _flex-grow _p-md">
        <div class="_mb-def">{!! $productName !!}</div>
        <div class="grid _justify-between _nm-md">
            <div class="gcell gcell--3 _p-md">
                <div class="text text--size-13 _color-gray-4 _mb-xs">@lang('orders::site.artikul'):</div>
                <div class="_color-black"><b>{!! $product ? $product->vendor_code : '&mdash;' !!}</b></div>
            </div>
            <div class="gcell gcell--3 _p-md _text-center">
                <div class="text text--size-13 _color-gray-4 _mb-xs">@lang('orders::site.quantity'):</div>
                <div class="_color-black"><b>{{ $quantity }}</b></div>
            </div>
            <div class="gcell gcell--3 _p-md _text-center">
                <div class="text text--size-13 _color-gray-4 _mb-xs">@lang('orders::site.price'):</div>
                <div class="_color-black"><b>{{ $formattedPrice}}</b></div>
            </div>
            <div class="gcell gcell--3 _p-md _text-right">
                <div class="text text--size-13 _color-gray-4 _mb-xs">@lang('orders::site.price-total'):</div>
                <div class="_color-black"><b>{{ $formattedAmount }}</b></div>
            </div>
        </div>
    </div>
</div>
