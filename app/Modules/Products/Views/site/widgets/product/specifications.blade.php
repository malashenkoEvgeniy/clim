@php
/** @var array $features */
/** @var \App\Modules\Products\Models\Product $product */
@endphp
<div class="title title--size-h3">@lang('products::site.main-specifications') {{ $product->name }}</div>
<div class="zebra zebra--odd zebra--light">
    @foreach($features as $featureName => $values)
        <div class="zebra__line _ptb-md _plr-def _nmlr-def _ms-mlr-none">
            <div class="grid grid--1 _nml-md">
                <div class="gcell gcell--ms-5 gcell--md-4 _pl-md">
                    <strong class="text text--size-13 _color-black">{{ $featureName }}:</strong>
                </div>
                <div class="gcell gcell--ms-7 gcell--md-8 _pl-md">
                    <span class="text text--size-13 _color-gray6">{!! $values !!}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
