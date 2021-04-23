@php
/** @var string $orderBy */
/** @var string $perPage */
@endphp

<div class="gcell _mtb-xxs">
    @foreach(URL::getRequest()->query() as $queryName => $queryValue)
        @if(!in_array($queryName, ['order', 'per-page']))
            <input type="hidden" name="{{ $queryName }}" value="{{ $queryValue }}">
        @endif
    @endforeach
    <div class="inline-control">
        <label for="#sort-control" class="inline-control__label">
            Сортировать:
        </label>
        <div class="inline-control__element">
            <select id="sort-control" name="order" class="select js-sort-control">
                @foreach(config('products.available-order-fields', []) as $key => $value)
                    <option value="{{ $key }}" {{ $key == $orderBy ? 'selected' : null }}>@lang($value)</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="gcell _mtb-xxs">
    <div class="inline-control">
        <label for="#view-control" class="inline-control__label">
            Товаров на странице:
        </label>
        <div class="inline-control__element">
            <select id="view-control" name="per-page" class="select js-sort-control">
                @for($i = 1; $i <= 4; $i++)
                    @php($limit = config('db.products.site-per-page', 10) * $i)
                    <option value="{{ $limit }}" {{ $limit == $perPage ? 'selected' : null }}>
                        {{ $limit }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
</div>
