<?php

use Illuminate\Support\Facades\Route;

Route::get('products/{slug}', [
    'as' => 'site.product',
    'uses' => 'ProductsController@index',
]);

Route::post('search', 'AjaxController@search');

Route::paginate('search', [
    'as' => 'site.search-products',
    'uses' => 'SearchController@index',
]);

Route::post('products/info/{type}', [
    'as' => 'site.product.info-popup',
    'uses' => 'AjaxController@infoPopup',
]);
