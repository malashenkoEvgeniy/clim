@php
/** @var \App\Modules\Brands\Models\Brand[] $brands */
@endphp
<div class="section _mb-lg">
    <div class="container">
        <div class="_mt-lg _def-mt-xxl _pb-xl _text-center">
            <div class="title title--size-h2">@lang('brands::site.our-brands')</div>
        </div>
        @include('brands::site.brands-slider.brands-slider', [
            'mod_class' => 'reviews-slider--theme-light',
            'brands' => $brands,
        ])
    </div>
</div>