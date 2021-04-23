@php
/** @var \App\Modules\SlideshowSimple\Models\SlideshowSimple[]|\Illuminate\Database\Eloquent\Collection $slides */
$canCreateSlider = $slides->count() > 1;
$_config = $canCreateSlider ? [
    'type' => 'SlickActionBar',
    'user-type-options' => [
        'autoplay' => (bool)config('db.slideshow_simple.autoplay'),
        'autoplaySpeed' => (int)config('db.slideshow_simple.timing'),
        'fade' => (bool)config('db.slideshow_simple.effect'),
    ],
] : [];
@endphp
<div class="action-bar-holder">
    <div {!! Html::attributes([
        'class' => [
            'action-bar-slider',
            $mod_class ?? null,
            $canCreateSlider ? 'js-init' : null
        ]
    ]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
        <div class="action-bar-slider__list slick-slider-list" data-slick-slider>
            @foreach($slides as $slide)
                @include('slideshow_simple::site.action-bar-slider.action-bar-slide.action-bar-slide', [
                    'slide' => $slide,
                ])
            @endforeach
        </div>
        @if($canCreateSlider)
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
