<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('{slug}', [
    'as' => 'site.page',
    'uses' => 'IndexController@page',
]);