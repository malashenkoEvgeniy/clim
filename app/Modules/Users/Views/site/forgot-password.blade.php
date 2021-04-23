@php
$title = 'Забыли пароль?';
@endphp

@extends('site._layouts.account-no-menu')

@section('account-content')
    <div class="section" style="width: 100%;">
        <div class="container">
            <div class="box box--gap">
                <div class="gcell gcell--12 gcell--def-12 _p-xl">
                    {!! Widget::show('forgot-password-form') !!}
                </div>
            </div>
        </div>
    </div>
@stop
