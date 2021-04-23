@php
    $_create_slider = count($list) > 1;
    $_config = !$_create_slider ? [] : [
        'type' => 'SlickFeatures',
        'user-type-options' => [
            'responsive' => [
                [
                    'breakpoint' => 1024,
                    'settings' => [
                        'slidesToShow' => $slides_to_show ?? 4
                    ]
                ]
            ]
        ]
    ];
@endphp
<div {!! Html::attributes([
    'class' => [
        'feature-slider',
        $mod_class ?? null,
        $_create_slider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
    <div {!! Html::attributes([
        'class' => [
            'feature-slider__list',
            'feature-slider__list--slides-' . $slides_to_show ?? 4,
            isset($split) ? 'feature-slider__list--split' : null,
            'slick-slider-list',
        ]
    ]) !!} data-slick-slider>
        @foreach($list as $feature)
            @include('site._widgets.feature.feature', [
                'mod_class' => isset($split) ? 'feature--shadow' : null,
                'icon' => $feature->icon,
                'name' => $feature->name,
                'desc' => $feature->desc,
            ])
        @endforeach
    </div>
    @if($_create_slider)
        {{-- <div class="feature-slider__arrows">
            <div class="slick-slider-arrow slick-slider-arrow--prev" data-slick-arrow-prev>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin') !!}
            </div>
            <div class="slick-slider-arrow slick-slider-arrow--next" data-slick-arrow-next>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin') !!}
            </div>
        </div> --}}
        <div class="feature-slider__dots slick-slider-dots" data-slick-dots></div>
    @endif
</div>
