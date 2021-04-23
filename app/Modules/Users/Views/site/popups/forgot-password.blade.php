<div class="popup__container">
    <div class="popup__head">
        <div class="grid _flex-nowrap">
            <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                {!! SiteHelpers\SvgSpritemap::get('icon-user', [
                    'class' => 'svg-icon svg-icon--icon-user',
                ]) !!}
            </div>
            <div class="gcell gcell--auto _flex-grow">
                <div class="popup__title">Восстановить пароль</div>
                <div class="popup__desc">Новый пароль придет на указанную Вами почту в течении 5 минут</div>
            </div>
        </div>
    </div>
    <div class="popup__body">
        {!! Widget::show('forgot-password-form', true) !!}
    </div>
</div>