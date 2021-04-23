@php
/** @var \App\Modules\Brands\Models\Brand[]|\Illuminate\Database\Eloquent\Collection $brands */
$canCreateSlider = $brands->count() > 1;
$_config = !$canCreateSlider ? [] : [
    'type' => 'SlickBrands',
    'user-type-options' => [],
];
@endphp
<div {!! Html::attributes([
    'class' => [
        'brands-slider',
        $mod_class ?? null,
        $canCreateSlider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
    <div class="brands-slider__list slick-slider-list" data-slick-slider>
        @php
            $i = 0;
        @endphp
        @foreach($brands as $brand)
            <div class="slick-slider-list__item">
                <a {!! Html::attributes([
                        'href' => $brand->link ?? null,
                        'class' => 'brands-item',
                        'title' => $brand->current->name ?? null,
                    ]) !!}>
                    {!! $brand->imageTag('small', [
                        'class' => 'brands-item__logo',
                    ]) !!}
                    <div class="brands-item__name">{{ $brand->current->name }}</div>
                </a>
            </div>
        @endforeach
    </div>
    @if($canCreateSlider)
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
