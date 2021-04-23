@php
/** @var \App\Modules\Products\Models\ProductGroup[]|\Illuminate\Database\Eloquent\Collection $groups */
/** @var string $text */
/** @var string $link */
$canCreateSlider = $groups->isNotEmpty();
$_config = !$canCreateSlider ? [] : [
    'type' => $preset ?? 'SlickItem',
    'user-type-options' => [ ]
];
@endphp
<div class="section _mb-xl _lg-mb-xxl">
    <div class="container">
        <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
            <div class="gcell _mb-def _mr-def">
                <div class="title title--size-h2">{{ $text }}</div>
            </div>
            @if($link ?? false)
                <div class="gcell _mb-def _self-end">
                    @include('site._widgets.elements.goto.goto', [
                        'href' => $link,
                        'to' => 'next',
                        'text' => trans('products::site.see-all'),
                    ])
                </div>
            @endif
        </div>
        <div {!! Html::attributes([
            'class' => [
                'item-slider',
                $mod_class ?? null,
                $canCreateSlider ? 'js-init' : null
            ]
        ]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
            <div class="item-slider__list slick-slider-list" data-slick-slider>
                @foreach($groups as $group)
                    {!! Widget::show('products::group-card', $group, false) !!}
                @endforeach
            </div>
            @if($canCreateSlider)
                <div {!! Html::attributes([
                    'class' => [
                        'item-slider__dots',
                        'slick-slider-dots',
                        $add_dot_classes ?? null
                    ]
                ]) !!} data-slick-dots></div>
            @endif
        </div>
    </div>
</div>
