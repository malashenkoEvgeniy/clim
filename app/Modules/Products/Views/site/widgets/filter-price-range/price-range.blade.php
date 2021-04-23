<hr class="separator _color-gray2 _mtb-md _hide-last">
@component('products::site.widgets.filter-accordion.accordion-block', [
    'ns' => 'filter',
    'id' => 2,
    'header' => __('products::site.filter.price-filter'),
    'open' => true,
])
    <div class="js-init" data-ion-range='{!! json_encode([
        'preset' => 'double',
        'elements' => [
            '$slider' => '[data-ion-range-slider]',
            '$minInput' => '[data-ion-min-value]',
            '$maxInput' => '[data-ion-max-value]',
            '$pricesInput' => '[data-ion-prices]',
        ],
        'options' => [
            'min' => $min,
            'max' => $max,
            'from' => $priceMin,
            'to' => $priceMax,
            'step' => '1',
            'hide_min_max' => 'true',
	        'hide_from_to' => 'true'
        ],
    ]) !!}'>
        <form class="grid _nml-sm">
            @foreach(request()->query as $key => $value)
                @if($key === 'price')
                    @continue
                @endif
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="hidden" name="price" value="{{ $priceMin . '-' . $priceMax }}" data-ion-prices>
            <div class="gcell gcell--4-of-5 _pl-sm">
                <div class="grid _nml-sm">
                    <div class="gcell gcell--6 _pl-sm">
                        <div class="range-input">
                            <input type="text"
                                   class="range-input__value"
                                   size="1"
                                   value="{{ $priceMin }}"
                                   data-min="{{ $min }}"
                                   data-ion-min-value>
                            <div class="range-input__label">@lang('products::site.filter.from')</div>
                        </div>
                    </div>
                    <div class="gcell gcell--6 _pl-sm">
                        <div class="range-input">
                            <input type="text"
                                   class="range-input__value"
                                   size="1"
                                   value="{{ $priceMax }}"
                                   data-max="{{ $max }}"
                                   data-ion-max-value>
                            <div class="range-input__label">@lang('products::site.filter.to')</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--1-of-5 _pl-sm _flex-noshrink">
                <button type="submit" class="range-button">@lang('products::site.filter.OK')</button>
            </div>
            <div class="gcell gcell--12 _pl-sm _pr-xs">
                <input type="hidden" data-ion-range-slider>
            </div>
        </form>
    </div>
@endcomponent
