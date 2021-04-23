<?php

use Illuminate\Support\Facades\Route;

Route::get('demo-access/user', ['uses' => 'Auth\DemoController@index', 'as' => 'site.demo']);

// Only guests
Route::middleware('guest')->group(function () {
    // Authorization block
    Route::get('login', ['uses' => 'Auth\LoginController@index', 'as' => 'site.login']);
    Route::post('login', 'Auth\LoginController@login');
    // Registration block
    Route::get('registration', ['uses' => 'Auth\RegisterController@showRegistrationForm', 'as' => 'site.register']);
    Route::post('registration', 'Auth\RegisterController@register');

    Route::get('password/reset', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm', 'as' => 'site.password.request']);
    Route::post('password/email', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail', 'as' => 'site.forgot-password']);
    Route::get('password/reset/{token}', ['uses' => 'Auth\ResetPasswordController@showResetForm', 'as' => 'site.password.reset']);
    Route::post('password/reset', ['uses' => 'Auth\ResetPasswordController@reset', 'as' => 'site.reset-password']);

});


// Only authenticated
Route::middleware('auth')->group(function () {
    Route::get('account', ['uses' => 'ProfileController@index', 'as' => 'site.account']);

    Route::get('account/edit', ['uses' => 'ProfileController@edit', 'as' => 'site.account.edit']);
    Route::put('account/edit', ['uses' => 'ProfileController@update', 'as' => 'site.account.update']);

    Route::get('account/change-password', ['uses' => 'ProfileController@password', 'as' => 'site.account.password']);
    Route::put('account/change-password', ['uses' => 'ProfileController@updatePassword', 'as' => 'site.account.update-password']);

    Route::get('account/change-phone', ['uses' => 'ProfileController@phone', 'as' => 'site.account.phone']);
    Route::put('account/change-phone', 'ProfileController@updatePhone');

    Route::post('no-csrf/link-social-network', [
        'uses' => 'SocialsController@link',
        'as' => 'site.link-social-network'
    ]);

    Route::get('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'site.logout']);
});
Route::get('social-login/{alias?}', ['uses' => 'Auth\LoginController@socialsLogin', 'as' => 'site.socials.login']);
Route::get('no-csrf/social-network/{alias?}', [
    'uses' => 'SocialsController@hub',
    'as' => 'site.social-network'
]);
Route::post('social-login/fill-information', ['uses' => 'SocialsController@socialsFillInfo', 'as' => 'site.socials.fill-info']);
Route::post('sms/send-code', ['uses' => 'AjaxController@sendSmsCode', 'as' => 'site.sms-code']);
