<div id="popup-report-availability" class="popup popup--report-availability">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-md">
                    {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                        'class' => 'svg-icon svg-icon--icon-shopping',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">Сообщить о наличии</div>
                    <div class="popup__desc">Введите свой адрес эл. почты и мы вас оповестим, когда товар появится в наличии</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="form form--report-availability">
                <form action="/report-availability" method="POST">
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="report-availability-name" id="report-availability-name">
                                        <label class="control__label" for="report-availability-name">Ваше ФИО</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="email" name="report-availability-email" id="report-availability-email">
                                        <label class="control__label" for="report-availability-email">Ваш e-mail</label>
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
                                            <span class="button__text">Отправить</span>
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

