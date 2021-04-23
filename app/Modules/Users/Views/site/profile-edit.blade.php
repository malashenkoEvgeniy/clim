@php
/** @var \App\Modules\Users\Models\User $user */
/** @var \Illuminate\Support\ViewErrorBag $errors */
/** @var string|null $message */
/** @var string $formId */
$firstError = $errors->first();
$title = 'Редактирование личных данных';
@endphp

@extends('users::site.layouts.with-left-menu')

@section('layout-body')
    <div class="gcell gcell--12 _p-none">
        <div class="form form--password-change">
            {!! Form::open([
                'route' => 'site.account.update',
                'method' => 'put',
                'id' => $formId,
                'class' => 'js-init'
            ]) !!}
            <div class="form__body">
                <div class="grid">
                    <div class="gcell gcell--12 _pt-sm _pb-lg _plr-lg">
                        <div class="grid _nmtb-lg">
                            <div class="gcell gcell--12 _pt-lg _pb-sm">
                                <div class="title title--size-h3">Основные данные</div>
                            </div>
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
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input has-value">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="first_name" id="profile-name" value="{{ old('first_name', $user->first_name) }}">
                                        <label class="control__label" for="profile-name">Имя</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input{{ old('last_name', $user->last_name) !== null ? ' has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="last_name" id="profile-last_name" value="{{ old('last_name', $user->last_name) }}">
                                        <label class="control__label" for="profile-name">Фамилия</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input has-value">
                                    <div class="control__inner">
                                        <input class="control__field" type="email" name="email" id="profile-email" value="{{ old('email', $user->email) }}">
                                        <label class="control__label" for="profile-email">Эл. почта *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input{{ old('phone', $user->phone) !== null ? ' has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field js-init" type="text" name="phone" id="profile-phone" value="{{ old('phone', $user->phone) }}" data-phonemask>
                                        <label class="control__label" for="profile-phone">Телефон</label>
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
