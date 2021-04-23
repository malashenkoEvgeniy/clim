{{-- @TODO:PHP => подвязать попап в модуль wishlist-а --}}
<div id="popup-wishlist-confirm-mass-delete" class="popup popup--wishlist-confirm-mass-delete">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-md">
                    {!! SiteHelpers\SvgSpritemap::get('icon-wishlist', [
                        'class' => 'svg-icon svg-icon--icon-wishlist',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">Удаление товаров</div>
                    <div class="popup__desc">Вы точно хотите безвозвратно удалить эти товары из списка желаний?</div>
                </div>
            </div>
        </div>
        <div class="form__footer">
            <div class="grid _justify-center">
                <div class="gcell gcell--12 gcell--sm-10 gcell--md-8 _text-center">
                    <button class="button button--theme-main button--size-normal button--width-full" type="button" data-confirm-action="remove">
                        <span class="button__body">
                            <span class="button__text">Подтвердить</span>
                        </span>
                    </button>
                    <button class="button button--air _mt-lg" type="button" data-confirm-action="cancel">
                        <span class="button__body">
                            <span class="button__text">Отмена</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
