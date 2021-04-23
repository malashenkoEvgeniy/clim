@php
$currentRouteName = Route::currentRouteName();
@endphp
@if(in_array($currentRouteName, ['site.checkout', 'site.checkout.step-2']))
    {!! Widget::show('checkout-auth-popup') !!}
@else
    {!! Widget::show('auth-popup') !!}
@endif
{!! Widget::show('callback-popup') !!}
{!! Widget::show('consultation-popup') !!}
@include('site._widgets.popup.send-resume')
@include('site._widgets.popup.wishlist-confirm-mass-delete')
