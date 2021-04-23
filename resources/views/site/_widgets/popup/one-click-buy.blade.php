<div id="popup-one-click-buy" class="popup popup--one-click-buy">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-md">
                    {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                        'class' => 'svg-icon svg-icon--icon-shopping',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">Купить в 1 клик</div>
                    <div class="popup__desc">Введите номер телефона и мы Вам перезвоним для оформления заказа</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="form form--one-click-buy">
                <form action="/one-click-buy" method="POST">
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="tel" name="one-click-buy-phone" id="one-click-buy-phone">
                                        <label class="control__label" for="one-click-buy-phone">+38 (0__) ___-__-__</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _pt-lg _pb-sm">
                                @component('site._widgets.checker.checker', [
									'attributes' => [
										'type' => 'checkbox',
										'name' => 'personal-data-processing',
										'required' => true,
									]
								])
                                    Я согласен на обработку моих данных.<br><a href="#read-more">Подробнее</a>
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="form__footer">
                        <div class="grid _justify-center">
                            <div class="gcell gcell--12 gcell--sm-10 gcell--md-8">
                                <div class="control control--submit">
                                    <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                        <span class="button__body">
                                            <span class="button__text">Купить в один клик</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

