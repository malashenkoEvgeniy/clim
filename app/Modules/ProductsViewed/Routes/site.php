<?php

use Illuminate\Support\Facades\Route;

Route::paginate('viewed-products', [
    'as' => 'site.viewed-products',
    'uses' => 'ViewedController@index',
]);
