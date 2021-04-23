<div class="header-line-submenu header-line-submenu--full-width">
    <div class="header-line-submenu__inner">
        @foreach($menu->getKids() as $link)
            <div class="header-line-submenu__item">
                <a href="{{ $link->getUrl() }}" class="header-line-submenu__link">
                    <span class="header-line-submenu__icon">
                        {!! SiteHelpers\SvgSpritemap::get($link->icon) !!}
                    </span>
                    <span class="header-line-submenu__text">{{ __($link->name) }}</span>
                </a>
            </div>
        @endforeach
        <div class="header-line-submenu__item">
            <a href="{{ route('site.logout') }}" class="header-line-submenu__link">
                <span class="header-line-submenu__icon">
                    {!! SiteHelpers\SvgSpritemap::get('icon-logout') !!}
                </span>
                <span class="header-line-submenu__text">
                    @lang('users::site.logout-from-the-site')
                </span>
            </a>
        </div>
    </div>
</div>