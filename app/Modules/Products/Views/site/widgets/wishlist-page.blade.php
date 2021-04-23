@php
/** @var \App\Modules\Products\Models\Product[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator $products */
/** @var int $total */
@endphp
<div class="grid">
    @foreach($products as $product)
        @php($zIndex = $total - $loop->index)
        <div class="gcell gcell--12" style="position: relative; z-index: {{ $zIndex }}; border-bottom: 1px solid #f2f2f2;">
            @include('wishlist::site.wishlist-card', [
                'product' => $product,
            ])
        </div>
    @endforeach
</div>
@if($products->hasPages())
    <div class="grid _items-center _justify-between _p-lg">
        <div class="gcell gcell--auto _ml-auto">
            {!! $products->links('pagination.arrows') !!}
        </div>
    </div>
@endif