@php
$title = 'Вход в ЛК';
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
                    {!! Widget::show('login-form') !!}
                </div>
                <div class="grid _nmlr-sm _pt-md">
                    {!! Widget::show('social-networks') !!}
                </div>
            </div>
        </div>
    </div>
@stop
