@php
/** @var \App\Modules\Products\Models\ProductGroup[] $groups */
$classes = 'grid--2 grid--xs-3 grid--md-4 grid--def-3 grid--xl-4';
if (isset($full_width) && $full_width) {
    $classes = 'grid--2 grid--xs-3 grid--md-4 grid--xl-5';
}
@endphp
<div class="item-list">
    <div class="grid {{ $classes }}">
        @foreach($products as $product)
            <div class="gcell">
                {!! Widget::show('products::card', $product) !!}
            </div>
        @endforeach
    </div>
</div>
