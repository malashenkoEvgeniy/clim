@php
    /** @var \App\Modules\Orders\Models\Order $order */
@endphp

@extends('site._layouts.checkout')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container container--def">
            <div class="box box--gap">
                <div class="grid _justify-between _items-center _nml-def">
                    <div class="gcell _pl-def">
                        <h1 class="title title--size-h1">
                            @lang('orders::site.thank-you')
                        </h1>
                    </div>
                    <div class="gcell _pl-def">
                        <button class="button button--air" data-print="container">
                        <span class="button__body">
                            {!! SiteHelpers\SvgSpritemap::get('icon-print', [
                            'class' => 'button__icon button__icon--before'
                            ]) !!}
                            <span class="button__text">@lang('orders::general.print-order')</span>
                        </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="box print-container">
                <div class="container container--md _ptb-def">
                    <div class="title title--size-h2 _text-center">@lang('orders::general.order-id')
                        : {{ $order->id }}</div>

                    <div class="grid _justify-center _nm-md _pb-xl">
                        @foreach($order->items as $item)
                            <div class="gcell _p-md">
                                {!! Widget::show('products::image', $item->product_id, 'small', [
                                    'width' => 60,
                                ]) !!}
                            </div>
                        @endforeach
                    </div>

                    <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                        <div
                            class="gcell _flex-noshrink  _plr-xs _color-black">@lang('validation.attributes.created_at')</div>
                        <div class="gcell _xxs-text-right _plr-xs">{{ $order->created_at->format('d.m.Y') }}</div>
                    </div>

                    <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                        <div
                            class="gcell _flex-noshrink  _plr-xs _color-black">@lang('orders::general.delivery-address')</div>
                        <div class="gcell _xxs-text-right _plr-xs">{{ $order->city }}
                            , {{ $order->delivery_address }}</div>
                    </div>
                    @if($order->payment_method)
                        <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                            <div
                                class="gcell _flex-noshrink  _plr-xs _color-black">@lang('orders::general.payment-method')</div>
                            <div
                                class="gcell _xxs-text-right _plr-xs">@lang("orders::general.payment-methods.{$order->payment_method}")</div>
                        </div>
                    @endif
                    @if($order->delivery)
                        <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                            <div
                                class="gcell _flex-noshrink  _plr-xs _color-black">@lang('orders::general.delivery-type')</div>
                            <div
                                class="gcell _xxs-text-right _plr-xs">@lang("orders::general.deliveries.{$order->delivery}")</div>
                        </div>
                    @endif
                    <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                        <div class="gcell _flex-noshrink  _plr-xs _color-black">@lang('orders::general.receiver')</div>
                        <div class="gcell _xxs-text-right _plr-xs">{{ $order->client->name }}
                            , {{ $order->client->phone }}</div>
                    </div>

                    <div class="separator _color-gray4 _mtb-xl"></div>

                    <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                        <div class="gcell _flex-noshrink  _plr-xs">
                            <div class="title title--size-h3">@lang('orders::general.all-items-cost')</div>
                        </div>
                        <div class="gcell _xxs-text-right _plr-xs">{{ $order->total_amount }}</div>
                    </div>
                    <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                        <div class="gcell _flex-noshrink  _plr-xs">
                            <div class="title title--size-h3">@lang('orders::general.delivery')</div>
                        </div>
                        <div
                            class="gcell _xxs-text-right _plr-xs">@lang('orders::general.by-delivery-service-tariff')</div>
                    </div>

                    <div class="separator _color-gray4 _mtb-xl"></div>

                    <div class="grid _xxs-flex-nowrap _justify-between _nmlr-xs _mb-md">
                        <div class="gcell _flex-noshrink  _plr-xs">
                            @lang('orders::general.total-to-pay')
                        </div>
                        <div class="gcell _xxs-text-right _plr-xs">
                            <div class="title title--size-h3">
                                {{ $order->total_amount }}
                            </div>
                        </div>
                    </div>

                    <div class="separator _color-gray4 _mtb-xl _no-print"></div>

                    <div class="grid _justify-center _no-print _nml-def">
                        <div class="gcell _pl-def">
                            <a href="{{ route('site.home') }}"
                               class="button button--theme-main button--size-normal button--width-full">
                            <span class="button__body">
                                <span class="button__text">@lang('orders::general.back-main')</span>
                            </span>
                            </a>
                        </div>
                        @if(Auth::user())
                            <div class="gcell _pl-def">
                                <a href="{{ route('site.account.orders') }}"
                                   class="button button--theme-main button--size-normal button--width-full">
                                <span class="button__body">
                                    <span class="button__text">@lang('orders::general.back-to-orders')</span>
                                </span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
