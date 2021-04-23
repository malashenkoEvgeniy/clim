<div class="popup__container">
    <div class="popup__head">
        <div class="grid _flex-nowrap">
            <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                {!! SiteHelpers\SvgSpritemap::get('icon-user', [
                    'class' => 'svg-icon svg-icon--icon-user',
                ]) !!}
            </div>
            <div class="gcell gcell--auto _flex-grow">
                <div class="popup__title">Вход на сайт</div>
                <div class="popup__desc">Вы сможете получить первые преимущества сразу после входа</div>
            </div>
        </div>
    </div>
    <div class="popup__body">
        {!! Widget::show('login-form', true) !!}
    </div>
</div>
