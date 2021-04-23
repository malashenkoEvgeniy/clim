@php
/** @var \App\Modules\Products\Models\Product $product */
$productClass = $product->getMorphClass();
@endphp

<div class="compare-group-card" data-comparelist-card data-product-id="{{ $product->id }}">
    <a href="{{ $product->site_link }}" class="compare-group-card__preview">
        {!! $product->preview->imageTag('small', ['class' => 'compare-group-card__image']) !!}
    </a>
    <div class="compare-group-card__body">
        <div class="compare-group-card__title">
            <a href="{{ $product->site_link }}" class="link link--black">
                {{ $product->name }}
            </a>
        </div>
        <div class="compare-group-card__price">
            <div class="compare-group-card__price-old">
                {{ $product->formatted_old_price }}
            </div>
            <div class="compare-group-card__price-current">
                {{ $product->formatted_price }}
            </div>
        </div>
    </div>
    <div class="compare-group-card__remove">
        <button class="button button--remove" data-comparelist-toggle="{{ $product->id }}">
            <span class="button__body">
                {!! SiteHelpers\SvgSpritemap::get('icon-close-rounded-sm', ['class' => 'button__icon button__icon--before']) !!}
            </span>
        </button>
    </div>
</div>
