@php
/** @var \Illuminate\Support\Collection $tabs */
@endphp
<!--this_is_product-->
<div class="js-init" data-product-tabs>
    <div class="tabs-nav">
        @foreach($tabs as $index => $tab)
            @if($tab['widget'])
                <div class="tabs-nav__button{{ $index === 'main' ? ' is-active' : '' }}"
                        data-wstabs-ns="product"
                        data-wstabs-button="{{ $index }}">
                    <span>{{ $tab['name'] }}
                        @if(isset($tab['count']) && (int)$tab['count'] > 0)
                            <sup class="_color-gray5">{{ $tab['count'] }}</sup>
                        @endif
                    </span>
                </div>
            @endif
        @endforeach
    </div>
    <div class="tabs-blocks _mb-xl">
        @foreach($tabs as $index => $tab)
            @if($tab['widget'])
                <div class="tabs-blocks__block{{ $index === 'main' ? ' is-active' : ' product-aside--show' }}"
                        data-wstabs-ns="product"
                        data-wstabs-block="{{ $index }}">
                        <!--dg_check_product_tab:{{ $index }}:start-->
                    {!! $tab['widget'] !!}
                        <!--dg_check_product_tab:{{ $index }}:end-->
                </div>
            @endif
        @endforeach
        @include('products::site.widgets.product.product-aside.product-aside', ['product' => $product])
    </div>
</div>
