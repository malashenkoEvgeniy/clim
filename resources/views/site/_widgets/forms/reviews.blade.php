<div class="form">
    <form>
        <div class="form__body">
            <div class="grid">
                <div class="gcell gcell--12 _pt-sm _pb-lg _sm-plr-lg">
                    <div class="grid">
                        <div class="gcell gcell--12 _pb-md">
                            <div class="control control--textarea">
                                <div class="control__inner">
                                    <textarea class="control__field" name="message"
                                              id="review-message" required></textarea>
                                    <label class="control__label" for="review-message">Ваше сообщение *</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid _nml-md _nmt-md _pb-md">
                        <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                            <div class="control control--input">
                                <div class="control__inner">
                                    <input class="control__field" type="text" name="name" id="review-name" required>
                                    <label class="control__label" for="review-name">Имя *</label>
                                </div>
                            </div>
                        </div>
                        <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                            <div class="control control--input">
                                <div class="control__inner">
                                    <input class="control__field" type="email" name="email"
                                           id="review-email">
                                    <label class="control__label" for="review-email">Эл. почта</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid _nml-md _nmt-md">
                        <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                            <div class="control control--input">
                                <div class="control__inner">
                                    <input class="control__field" type="text" name="career" id="review-career">
                                    <label class="control__label" for="career-name">Род деятельности</label>
                                </div>
                            </div>
                        </div>
                        <div class="gcell gcell--12 gcell--ms-6 _pl-md _pt-md">
                            <div class="control control--input">
                                <div class="droparea droparea--small js-init" data-droparea>
                                    <input type="file" name="file" class="droparea__input" accept=".jpg, .png" data-droparea="input">
                                    <div class="droparea__icon">
                                        {!! SiteHelpers\SvgSpritemap::get('icon-clip', [
                                            'class' => 'svg-icon svg-icon--icon-clip',
                                        ]) !!}
                                    </div>
                                    <div class="droparea__message">Выберите изображение Вашего аватара</div>
                                    <div class="droparea__file-info" data-droparea="file-info"></div>
                                    <div class="droparea__clear" data-droparea="clear">Очистить</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gcell gcell--12 _sm-plr-lg">
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
                <div class="gcell gcell--12 _sm-plr-lg">
                    <div class="grid _justify-center">
                        <div class="gcell _pt-lg _pb-sm">
                            <div class="control control--submit">
                                <button class="button button--theme-main button--size-normal"
                                        type="submit">
                                        <span class="button__body">
                                            <span class="button__text">Отправить отзыв</span>
                                        </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
