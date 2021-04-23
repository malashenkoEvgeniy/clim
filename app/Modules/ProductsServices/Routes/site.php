<?php

use Illuminate\Support\Facades\Route;

Route::post('products-services/{service}/info-popup', [
    'uses' => 'IndexController@info',
    'as' => 'site.products-services.info-popup',
]);
