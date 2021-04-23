@php
/** @var \App\Modules\Products\Models\ProductGroup[]|\Illuminate\Database\Eloquent\Collection $groups */
/** @var string $additionalClasses */
$canCreateSlider = $groups->isNotEmpty();
$_config = !$canCreateSlider ? [] : [
    'type' => $preset ?? 'SlickItem',
    'user-type-options' => [ ]
];
@endphp
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
