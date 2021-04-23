<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:settings'])->group(function () {
    Route::get('settings/clear-cache', [
        'uses' => 'IndexController@clearCache',
        'as' => 'admin.settings.clear-cache',
    ]);
    Route::get('settings/nova-poshta', [
        'uses' => 'NovaPoshtaController@index',
        'as' => 'admin.settings.nova-poshta',
    ]);
    Route::put('settings/nova-poshta', [
        'uses' => 'NovaPoshtaController@update',
        'as' => 'admin.settings.nova-poshta',
    ]);
    Route::get('settings/logo', [
        'uses' => 'LogoController@index',
        'as' => 'admin.settings.logo',
    ]);
    Route::put('settings/logo', [
        'uses' => 'LogoController@update',
        'as' => 'admin.settings.update-logo',
    ]);
    Route::get('settings/logo/delete-logo', [
        'uses' => 'LogoController@deleteLogo',
        'as' => 'admin.settings.delete-logo',
    ]);
    Route::get('settings/logo/delete-logo-mobile', [
        'uses' => 'LogoController@deleteLogoMobile',
        'as' => 'admin.settings.delete-logo-mobile',
    ]);
    Route::get('settings/watermark', [
        'uses' => 'WatermarkController@index',
        'as' => 'admin.settings.watermark',
    ]);
    Route::put('settings/watermark', [
        'uses' => 'WatermarkController@update',
        'as' => 'admin.settings.update-watermark',
    ]);
    Route::get('settings/watermark/delete-watermark', [
        'uses' => 'WatermarkController@deleteWatermark',
        'as' => 'admin.settings.delete-watermark',
    ]);
    Route::get('settings/reviews', [
        'uses' => 'ReviewController@index',
        'as' => 'admin.settings.reviews',
    ]);
    Route::put('settings/reviews', [
        'uses' => 'ReviewController@update',
        'as' => 'admin.settings.update-reviews',
    ]);
    Route::get('settings/reviews/delete-background', [
        'uses' => 'ReviewController@deleteBackground',
        'as' => 'admin.settings.delete-reviews',
    ]);
    Route::get('settings/products_dictionary', [
        'uses' => '\App\Modules\ProductsDictionary\Controllers\Admin\IndexController@index',
        'as' => 'admin.settings.products_dictionary',
    ]);
    Route::put('settings/products_dictionary', [
        'uses' => '\App\Modules\ProductsDictionary\Controllers\Admin\IndexController@update',
        'as' => 'admin.settings.products_dictionary',
    ]);
    Route::get('settings/show-{group}', [
        'uses' => 'IndexController@show',
        'as' => 'admin.settings.show',
    ]);
    Route::get('settings/{group}', [
        'uses' => 'IndexController@group',
        'as' => 'admin.settings.group',
    ]);
    Route::put('settings/{group}', [
        'uses' => 'IndexController@update',
        'as' => 'admin.settings.update',
    ]);
    Route::get('settings', [
        'uses' => 'IndexController@index',
        'as' => 'admin.settings.index',
    ]);
});
