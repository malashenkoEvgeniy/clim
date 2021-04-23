@php
/** @var \App\Modules\Products\Models\Product[][] $products */
/** @var \App\Modules\Categories\Models\Category[] $categories */
@endphp
@foreach($categories as $category)
    <div class="_mb-lg" data-comparelist-group>
        <div class="box">
            <div class="grid _items-center _nml-md">
                <div class="gcell _pl-md">
                    <div class="title title--size-h3">{{ $category->current->name }}</div>
                </div>
                @if (count(array_get($products, $category->id, [])) > 1)
                    <div class="gcell _pl-md" data-comparelist-link>
                        <a href="{{ route($routeName, $category->current->slug) }}" class="button button--size-small button--theme-main">
                            <div class="button__body">
                                <div class="button__text">@lang('products::site.compare')</div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="grid grid--1 grid--xs-2 grid--md-3 grid--lg-4 _nmt-xxs _nml-xxs">
            @foreach(array_get($products, $category->id) as $product)
                <div class="gcell _pt-xxs _pl-xxs">
                    {!! Widget::show('products::compare-card', $product) !!}
                </div>
            @endforeach
        </div>
    </div>
@endforeach
