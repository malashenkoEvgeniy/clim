@php
/** @var \App\Modules\Orders\Components\Cart $cart */
$section = Auth::check() ? 'account-content' : 'layout-body';
$layout = Auth::check() ? 'site._layouts.account' : 'site._layouts.main';
@endphp

@extends($layout)

@section($section)
    <div class="section {{ Auth::check() ? null : '_mb-lg' }}">
        <div class="container">
            <style>
                #do-not-show-close-button [data-cart-trigger="close"] {
                    display: none;
                }
            </style>
            <div class="box" data-cart-container="detailed" id="do-not-show-close-button">
                @if($cart->getTotalQuantity() > 0)
                    @include('orders::site.cart.cart--detailed', [
                        'cart' => $cart,
                        'totalAmount' => Widget::show('products::amount', Cart::getQuantities()),
                        'totalAmountOld' => Widget::show('products::amount-old', Cart::getQuantities()),
                    ])
                @else
                    @include('orders::site.cart.cart--detailed-empty', [
                        'cart' => $cart,
                    ])
                @endif
            </div>
        </div>
    </div>
@endsection
