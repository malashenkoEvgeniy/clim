@php
    $idModifier = $idModifier ?? '';
    $formId = $formId ?? 'login-form' . rand(1, 99999);
    $isPopup = $isPopup ?? false;
@endphp
<div class="form form--login">
    {!! JsValidator::make($rules, $messages, $attributes, '#' . $formId); !!}
    {!! Form::open(['route' => 'site.login', 'method' => 'POST', 'class' => ['js-init', 'ajax-form'], 'id' => $formId]) !!}
    <div class="form__body">
        <div class="grid _nmtb-sm">
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field" type="email" name="email" id="{{ $idModifier }}login-email" required>
                        <label class="control__label" for="{{ $idModifier }}login-email">@lang('users::site.seo.your-email')</label>
                    </div>
                </div>
            </div>
            <div class="gcell gcell--12 _ptb-sm">
                <div class="control control--input">
                    <div class="control__inner">
                        <input class="control__field" type="password" name="password" id="{{ $idModifier }}login-pass" required>
                        <label class="control__label" for="{{ $idModifier }}login-pass">@lang('users::site.seo.your-password')</label>
                    </div>
                </div>
            </div>
            @if($isCheckout)
                <div class="gcell gcell--12 gcell--xs-6 _text-center _xs-text-left">
                    @component('site._widgets.checker.checker', ['attributes' => [
                        'type' => 'checkbox',
                        'name' => 'remember',
                    ]])
                        @lang('auth.remember-me')
                    @endcomponent
                </div>
                <div class="gcell gcell--10 gcell--xs-6 _mt-md _xs-mt-none _text-center _xs-text-right">
                    <div class="control control--submit">
                        <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                            <span class="button__body">
                                <span class="button__text">@lang('users::site.enter')</span>
                            </span>
                        </button>
                    </div>
                </div>
            @else
                <div class="gcell gcell--12 _pt-lg _pb-sm">
                    @component('site._widgets.checker.checker', ['attributes' => [
                        'type' => 'checkbox',
                        'name' => 'remember',
                    ]])
                        @lang('auth.remember-me')
                    @endcomponent
                </div>
            @endif
        </div>
    </div>
    @if(!$isCheckout)
        <div class="form__footer">
            <div class="grid _justify-center _md-justify-between _items-center">
                @if($isPopup)
                    <div class="gcell gcell--12 gcell--xs-6 _text-center _xs-text-left">
                        <div class="_mb-xs"><button class="button button--air" data-wstabs-ns="regauth" data-wstabs-button="2" type="button">@lang('users::site.seo.registration')</button></div>
                        <div class="_mb-xs"><button class="button button--air" data-wstabs-ns="regauth" data-wstabs-button="3" type="button">@lang('users::site.seo.restore-password')</button></div>
                    </div>
                @endif
                <div class="gcell gcell--10 gcell--xs-6 _mt-md _xs-mt-none _text-center _xs-text-right">
                    <div class="control control--submit">
                        <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                            <span class="button__body">
                                <span class="button__text">@lang('users::site.enter')</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @elseif(Route::has('site.checkout'))
        <input type="hidden" name="redirect" value="{{ route('site.checkout') }}">
    @endif
    {!! Form::close() !!}
</div>
