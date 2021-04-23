@php
/** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator|\App\Modules\Orders\Models\Order[] $orders */
@endphp

@extends('site._layouts.account')

@section('account-content')
    <div class="account account--orders">
        <div class="grid">
            <div class="gcell gcell--12">
                @if($orders->isNotEmpty())
                    <div class="grid _items-center _justify-between _p-lg" style="border-bottom: 1px solid #f2f2f2;">
                        <div class="gcell gcell--auto">
                            <div class="title title--size-h2">@lang('orders::site.my-orders')</div>
                        </div>
                        @if($orders->hasPages())
                            <div class="gcell gcell--auto">
                                {!! $orders->links('pagination.arrows') !!}
                            </div>
                        @endif
                    </div>
                    <div class="grid">
                        @foreach($orders as $order)
                            <div class="gcell gcell--12">
                                @include('orders::site.widgets.order-item.order-item', [
                                    'order' => $order,
                                ])
                            </div>
                        @endforeach
                    </div>
                    @if($orders->hasPages())
                        <div class="grid _items-center _justify-between _p-lg">
                            <div class="gcell gcell--auto _ml-auto">
                                {!! $orders->links('pagination.arrows') !!}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="title title--size-h2 _plr-lg _pt-lg _pb-sm _m-none">@lang('orders::site.my-orders')</div>
                    <div class="_plr-lg _pt-sm _pb-lg">@lang('orders::site.orders-history-is-empty')</div>
                @endif
            </div>
        </div>
    </div>
@stop