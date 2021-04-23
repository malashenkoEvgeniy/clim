@php
    /** @var int $limit */
    /** @var int $total */
    /** @var string $query */
    /** @var \App\Modules\Products\Models\Product[] $products */
@endphp

<div class="suggestions">
    <div class="suggestions__body">
        @if($total > 0)
            <div class="suggestions__section">
                <div class="suggestions__list">
                    @foreach($products as $product)
                        <a class="suggestions__item" href="{{ $product->site_link }}">
                            <div class="grid _flex-nowrap">
                                <div class="gcell gcell--auto _flex-noshrink _pr-def">
                                    <div class="suggestions__item-aside">
                                        <div class="suggestions__item-image">
                                            {!! Widget::show('image', $product->preview, 'small') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--auto _flex-grow">
                                    <div class="suggestions__item-main">
                                        <div class="suggestions__item-title">{{ $product->name }}</div>
                                        <div class="suggestions__item-entry">{{ $product->teaser }}</div>
                                        <div class="suggestions__item-price">{{ $product->formatted_price }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="suggestions__section">
                <div class="suggestions__title _text-center">Результатов не найдено</div>
            </div>
        @endif
    </div>
    @if($total > $limit)
        <div class="suggestions__footer">
            <a href="{{ route('site.search-products') . "?query=$query" }}" class="suggestions__all-results-link">Все результаты... ({{ $total }})</a>
        </div>
    @endif
</div>
