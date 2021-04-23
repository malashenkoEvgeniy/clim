<div id="popup-login-only" class="popup popup--login-only _pb-xl">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                    {!! SiteHelpers\SvgSpritemap::get('icon-user', [
                        'class' => 'svg-icon svg-icon--icon-user',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">@lang('users::site.sing-in')</div>
                    <div class="popup__desc">@lang('users::site.benefits-after-login')</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            {!! Widget::show('login-form', true, true) !!}
        </div>
    </div>
</div>
