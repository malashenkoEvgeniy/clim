@extends('site._layouts.account')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Мои заказы')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('account-content')
    <div class="account account--orders">
        <div class="grid">
            <div class="gcell gcell--12">
                @if(config('mock.orders', false))
                    <div class="grid _items-center _justify-between _p-lg" style="border-bottom: 1px solid #f2f2f2;">
                        <div class="gcell gcell--auto">
                            <div class="title title--size-h2">Мои заказы</div>
                        </div>
                        <div class="gcell gcell--auto">
                            @include('site._widgets.pager.pager', [
                                'mod_classes' => 'pager--orders pager--right-aligned',
                            ])
                        </div>
                    </div>
                    <div class="grid">
                        @foreach(config('mock.orders', []) as $order)
                            <div class="gcell gcell--12">
                                @include('site._widgets.order-item.order-item', [
                                    'data' => $order
                                ])
                            </div>
                        @endforeach
                    </div>
                    <div class="grid _items-center _justify-between _p-lg">
                        {{--<div class="gcell gcell--auto"></div>--}}
                        <div class="gcell gcell--auto _ml-auto">
                            @include('site._widgets.pager.pager', [
                                'mod_classes' => 'pager--orders pager--right-aligned',
                            ])
                        </div>
                    </div>
                @else
                    <div class="title title--size-h2 _plr-lg _pt-lg _pb-sm _m-none">Мои заказы</div>
                    <div class="_plr-lg _pt-sm _pb-lg">Ваша история заказов пока пуста.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
