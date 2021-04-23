<div class="grid grid--auto">
    <div class="gcell _flex-grow">
        {!! Widget::show('logo-mobile') !!}
    </div>
    {!! Widget::show('mobile-top-compare-button') !!}
    {!! Widget::show('mobile-top-wishlist-button') !!}
    {!! Widget::show('mobile-top-cart-button') !!}
    {!! Widget::show('mobile-top-profile-button') !!}
    {!! Widget::show('mobile-top-search-button') !!}

    <div class="gcell _xs-ml-xs">
        <div role="button" tabindex="0" class="menu-button" title="Корзина"
                data-mmenu-opener="mobile-menu">
            <div class="menu-button__icon">
                @include('site._widgets.elements.hamburger.hamburger')
            </div>
        </div>
    </div>
</div>
