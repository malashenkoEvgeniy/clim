@php
/** @var \App\Modules\Orders\Types\OrderType $orderType */
/** @var string $content */
$information = [
    'orders::general.receiver' => $orderType->clientName,
    'orders::general.phone' => $orderType->clientPhone,
    'orders::general.email' => $orderType->clientEmail,
    'orders::general.payment-method' => trans('orders::general.payment-methods.' . $orderType->paymentMethod),
    'orders::general.delivery-type' => trans('orders::general.deliveries.' . $orderType->deliveryType),
    'orders::general.delivery-address' => $orderType->deliveryAddress,
];
@endphp

@extends('mail.layouts.main')

@section('header')
    {{ $subject }}
@stop

@section('subject')
    {{ $subject  }}
@stop

@section('content')
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background: url({{ site_media('static/pic/email-order-bg', true, false, true) }}) repeat-x bottom center #ededef ;border-top-left-radius: 10px; border-top-right-radius: 10px; padding: 15px; font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 13px;">
        <tr>
            <td>
                @foreach ($orderType->items as $item)
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #c8c8c8; padding: 10px 0">
                        {!! Widget::show('products::order-mail-item', $item->productId) !!}
                        <tr>
                            <td>
                                <table class="product-price" width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-top: 10px;">
                                    <tr>
                                        <td>{{ $item->formattedPrice() }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td style="text-align: right;"><b>{{ $item->formattedAmount() }}</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        {!! Widget::show('products_dictionary::mail-item', $item) !!}
                    </table>
                @endforeach
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 15px 0; font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 20px;">
                        <tr>
                            <td>@lang('orders::mail.total'):</td>
                            <td style="text-align: right;">{{ $orderType->formattedAmount() }}</td>
                        </tr>
                    </table>
            </td>
        </tr>

    </table>
@stop

@push('before-content')
    @if(strip_tags($content))
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0" border="0" style="font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 13px;">
                    <tbody>
                    <tr>
                        <td>
                            {!! $content !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    @endif
    <tr>
        <td style="padding-top: 20px;">
            <table width="100%" style="max-width: 320px; font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 13px; border-left: 2px solid #ffdb4b; padding: 0 15px; border-radius: 2px;">
                @foreach($information as $label => $value)
                    @if($value)
                        <tr>
                            <td>@lang($label):</td>
                            <td><b>{{ $value }}</b></td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </td>
    </tr>
@endpush
