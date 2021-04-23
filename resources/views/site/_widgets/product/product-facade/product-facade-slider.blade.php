@php
    $_create_slider = count($images) > 1;
    $_config = !$_create_slider ? [] : [
        'type' => 'SlickProduct',
        'user-type-options' => []
    ];
    $_config_thumbs = !$_create_slider ? [] : [
        'type' => 'SlickProductThumbs',
        'user-type-options' => [
            'asNavFor' => '[data-slick-slider="product"]'
        ]
    ];
@endphp

<div {!! Html::attributes([
    'class' => [
        'product-slider',
        $mod_class ?? null,
        $_create_slider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
    <div class="product-slider__list slick-slider-list" data-slick-slider="product">
        @foreach($images as $i => $image)
            <div class="slick-slider-list__item">
                <div class="product-slide">
                    <img class="product-slide__img" alt
                            width="640" height="440"
                            {!! Html::attributes([
                                'src' => $i ? site_media('/temp/product/thumbs/' . $image) : site_media('/temp/product/preview/' . $image),
                                'data-lazy' => $i ? site_media('/temp/product/preview/' . $image) : null
                            ]) !!}>
                </div>
            </div>
        @endforeach
    </div>
    @if($_create_slider)
        <div class="product-thumbs-slider__dots slick-slider-dots" data-slick-dots></div>
    @endif
</div>

@if(browserizr()->isDesktop())
    <div {!! Html::attributes([
    'class' => [
        'product-thumbs-slider',
        $mod_class ?? null,
        $_create_slider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config_thumbs) !!}'>
        <div class="product-thumbs-slider__list slick-slider-list" data-slick-slider="product-thumbs">
            @foreach($images as $image)
                <div class="slick-slider-list__item">
                    <div class="product-thumbs-slide">
                        <img class="product-thumbs-slide__img" alt
                                width="87" height="60"
                                src="{{ site_media('/temp/product/thumbs/' . $image) }}">
                    </div>
                </div>
            @endforeach
        </div>
        @if($_create_slider)
            <div class="product-thumbs-slider__arrows">
                <div class="slick-slider-arrow slick-slider-arrow--prev" data-slick-arrow-prev>
                    {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin') !!}
                </div>
                <div class="slick-slider-arrow slick-slider-arrow--next" data-slick-arrow-next>
                    {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin') !!}
                </div>
            </div>
            <div class="product-thumbs-slider__dots slick-slider-dots" data-slick-dots></div>
        @endif
    </div>
@endif

