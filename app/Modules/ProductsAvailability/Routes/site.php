<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('products-availability', ['as' => 'products-availability', 'uses' => 'IndexController@index']);
Route::post('products-availability/send', ['as' => 'products-availability-send', 'uses' => 'IndexController@send']);
Route::post('products-availability-popup/{productId}',['as' => 'products-availability-popup', 'uses' => 'AjaxController@popup']);
