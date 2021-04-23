@php
/** @var array $productsIds */
@endphp
<div class="section _mb-xl _lg-mb-xxl">
    <div class="container">
        <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
            <div class="gcell _mb-def _mr-def">
                <div class="title title--size-h2">@lang('viewed::general.widget-name')</div>
            </div>
        </div>
        {!! Widget::show('products-slider', $productsIds) !!}
    </div>
</div>
