@php
/** @var \App\Modules\Products\Models\ProductGroup[] $groups */
$classes = 'grid--2 grid--xs-3 grid--md-4 grid--def-3 grid--xl-4';
if (isset($full_width) && $full_width) {
    $classes = 'grid--2 grid--xs-3 grid--md-4 grid--xl-5';
}
@endphp
<div class="item-list">
	<!--isset_listing_page-->
    <div class="grid {{ $classes }}">
        @foreach($groups as $group)
            <div class="gcell">
            	<!--product_in_listingEX-->
                {!! Widget::show('products::group-card', $group) !!}
            </div>
        @endforeach
    </div>
</div>
