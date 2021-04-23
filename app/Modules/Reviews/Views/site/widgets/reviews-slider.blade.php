@php
/** @var \App\Modules\Reviews\Models\Review[]|\Illuminate\Database\Eloquent\Collection $reviews */
$canCreateSlider = $reviews->count() > 1;
$_config = !$canCreateSlider ? [] : [
    'type' => 'SlickReviews',
    'user-type-options' => []
];
@endphp
<div {!! Html::attributes([
    'class' => [
        'reviews-slider',
        $mod_class ?? null,
        $canCreateSlider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
    <div class="reviews-slider__list slick-slider-list" data-slick-slider>
        @foreach($reviews as $review)
            <div class="slick-slider-list__item">
                @component('reviews::site.widgets.reviews-item', [
                    'mod_class' => 'reviews-item--theme-light reviews-item--align-center',
                    'mod_message_class' => 'reviews-item-message--big',
                    'user_name' => $review->name,
                ])
                    {!! $review->comment !!}
                @endcomponent
            </div>
        @endforeach
    </div>
    @if($canCreateSlider)
        <div class="reviews-slider__arrows">
            <div class="slick-slider-arrow slick-slider-arrow--prev" data-slick-arrow-prev>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin') !!}
            </div>
            <div class="slick-slider-arrow slick-slider-arrow--next" data-slick-arrow-next>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin') !!}
            </div>
        </div>
        <div class="reviews-slider__dots slick-slider-dots" data-slick-dots></div>
    @endif
</div>
<div class="_text-center">
    @include('site._widgets.elements.goto.goto', [
        'mod_class' => '_color-white',
        'href' => route('site.reviews'),
        'to' => 'next',
        'text' => __('reviews::site.all-reviews'),
    ])
</div>
