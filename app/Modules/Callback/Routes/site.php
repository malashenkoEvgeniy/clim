<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::post('callback/send', ['as' => 'callback-send', 'uses' => 'CallbackController@send']);