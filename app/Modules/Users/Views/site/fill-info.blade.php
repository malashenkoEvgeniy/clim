@php
$title = 'Заполнение данных';
$message = request()->session()->get('message');
@endphp

@extends('site._layouts.account-no-menu')

@section('account-content')
    <div class="section" style="width: 100%;">
        <div class="container">
            <div class="box box--gap">
                @if($message)
                    <div class="gcell gcell--12 _ptb-sm _plr-lg">
                        @component('site._widgets.alert.alert', [
                            'alert_type' => 'secondary',
                            'alert_icon' => 'icon-ok',
                        ])
                            <div>{{ $message }}</div>
                        @endcomponent
                    </div>
                @endif
                <div class="gcell gcell--12 gcell--def-12 _p-lg">
                    {!! Form::open(['route' => 'site.socials.fill-info', 'method' => 'POST']) !!}
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="email" name="email" id="login-email" required>
                                        <label class="control__label" for="login-email">@lang('users::site.seo.your-email')</label>
                                    </div>
                                </div>
                            </div>
                           <input type="hidden" name="uid" value="{{ $userData['uid'] }}">
                           <input type="hidden" name="network" value="{{ $userData['network'] }}">
                           <input type="hidden" name="first_name" value="{{ $userData['first_name'] }}">
                           <input type="hidden" name="last_name" value="{{ $userData['last_name'] }}">
                           <input type="hidden" name="phone" value="{{ $userData['phone'] }}">
                            <input type="hidden" name="identity" value="{{ $userData['identity'] }}">
                            <input type="submit" value="@lang('users::site.sing-up')">
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
