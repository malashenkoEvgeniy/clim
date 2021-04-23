<?php

use Illuminate\Support\Facades\Route;

Route::paginate('compare', [
    'as' => 'site.compare',
    'uses' => 'IndexController@index',
]);

Route::paginate('compare/{slug}', [
    'as' => 'site.compare.category',
    'uses' => 'IndexController@show',
]);

Route::get('compare/toggle/{product_id}', [
    'as' => 'site.compare.toggle',
    'uses' => 'AjaxController@toggle',
]);