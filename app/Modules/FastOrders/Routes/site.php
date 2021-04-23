<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('fast-orders', ['as' => 'fast-orders', 'uses' => 'FastOrdersController@index']);
Route::post('fast-orders/send', ['as' => 'fast-orders-send', 'uses' => 'FastOrdersController@send']);
Route::post('fast-orders-popup/{productId}',['as' => 'fast-orders-popup', 'uses' => 'AjaxController@popup']);