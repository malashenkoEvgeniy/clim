@php
/** @var \App\Modules\Orders\Components\Cart\Cart $cart */
/** @var string $totalAmount */
@endphp

@if($cart->getTotalQuantity() > 0)
    <div class="cart-briefly">
        <div class="cart-briefly__info">
            <div>{!! trans_choice('orders::site.in-the-cart', $cart->getTotalQuantity()) !!}</div>
            <div>
                @lang('orders::site.in-the-cart-amount')
                <strong>{{ $totalAmount }}</strong>
            </div>
        </div>
        <div class="cart-briefly__actions">
            <div data-cart-open-prevent>{!! Widget::show('orders::checkout-button') !!}</div>
            <div>
                <button class="button button--air _mt-def js-init" data-cart-trigger="open">
                    <span class="button__body">
                        <span class="button__text">@lang('orders::site.edit')</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
@else
    <div class="grid _flex-nowrap">
        <div class="gcell gcell--auto _flex-noshrink _pr-def">
            {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                'class' => 'svg-icon svg-icon--icon-shopping',
            ]) !!}
        </div>
        <div class="gcell gcell--auto _flex-grow">
            <div class="title title--size-h3">@lang('orders::site.cart-is-empty')</div>
            @if(Auth::check())
                <div>@lang('orders::site.cart-is-empty-message')</div>
            @else
                <div>{!! __('orders::site.cart-is-empty-message-not-authorized') !!}</div>
            @endif
        </div>
    </div>
@endif
