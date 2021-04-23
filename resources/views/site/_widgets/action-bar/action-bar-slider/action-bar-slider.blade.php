@php
    // TODO заменить
    $list = [[], [], [], [], []];
    // #end

    $_create_slider = count($list) > 1;
    $_config = !$_create_slider ? [] : [
        'type' => 'SlickActionBar',
        'user-type-options' => [
            'autoplay' => 0
        ]
    ];
@endphp
<div class="action-bar-holder">
    <div {!! Html::attributes([
        'class' => [
            'action-bar-slider',
            $mod_class ?? null,
            $_create_slider ? 'js-init' : null
        ]
    ]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
        <div class="action-bar-slider__list slick-slider-list" data-slick-slider>
            @foreach($list as $i => $item)
                <div class="slick-slider-list__item">
                    @include('site._widgets.action-bar.action-bar-slider.action-bar-slide.action-bar-slide', [
                        'bg' => 'temp/action-bar-slider/slider-bg.jpg',
                        'image' => 'temp/action-bar-slider/slide-01.png',
                        'lines' => ['Новая', 'линейка', 'шампуней'],
                        'href' => 'temp/action-bar-slider/slider-bg.jpg',
                    ])
                </div>
            @endforeach
        </div>
        @if($_create_slider)
            <div class="action-bar-slider__nav">
                <div class="_flex _justify-center">
                    <div class="_flex-noshrink">
                        <div class="slick-slider-arrow slick-slider-arrow--prev" data-slick-arrow-prev>
                            {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin') !!}
                        </div>
                    </div>
                    <div class="_plr-def">
                        <div class="action-bar-slider__dots" data-slick-dots></div>
                    </div>
                    <div class="_flex-noshrink">
                        <div class="slick-slider-arrow slick-slider-arrow--next" data-slick-arrow-next>
                            {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin') !!}
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
