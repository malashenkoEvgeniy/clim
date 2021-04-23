<div id="popup-consultation" class="popup popup--consultation">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                    {!! SiteHelpers\SvgSpritemap::get('icon-ask-doctor', [
                        'class' => 'svg-icon svg-icon--icon-ask-doctor',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">Закажите консультацию</div>
                    <div class="popup__desc">мы свяжемся с вами в ближайшее время</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="form form--consultation">
                <form action="/consultation" method="POST">
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="consultation-name" id="consultation-name">
                                        <label class="control__label" for="consultation-name">Ваше ФИО</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="tel" name="consultation-phone" id="consultation-phone">
                                        <label class="control__label" for="consultation-phone">Ваш номер телефона *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="consultation-question" id="consultation-question">
                                        <label class="control__label" for="consultation-question">Напишите Ваш вопрос</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _pt-lg _pb-sm">
                                @component('site._widgets.checker.checker', [
                                    'attributes' => [
                                        'type' => 'checkbox',
                                        'name' => 'personal-data-processing',
                                        'required',
                                    ]
                                ])
                                   * Я согласен на обработку моих данных.<br><a href="#read-more">Подробнее</a>
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
                                            <span class="button__text">Заказать</span>
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
