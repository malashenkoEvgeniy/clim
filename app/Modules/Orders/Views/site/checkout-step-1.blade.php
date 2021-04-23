@php
/** @var \App\Modules\Orders\Types\StepOneType $info */
@endphp

@extends('site._layouts.checkout')

@push('hidden_data')
    {!! JsValidator::make($rules, $messages, $attributes, '#' . $formId) !!}
@endpush

@push('hidden_data')
    <script>
        window.LOCO_DATA.checkout = "/";
    </script>
@endpush

@section('layout-body')
    <div class="section _mb-xl _def-mtb-xl">
        <div class="container">
            <div class="grid _justify-center _def-justify-between _def-flex-row-reverse">
                <div class="gcell gcell--12 gcell--md-8 gcell--def-6 _plr-sm _pt-sm _pb-xl _md-plr-md _md-pt-md _def-p-xl" data-cart-container="checkout" style="min-height: 150px">
                    {!! Widget::show('orders::cart::checkout') !!}
                </div>
                <div class="gcell gcell--12 gcell--md-8 gcell--def-6 _plr-md _ptb-def _def-p-xl" style="background-color: #fff;">
                    <div class="title title--size-h1">@lang('orders::site.checkout')</div>
                    <div class="hint hint--decore _text-left"><span>@lang('orders::site.step-1')</span></div>
                    <div class="title title--size-h2 _mb-none">@lang('orders::site.contact-data')</div>
                    {!! Widget::show('are-you-client-button') !!}
                    <div class="form form--checkout-step-1">
                        {!! Form::open(['route' => 'site.checkout', 'class' => ['js-init', 'ajax-form'], 'id' => $formId, 'autocomplete' => 'off']) !!}
                        <div class="form__body">
                            <div class="grid _nmtb-sm">
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input {{ $info->email ? 'has-value' : '' }}">
                                        <div class="control__inner">
                                            <input class="control__field" type="email" name="email" id="profile-email" value="{{ $info->email }}" required>
                                            <label class="control__label" for="profile-email">@lang('validation.attributes.email') {{ (bool)config('db.orders.email-is-required', true) ? '*' : '' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input {{ $info->phone ? 'has-value' : '' }}">
                                        <div class="control__inner">
                                            <input class="control__field js-init" type="tel" name="phone" id="profile-phone" value="{{ $info->phone }}" data-phonemask required>
                                            <label class="control__label" for="profile-phone">@lang('validation.attributes.phone') *</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input {{ $info->name ? 'has-value' : '' }}">
                                        <div class="control__inner">
                                            <input class="control__field" type="text" name="name" id="profile-name" value="{{ $info->name }}" required>
                                            <label class="control__label" for="profile-name">@lang('orders::site.name-and-last-name')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input {{ $info->city ?? null ? 'has-value' : '' }} js-init" data-location-suggest="{{ route('site.location.suggest') }}">
                                        <div class="control__inner">
                                            <input type="text" class="_visuallyhidden" name="locationId" id="profile-location-id" value="{{ $info->locationId }}" data-suggest-location-id>
                                            <input class="control__field find-city" type="text" name="location" id="profile-location" value="{{ $info->city }}" required data-suggest-input>
                                            <label id="profile-location-id-error" class="has-error" for="profile-location-id" style="display: none;"></label>
                                            <label class="control__label" for="profile-location">@lang('orders::site.city') *</label>
                                            <div class="location-suggest-wrap" data-suggest-list></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__footer">
                            <div class="grid _justify-center">
                                <div class="gcell gcell--12 gcell--sm-8 _text-center">
                                    <div class="control control--submit">
                                        <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                            <span class="button__body">
                                                <span class="button__text">@lang('orders::site.next-step')</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="_mt-lg is-disabled">
                        <div class="hint hint--decore _text-left"><span>@lang('orders::site.step-2')</span></div>
                        <div class="title title--size-h2">@lang('orders::site.payment-and-delivery')</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
