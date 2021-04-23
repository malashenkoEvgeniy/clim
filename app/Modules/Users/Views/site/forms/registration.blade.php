@php
$idModifier = $idModifier ?? '';
$formId = $formId ?? 'registration-form' . rand(1, 99999);
$isPopup = $isPopup ?? false;
@endphp
{!! $validation ?? '' !!}

<div class="form form--registration">
    {!! Form::open(['route' => 'site.register', 'method' => 'POST', 'class' => ['js-init', 'ajax-form'], 'id' => $formId]) !!}
    <div class="form__body">
        <div class="grid _nmtb-sm">
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field" type="text" name="name" id="{{ $idModifier }}registration-name">
                        <label class="control__label" for="{{ $idModifier }}registration-name">Ваше имя</label>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field js-init" type="tel" name="phone" id="{{ $idModifier }}registration-phone" data-phonemask>
                        <label class="control__label" for="{{ $idModifier }}registration-phone">Ваш номер телефона</label>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field" type="email" name="email" id="{{ $idModifier }}registration-email">
                        <label class="control__label" for="{{ $idModifier }}registration-email">Ваш e-mail *</label>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field" type="password" name="password" id="{{ $idModifier }}registration-pass">
                        <label class="control__label" for="{{ $idModifier }}registration-pass">Придумайте пароль *</label>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field" type="password" name="password_confirmation" id="{{ $idModifier }}registration-pass-repeat">
                        <label class="control__label" for="{{ $idModifier }}registration-pass-repeat">Повторите пароль</label>
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
                   * Я согласен на обработку моих данных.<br><a href="{{ config('db.basic.agreement_link') }}" target="_blank">Подробнее</a>
                @endcomponent
            </div>
        </div>
    </div>
    <div class="form__footer">
        <div class="grid _justify-center _md-justify-between _items-center">
            @if($isPopup)
                <div class="gcell gcell--12 gcell--xs-6 _text-center _xs-text-left">
                    <div class="_mb-xs"><button class="button button--air" data-wstabs-ns="regauth" data-wstabs-button="1" type="button">Вход на сайт</button></div>
                </div>
            @endif
            <div class="gcell gcell--10 gcell--xs-6 _mt-md _xs-mt-none _text-center _xs-text-right">
                <div class="control control--submit">
                    <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                        <span class="button__body">
                            <span class="button__text">Регистрация</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
