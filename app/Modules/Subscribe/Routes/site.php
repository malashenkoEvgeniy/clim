<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::post('subscribe/send', [
    'as' => 'site.subscribe',
    'uses' => 'SubscribersController@send',
]);
