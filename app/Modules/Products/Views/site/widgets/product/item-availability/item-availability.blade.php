<div class="product-status _pb-xs">
    <div class="product-status__icon">
        {!! SiteHelpers\SvgSpritemap::get($available ? 'icon-available' : 'icon-not-available') !!}
    </div>
    <div class="product-status__text">{{ $text }}</div>
</div>
