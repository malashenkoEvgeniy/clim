@php
    // TODO заменить
    $list = [
        config('mock.brands')[0],
        config('mock.brands')[1],
        config('mock.brands')[2],
        config('mock.brands')[3],
        config('mock.brands')[4],
        config('mock.brands')[5],
    ];
    // #end

    $_create_slider = count($list) > 1;
    $_config = !$_create_slider ? [] : [
        'type' => 'SlickBrands',
        'user-type-options' => []
    ];
@endphp
<div {!! Html::attributes([
    'class' => [
        'brands-slider',
        $mod_class ?? null,
        $_create_slider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
    <div class="brands-slider__list slick-slider-list" data-slick-slider>
        @foreach($list as $item)
            <div class="slick-slider-list__item">
                <a {!! Html::attributes([
                    'href' => $item->link ?? null,
                    'class' => 'brands-item',
                    'title' => $item->desc ?? null
                ]) !!}>
                    <img class="brands-item__logo"
                            src="{{ site_media('temp/brands/' . $item->logo) }}"
                            alt="{{ $item->desc ?? null }}">
                </a>
            </div>
        @endforeach
    </div>
    @if($_create_slider)
        <div class="brands-slider__arrows">
            <div class="slick-slider-arrow slick-slider-arrow--prev" data-slick-arrow-prev>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin') !!}
            </div>
            <div class="slick-slider-arrow slick-slider-arrow--next" data-slick-arrow-next>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin') !!}
            </div>
        </div>
        <div class="brands-slider__dots slick-slider-dots" data-slick-dots></div>
    @endif
</div>
