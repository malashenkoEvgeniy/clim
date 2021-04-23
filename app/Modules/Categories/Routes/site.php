<?php

use Illuminate\Support\Facades\Route;

Route::paginate('categories', [
    'as' => 'site.categories',
    'uses' => 'CategoryController@index',
]);

Route::paginate('category/{slug}', [
    'as' => 'site.category',
    'uses' => 'CategoryController@show',
]);
