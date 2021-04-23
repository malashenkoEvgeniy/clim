<div class="tabs-nav">
    @foreach($nav as $index => $item)
    	<div class="tabs-nav__button{{ $index === 0 ? ' is-active' : '' }}"
                data-wstabs-ns="{{ $ns }}"
                data-wstabs-button="{{ $index }}">
            <span>{{ $item->name }}</span>
        </div>
    @endforeach
</div>

<div class="tabs-blocks _mb-xl">
    @foreach($nav as $index => $item)
        <div class="tabs-blocks__block{{ $index === 0 ? ' is-active' : ' product-aside--show' }}"
                data-wstabs-ns="{{ $ns }}"
                data-wstabs-block="{{ $index }}">
            @if($item->template)
                @include($item->template, [
                    'product' => $product
                ])
            @endif
        </div>
    @endforeach
    @include('site._widgets.product.product-aside.product-aside')
</div>
