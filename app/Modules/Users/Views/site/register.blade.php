@php
$title = 'Регистрация';
@endphp

@extends('site._layouts.account-no-menu')

@section('account-content')
    <div class="section" style="width: 100%;">
        <div class="container">
            <div class="box box--gap">
                <div class="gcell gcell--12 gcell--def-12 _p-lg">
                    {!! Widget::show('registration-form') !!}
                </div>
                <div class="grid _nmlr-sm _pt-md">
                    {!! Widget::show('social-networks') !!}
                </div>
            </div>
        </div>
    </div>
@stop
