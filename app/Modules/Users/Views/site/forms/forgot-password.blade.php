@php
$idModifier = $idModifier ?? '';
$formId = $formId ?? 'forgot-password' . rand(1, 99999);
$isPopup = $isPopup ?? false;
@endphp
{!! $validation ?? '' !!}
<div class="form form--pass-reset">
    {!! Form::open(['route' => 'site.forgot-password', 'method' => 'POST', 'class' => ['js-init', 'ajax-form'], 'id' => $formId]) !!}
    <div class="form__body">
        <div class="grid _nmtb-sm">
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field" type="email" name="email" id="{{ $idModifier }}pass-reset-email">
                        <label class="control__label" for="{{ $idModifier }}pass-reset-email">Ваш e-mail</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form__footer">
        <div class="grid _justify-center _md-justify-between _items-center">
            @if($isPopup)
                <div class="gcell gcell--12 gcell--xs-6 _text-center _xs-text-left">
                    <div class="_mb-xs"><button class="button button--air" data-wstabs-ns="regauth" data-wstabs-button="1" type="button">Вход на сайт</button></div>
                    <div class="_mb-xs"><button class="button button--air" data-wstabs-ns="regauth" data-wstabs-button="2" type="button">Регистрация</button></div>
                </div>
            @endif
            <div class="gcell gcell--10 gcell--xs-6 _mt-md _xs-mt-none _text-center _xs-text-right">
                <div class="control control--submit">
                    <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                        <span class="button__body">
                            <span class="button__text">Восстановить</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
