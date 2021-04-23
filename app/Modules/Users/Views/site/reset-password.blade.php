@php
$title = 'Reset Password';
@endphp

@extends('site._layouts.account-no-menu')

@push('hidden_data')
    {!! $validation !!}
@endpush

@section('account-content')
    <div class="gcell gcell--12 _p-none">
        <div class="form form--password-change">
            {!! Form::open(['id' => $formId, 'route' => 'site.reset-password', 'method' => 'post', 'class' => ['js-init', 'ajax-form']]) !!}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form__body">
                <div class="grid">
                    <div class="gcell gcell--12 _pt-sm _pb-lg _plr-lg">
                        <div class="grid _nmtb-lg">
                            @if(session('status'))
                                <div class="gcell gcell--12 _ptb-lg">
                                    @component('site._widgets.alert.alert', [
                                        'alert_type' => 'danger',
                                    ])
                                        <div>{{ session('status') }}</div>
                                    @endcomponent
                                </div>
                            @endif
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input has-value">
                                    <div class="control__inner">
                                        <input class="control__field" type="email" name="email" id="profile-email" value="{{ old('email') }}">
                                        <label class="control__label" for="profile-email">{{ __('E-Mail Address') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="password" name="password" id="profile-password">
                                        <label class="control__label" for="profile-password">Новый пароль</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _pt-sm _pb-lg">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="password" name="password_confirmation" id="profile-password_confirmation">
                                        <label class="control__label" for="profile-password_confirmation">Повторите новый пароль</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gcell gcell--12 _plr-lg" style="border-top: 1px solid #f2f2f2;">
                        <div class="grid">
                            <div class="gcell gcell--12 _pt-lg _pb-sm">
                                <div class="control control--submit">
                                    <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                        <span class="button__body">
                                            <span class="button__text">Сбросить пароль</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _pb-lg _pt-sm _text-center">
                                <a class="link" href="{{ route('site.register') }}">Регистрация</a>
                                <a class="link" href="{{ route('site.login') }}">{{ __('Login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
