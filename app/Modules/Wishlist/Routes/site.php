<?php

use Illuminate\Support\Facades\Route;

Route::paginate('wishlist', [
    'as' => 'site.wishlist',
    'uses' => 'IndexController@index',
]);

Route::post('wishlist', [
    'as' => 'site.wishlist.toggle',
    'uses' => 'AjaxController@toggle',
]);