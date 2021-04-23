<?php

use Illuminate\Support\Facades\Route;

Route::get('checkout', [
    'as' => 'site.checkout',
    'uses' => 'CheckoutController@contactInformation',
]);

Route::post('checkout', 'CheckoutController@storeContactInformation');

Route::get('checkout/step-2', [
    'as' => 'site.checkout.step-2',
    'uses' => 'CheckoutController@deliveryAndPayment',
]);

Route::get('thank-you', ['as' => 'site.thank-you', 'uses' => 'ThankYouController@show']);

Route::post('checkout/step-2', 'CheckoutController@storeDeliveryAndPaymentInformation');

Route::post('location-suggest', [
    'as' => 'site.location.suggest',
    'uses' => 'CheckoutController@locationSuggest',
]);

Route::middleware('auth')->group(function () {
    Route::paginate('account/orders', [
        'as' => 'site.account.orders',
        'uses' => 'AccountController@index',
    ]);
    Route::get('print-order/{order}', ['as' => 'site.print', 'uses' => 'PrintController@show']);
});

Route::get('my-cart', ['as' => 'site.cart.index', 'uses' => 'Cart\IndexController@index']);

Route::get('cart', ['as' => 'site.ajax-cart', 'uses' => 'Cart\AjaxController@index']);
Route::post('cart', 'Cart\AjaxController@add');
Route::delete('cart', 'Cart\AjaxController@delete');
Route::put('cart', 'Cart\AjaxController@updateQuantity');
Route::patch('cart', 'Cart\AjaxController@updateDictionary');

Route::post('order/{order}/get-delivery-status', [
    'as' => 'site.orders.get-delivery-status',
    'uses' => 'AccountController@getDeliveryStatus',
]);

Route::get('order/{order}/liqpay', [
    'as' => 'site.orders.payment-liqpay',
    'uses' => 'LiqPayController@form',
]);
Route::post('no-csrf/liqpay', [
    'as' => 'site.orders.payment-liqpay-process',
    'uses' => 'LiqPayController@process',
]);
