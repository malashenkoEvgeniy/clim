@php
/** @var \Illuminate\Support\ViewErrorBag $errors */
/** @var string|null $message */
/** @var string $formId */
$firstError = $errors->first();
$title = 'Изменение пароля';
@endphp

@extends('users::site.layouts.with-left-menu')

@section('layout-body')
    <div class="gcell gcell--12 _p-none">
        <div class="form form--password-change">
            {!! Form::open(['route' => 'site.account.update-password', 'method' => 'PUT', 'id' => $formId, 'class' => 'js-init']) !!}
                <div class="form__body">
                    <div class="grid">
                        <div class="gcell gcell--12 _pt-sm _pb-lg _plr-lg">
                            <div class="grid _nmtb-lg">
                                @if($firstError)
                                    <div class="gcell gcell--12 _ptb-lg">
                                        @component('site._widgets.alert.alert', [
                                            'alert_type' => 'danger',
                                            'alert_icon' => 'icon-disappoint',
                                        ])
                                            <div>{{ $firstError }}</div>
                                        @endcomponent
                                    </div>
                                @endif
                                @if($message)
                                    <div class="gcell gcell--12 _ptb-lg">
                                        @component('site._widgets.alert.alert', [
                                            'alert_type' => 'success',
                                            'alert_icon' => 'icon-ok',
                                        ])
                                            <div>{{ $message }}</div>
                                        @endcomponent
                                    </div>
                                @endif
                                <div class="gcell gcell--12 _pt-lg _pb-sm">
                                    <div class="control control--input">
                                        <div class="control__inner">
                                            <input class="control__field" type="password" name="current_password" id="profile-current-password">
                                            <label class="control__label" for="profile-current-password">Текущий пароль</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input">
                                        <div class="control__inner">
                                            <input class="control__field" type="password" name="new_password" id="profile-new-password">
                                            <label class="control__label" for="profile-new-password">Новый пароль</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _pt-sm _pb-lg">
                                    <div class="control control--input">
                                        <div class="control__inner">
                                            <input class="control__field" type="password" name="new_password_confirmation" id="profile-new-password-repeat">
                                            <label class="control__label" for="profile-new-password-repeat">Повторите новый пароль</label>
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
                                                <span class="button__text">Сохранить</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _pb-lg _pt-sm _text-center">
                                    <a class="link" href="{{ route('site.account') }}">Отмена</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
