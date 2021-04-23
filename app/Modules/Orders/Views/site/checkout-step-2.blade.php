@php
/** @var \App\Modules\Orders\Types\StepOneType $info */
/** @var array $paymentMethods */
/** @var array $deliveries */
/** @var bool $canMakeOrder */
/** @var integer $minimumOrderAmount */
$canMakeOrder = true;
@endphp

@extends('site._layouts.checkout')

@push('head-styles')
    <style>
        .checkout-delivery-trigger.is-active {
            pointer-events: none;
        }
    </style>
@endpush

@push('hidden_data')
    {!! JsValidator::make($rules, $messages, $attributes, '#' . $formId) !!}
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
                    <div class="_mb-def">
                        <span style="font-size: 12px;">{{ $info->name }}, {{ $info->phone }}</span> &bull;
                        <a href="{{ route('site.checkout') }}" class="link link--sm">@lang('orders::site.edit')</a>
                    </div>
                    <div class="hint hint--decore _text-left"><span>@lang('orders::site.step-2')</span></div>
                    <div class="title title--size-h2 _mb-xs">@lang('orders::site.payment-and-delivery')</div>
                    <div class="form form--checkout-step-2">
                        {!! Form::open(['route' => 'site.checkout.step-2', 'class' => ['js-init', 'ajax-form'], 'id' => $formId]) !!}
                        <div class="form__body js-init" data-related="{{ json_encode(['payment-method']) }}">
                            <div class="grid _nmtb-sm">
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="hint">
                                        @if($info->city)@lang('orders::site.city') <strong>{{ $info->city }}</strong>@endif
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="_mb-xl">
                                        <div class="hint hint--lg _pl-md"><span>@lang('orders::general.delivery-type')</span></div>
                                        <div class="grid _mtb-md js-init _posr" data-accordion="{{ json_encode(['type' => 'single-checkers', 'slideTime' => 200]) }}">
                                            @foreach($deliveries as $delivery => $deliveryName)
                                                @if ($delivery === 'self' && !config('db.orders.address_for_self_delivery'))
                                                    @continue;
                                                @endif
                                                <div class="gcell gcell--12 _plr-md _ptb-xs">
                                                    @php
                                                        $ns = 'delivery-method';
                                                        $id = $loop->iteration;
                                                        $isOpened = '';


                                                        $related_to = ['bank_transaction', 'liqpay'];
                                                        if (preg_match('/^nova-poshta$|^self$|^address$/', $delivery)) {
                                                            $related_to[] = 'cash';
                                                        }
                                                        if (preg_match('/^nova-poshta-self$|^address$/', $delivery)) {
                                                            $related_to[] = 'cash-on-delivery';
                                                        }
                                                        if (preg_match('/^other$/', $delivery)) {
                                                            $related_to[] = 'cash';
                                                            $related_to[] = 'cash-on-delivery';
                                                        }
                                                    @endphp
                                                    <div class="checkout-delivery-trigger {{ $isOpened }}" style="display: inline-block;" {!! sprintf("data-wstabs-ns=\"%s\" data-wstabs-button=\"%s\"", $ns, $id) !!}>
                                                            @component('site._widgets.radio.radio', [
                                                                'classes' => '_color-gray4',
                                                                'attributes' => [
                                                                    'type' => 'radio',
                                                                    'name' => 'delivery',
                                                                    'value' => $delivery,
                                                                    'data-related-to' => 'payment-method',
                                                                    'data-relations' => json_encode($related_to),
                                                                ]
                                                            ])
                                                            @lang($deliveryName)
                                                        @endcomponent
                                                    </div>
                                                    <div class="checkout-delivery-content {{ $isOpened }}" {!! $isOpened ? null : 'style="display: none;"' !!} data-wstabs-ns="{{ $ns }}" data-wstabs-block="{{ $id }}">
                                                        <div class="_pl-xl _pt-sm _pb-md">
                                                            @if($delivery === 'nova-poshta-self')
                                                                <div class="control control--select">
                                                                    <div class="control__inner">
                                                                        <select class="control__field" name="{{ $delivery }}" id="{{ $delivery }}" onchange="this.blur()">
                                                                            <option value="" selected="" disabled="">Выберите склад</option>
                                                                            @foreach( $warehouses as $warehouse)
                                                                                <option value="{{ $warehouse->Ref }}" {{ old($delivery) ===  $warehouse->Ref  ? 'selected' : null }}>
                                                                                    {{ $warehouse->Description }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @elseif($delivery === 'nova-poshta')
                                                                <div class="control control--input">
                                                                    <div class="control__inner">
                                                                        <input class="control__field" type="text" name="{{ $delivery }}"  id="{{ $delivery }}" required>
                                                                        <label class="control__label" for="{{ $delivery }}">Введите адрес доставки</label>
                                                                    </div>
                                                                </div>
                                                            @elseif($delivery === 'self')
                                                                <div class="wysiwyg">{!! config('db.orders.address_for_self_delivery') !!}</div>
                                                            @elseif($delivery === 'address')
                                                                <div class="control control--input">
                                                                    <div class="control__inner">
                                                                        <input class="control__field" type="text" name="{{ $delivery }}"  id="{{ $delivery }}" required>
                                                                        <label class="control__label" for="{{ $delivery }}">Введите адрес доставки</label>
                                                                    </div>
                                                                </div>
                                                            @elseif($delivery === 'other')
                                                                <div class="grid _mtb-xs">
                                                                    @foreach($restDeliveries ?? [] as $restDelivery => $restDeliveryName)
                                                                        <div class="gcell gcell--12 _ptb-xs">
                                                                            @component('site._widgets.radio.radio', [
                                                                                'classes' => '_color-gray4',
                                                                                'attributes' => [
                                                                                    'type' => 'radio',
                                                                                    'name' => 'other',
                                                                                    'value' => $restDeliveryName,
                                                                                    'checked' => $restDelivery,
                                                                                ]
                                                                            ])
                                                                                @lang($restDeliveryName)
                                                                            @endcomponent
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <label id="delivery-error" class="has-error _ml-md" for="delivery" style="display: none;"></label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="hint hint--lg _pl-md"><span>@lang('orders::general.payment-method')</span></div>
                                        <div class="grid _mtb-md _posr">
                                            @foreach($paymentMethods as $paymentMethod => $paymentMethodName)
                                                @if($paymentMethod !== \App\Modules\Orders\Models\Order::PAYMENT_LIQPAY || $showLiqpay)
                                                <div class="gcell gcell--12 _plr-md _ptb-xs">
                                                    @component('site._widgets.radio.radio', [
                                                        'rootAttrs' => 'data-related-for="payment-method"',
                                                        'classes' => '_color-gray4',
                                                        'attributes' => [
                                                            'type' => 'radio',
                                                            'name' => 'payment_method',
                                                            'value' => $paymentMethod,
                                                        ],
                                                    ])
                                                        @lang($paymentMethodName)
                                                    @endcomponent
                                                </div>
                                                @endif
                                            @endforeach
                                            <label id="payment_method-error" class="has-error _ml-md" for="payment_method" style="display: none;"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--textarea">
                                        <div class="control__inner">
                                            <textarea rows="5" class="control__field" type="text" name="comment" id="profile-comment"></textarea>
                                            <label class="control__label" for="profile-comment">@lang('orders::site.add-comment')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="grid _justify-center _items-center _nm-md">
                                        <div class="gcell gcell--auto _flex-noshrink _p-md">
                                            @component('site._widgets.checker.checker', [
                                                'classes' => '_color-gray4',
                                                'attributes' => [
                                                    'type' => 'checkbox',
                                                    'name' => 'do_not_call_me',
                                                    'checked' => false,
                                                    'value' => 1,
                                                ]
                                            ])
                                                @lang('orders::general.do-not-call-me')
                                            @endcomponent
                                        </div>
                                        <div class="gcell gcell--auto _flex-grow _p-md _text-center">
                                            <div style="font-size: 12px;">* {!! trans('orders::site.delivery-price') !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__footer">
                            <div class="grid _justify-center">
                                <div class="gcell gcell--12 gcell--sm-8 _text-center">
                                    <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                        <span class="button__body">
                                            <span class="button__text">@lang('orders::site.approve')</span>
                                        </span>
                                    </button>
                                    <div class="_mt-lg">
                                        <div style="font-size: 12px;">@lang('orders::site.accept')</div>
                                        <div><a target="_blank" href="{{ config('db.basic.agreement_link') }}" class="link link--sm _color-main">@lang('orders::site.agreement')</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
