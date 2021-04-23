<div id="popup-send-resume" class="popup popup--send-resume">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-md">
                    {!! SiteHelpers\SvgSpritemap::get('icon-document', [
                        'class' => 'svg-icon svg-icon--icon-document',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">Отправьте резюме</div>
                    <div class="popup__desc">мы свяжемся с вами в ближайшее время</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="form form--send-resume">
                <form action="/send-resume" method="POST">
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="send-resume-name" id="send-resume-name">
                                        <label class="control__label" for="send-resume-name">Ваше имя</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="send-resume-vacancy" id="send-resume-vacancy">
                                        <label class="control__label" for="send-resume-vacancy">Напишите название вакансии</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _pt-lg _pb-sm">
                                <div class="control control--file">
                                    @include('site._widgets.droparea.droparea')
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

