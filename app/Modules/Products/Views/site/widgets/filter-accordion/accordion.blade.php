@php
$params = ProductsFilter::getParameters();
$parameters = Route::current()->parameters();
unset($parameters['pageQuery']);
$link = route(Route::currentRouteName(), $parameters);
@endphp

@component('products::site.widgets.accordion.accordion', [
    'options' => [
        'type' => 'multiple',
    ],
])
    @foreach(ProductsFilter::getBlocks() as $index => $block)
        @if($block->showInFilter())
            @include('products::site.widgets.filter-block.block', ['block' => $block])
        @endif
        @if($index === 0)
            {!! Widget::show('products::filter-price', $minPrice, $maxPrice) !!}
        @endif
    @endforeach
@endcomponent

@if($params && $params->isNotEmpty())
    <hr class="separator _color-gray2 _mtb-md">
    <a href="{{ $link }}" class="button button--theme-reset button--size-small">
        <div class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-close-rounded-sm', [
                'class' => 'button__icon button__icon--before'
            ]) !!}
            <div class="button__text">@lang('products::site.filter-reset')</div>
        </div>
    </a>
@endif
