@php
/** @var \App\Core\Modules\Images\Models\Image[]|\Illuminate\Database\Eloquent\Collection|null $images */
/** @var \App\Modules\Products\Models\Product $product */

$existedImages = new \Illuminate\Support\Collection();
if ($images && $images->isNotEmpty()) {
    $images->each(function (\App\Core\Modules\Images\Models\Image $image) use ($existedImages) {
        if ($image->isImageExists()) {
            $existedImages->push($image);
        }
    });
}

$canCreateSlider = $existedImages->isNotEmpty();
$_config = $canCreateSlider ? [
    'type' => 'SlickProduct',
    'user-type-options' => [],
] : [];
$_configProduct = [
    'id' => $product->id,
    'price' => $product->formatted_price,
    'name' => $product->name,
];
$_config_thumbs = $canCreateSlider ? [
    'type' => 'SlickProductThumbs',
    'user-type-options' => [
        'asNavFor' => '[data-slick-slider="product"]',
    ],
] : [];
@endphp

<div {!! Html::attributes([
        'class' => [
            'product-slider',
            $mod_class ?? null,
            'js-init',
            '_pb-def'
        ],
        'data-slick-slider' => json_encode($_config),
        'data-mfp' => 'product-gallery',
        'data-product' => json_encode($_configProduct),
    ]) !!}>
    <div class="slick-slider-list" data-slick-slider="product">
        @foreach($existedImages as $image)
            <a href="{{ $image->link() }}" class="product-slide slick-slider-list__item js-product-gallery__item">
                {!! $image->imageTag('medium', ['class' => 'product-slide__image', 'alt' => "$product->name", 'title' => "$product->name"]) !!}
            </a>
        @endforeach
    </div>
    @if($canCreateSlider)
        <div class="product-thumbs-slider__dots slick-slider-dots" data-slick-dots></div>
    @endif
</div>
@if($canCreateSlider && browserizr()->isDesktop() && $existedImages->count() > 1)
    <div {!! Html::attributes([
        'class' => [
            'product-thumbs-slider',
            '_def-show',
            $mod_class ?? null,
            $canCreateSlider ? 'js-init' : null,
        ],
        'data-slick-slider' => json_encode($_config_thumbs),
    ]) !!}>
        <div class="product-thumbs-slider__list slick-slider-list" data-slick-slider="product-thumbs">
            @php
                $img_counter = 2;
            @endphp
            @foreach($existedImages as $image)
                <div class="slick-slider-list__item">
                    <div class="product-thumbs-slide">
                        {!! $image->imageTag('small', ['class' => 'product-thumbs-slide__img', 'width' => 87, 'height' => 60, 'alt' => "$product->name" . " - Фото " . $img_counter, 'title' => "$product->name" . " - Фото " . $img_counter]) !!}
                    </div>
                </div>
                @php
                    $img_counter = $img_counter + 1;
                @endphp
            @endforeach
        </div>
        <div class="product-thumbs-slider__arrows">
            <div class="slick-slider-arrow slick-slider-arrow--prev" data-slick-arrow-prev>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin') !!}
            </div>
            <div class="slick-slider-arrow slick-slider-arrow--next" data-slick-arrow-next>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin') !!}
            </div>
        </div>
        <div class="product-thumbs-slider__dots slick-slider-dots" data-slick-dots></div>
    </div>
@endif
<div style="display: none;">
    <div id="popup-product--template">
        <div class="product-popup">
            <div class="product-popup__top">
                <div class="mfp-title product-popup__title"></div>
                <div class="mfp-close"></div>
                <div class="product-popup-price">
                    <div class="mfp-price product-popup-price__item"></div>
                    <div class="product-popup-price__button">
                        <button type="button" class="button button--theme-main button--size-normal js-popup-basket" data-id="">
                            <span class="button__body">
                                {!! \SiteHelpers\SvgSpritemap::get('icon-shopping', [
                                    'class' => 'button__icon button__icon--before'
                                ]) !!}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mfp-img"></div>
            <div class="mfp-counter product-popup__counter"></div>
        </div>
    </div>
</div>
