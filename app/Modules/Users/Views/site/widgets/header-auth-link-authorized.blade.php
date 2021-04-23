<div class="header-line-item has-submenu">
    <a class="header-line-item__link header-line-item__link--icon" href="{{ route('site.account') }}">
        {!! SiteHelpers\SvgSpritemap::get('icon-user') !!}
        <span>@lang('users::site.my-account')</span>
    </a>
    {!! Widget::show('user-account-top-menu') !!}
</div>