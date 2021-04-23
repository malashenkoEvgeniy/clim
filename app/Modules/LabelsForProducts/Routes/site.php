<?php

use Illuminate\Support\Facades\Route;

Route::paginate('products-{slug}', [
    'as' => 'site.products-by-labels',
    'uses' => 'IndexController@index',
]);