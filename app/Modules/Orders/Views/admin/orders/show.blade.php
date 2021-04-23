@php
    /** @var \App\Modules\Orders\Models\Order $order */
@endphp

@extends('admin.layouts.main')

@push('styles')
    <style>
        .loading {
            opacity: 0.25;
            cursor: not-allowed;
        }
    </style>
@endpush

@push('scripts')
    <script>
        window.jQuery(function ($) {
            $('#paid-toggle').on('click', function () {
                var $button = $(this), $text = $('#paid-block strong');
                $button.addClass('loading');
                $.ajax({
                    url: '{{ route('admin.ajax.toggle-paid', $order->id) }}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        '_method': 'put',
                    }
                }).done(function (data) {
                    var $i = $button.find('i');
                    $button.removeClass('loading');
                    if (data.success === true) {
                        if (data.paid === true) {
                            $button.removeClass('btn-success');
                            $button.addClass('btn-default');
                            $i.removeClass('fa-check');
                            $i.addClass('fa-close');
                            $text.removeClass('label-danger');
                            $text.addClass('label-success');
                            $text.text('{{ trans('orders::general.paid') }}');
                        } else {
                            $button.removeClass('btn-default');
                            $button.addClass('btn-success');
                            $i.removeClass('fa-close');
                            $i.addClass('fa-check');
                            $text.removeClass('label-success');
                            $text.addClass('label-danger');
                            $text.text('{{ trans('orders::general.not-paid') }}');
                        }
                    }
                });
            });
        });
    </script>
@endpush

@section('content')
    @if($order->do_not_call_me)
        <div class="pad margin no-print">
            <div class="callout callout-warning" style="margin-bottom: 0!important;">
                <h4><i class="fa fa-warning"></i> @lang('global.attention'):</h4>
                @lang('orders::general.do-not-call-to-me-message')
            </div>
        </div>
    @endif

    <div class="col-md-3">
        @include('orders::admin.orders.show-order-parts.buttons', ['order' => $order])
        @include('orders::admin.orders.show-order-parts.main-bar', ['order' => $order])
        {!! Widget::show('users::admin::order-page', $order->user_id) !!}
        {!!
            Html::link(
                route('admin.orders.index'),
                trans('orders::general.to-orders-list'), [
                    'class' => 'btn btn-flat btn-default btn-block',
                ]
            )
        !!}
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{empty($ttnActive) ? 'active' : ''}}"><a href="#invoice" data-toggle="tab">@lang('orders::general.invoice')</a>
                </li>
                <li><a href="#timeline" data-toggle="tab">@lang('orders::general.status-history')</a></li>
                @if($order->delivery === 'nova-poshta-self')
                    <li class="{{isset($ttnActive) ? 'active' : ''}}">
                        <a href="#ttn" id="click-ttn" data-toggle="tab">@lang('orders::general.ttn-generate')</a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="{{empty($ttnActive) ? 'active' : ''}} tab-pane" id="invoice">
                    @include('orders::admin.orders.show-order-parts.invoice', ['order' => $order])
                </div>
                <div class="tab-pane" id="timeline">
                    @include('orders::admin.orders.show-order-parts.timeline', ['order' => $order])
                </div>
                @if($order->delivery === 'nova-poshta-self')
                    <div class="{{isset($ttnActive) ? 'active' : ''}} tab-pane" id="ttn">
                        @if($order->ttn && $order->ttn_ref)
                            @include('orders::admin.orders.show-order-parts.print-ttn', ['order' => $order])
                        @else
                            @include('orders::admin.orders.show-order-parts.generate-ttn', ['order' => $order])
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
