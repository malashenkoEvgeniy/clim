@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var \App\Modules\Products\Models\ProductGroup $group */
/** @var \App\Modules\Brands\Models\Brand|null $brand */
$showGroupName = $showGroupName ?? false;
@endphp
<div class="item-card-title">
    <div class="_mb-xs">
        @if($group->comments && $group->comments->isNotEmpty())
            <div class="grid _items-center">
                <div class="gcell">
                    @include('site._widgets.stars-block.stars-block', [
                        'count' => $group->mark,
                        'mod' => 'small',
                    ])
                </div>
                <div class="gcell _pl-xs">
                    <a href="{{ $product->site_link }}#review" class="link link--main text--size-12">
                        {!! trans_choice('products::site.products-review', $group->comments->count()) !!}
                    </a>
                </div>
            </div>
        @else
            <a href="{{ $product->site_link }}#review" class="link link--main text--size-12">
                @lang('products::site.products-review-write')
            </a>
        @endif
    </div>
    @if($brand)
        <div class="_mb-xs">{{ $brand->current->name }}</div>
    @endif
    <a href="{{ $product->site_link }}" class="item-card-title__text text--size-12">
        {{ $showGroupName ? $group->name : $product->name }}
    </a>
</div>
