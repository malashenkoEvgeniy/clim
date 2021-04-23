@php
/** @var int $total */
@endphp

<div class="gcell _xs-ml-xs">
    <a href="{{ route('site.wishlist') }}" role="button" tabindex="0" class="menu-button" title="@lang('wishlist::site.account-menu-link')">
        {!! \SiteHelpers\SvgSpritemap::get('icon-wishlist', ['class' => 'menu-button__icon']) !!}
        <div class="menu-button__count" data-wishlist-counter>{{ $total ?: null }}</div>
    </a>
</div>
