<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:subscribe'])->group(function () {
    // Subscription mechanism
    Route::get('subscribe', ['uses' => 'SubscribeController@mailing', 'as' => 'admin.subscribe.mailing']);
    Route::post('subscribe/send', ['uses' => 'SubscribeController@send', 'as' => 'admin.subscribe.send']);
    Route::get('subscribe/history', ['uses' => 'SubscribeController@history', 'as' => 'admin.subscribe.history']);
});
Route::middleware(['auth:admin', 'permission:subscribers'])->group(function () {
    Route::put('subscribers/{subscriber}/active', ['uses' => 'SubscribersController@active', 'as' => 'admin.subscribers.active']);
    Route::get('subscribers/{subscriber}/destroy', ['uses' => 'SubscribersController@destroy', 'as' => 'admin.subscribers.destroy']);
    Route::resource('subscribers', 'SubscribersController')->except('show', 'destroy')->names('admin.subscribers');
});
