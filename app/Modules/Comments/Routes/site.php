<?php

use Illuminate\Support\Facades\Route;

Route::post('comment/create', [
    'uses' => 'AjaxController@create',
    'as' => 'site.comments.create',
]);

Route::post('comments/{type}/{id}', [
    'uses' => 'AjaxController@products',
    'as' => 'site.comments.index',
]);
