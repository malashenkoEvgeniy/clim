@php
/** @var \App\Components\Filter\FilterElement[] $elements */
/** @var array|null $price */
$parameters = Route::current()->parameters();
unset($parameters['pageQuery']);
$link = route(Route::currentRouteName(), $parameters);
@endphp
<div>
    <div class="_flex _flex-wrap _mt-md _nmb-sm">
        @if($price)
            <a href="{{ array_get($price, 'link') }}" class="filter-param">
                <div class="filter-param__value">{{ array_get($price, 'name') }}</div>
                <div class="filter-param__clear">&times;</div>
            </a>
        @endif
        @foreach($elements as $element)
            <a href="{{ $element->link() }}" class="filter-param">
                <div class="filter-param__value">{{ $element->name }}</div>
                <div class="filter-param__clear">&times;</div>
            </a>
        @endforeach
        <a href="{{ $link }}" class="filter-param">
            {!! SiteHelpers\SvgSpritemap::get('icon-close-rounded-sm', [
                'class' => 'filter-param__icon'
            ]) !!}
            <div class="filter-param__value">@lang('products::site.filter-reset')</div>
        </a>
    </div>
</div>
