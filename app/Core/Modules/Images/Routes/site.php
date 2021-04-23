<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('images/cache/{size}/{image}', ['uses' => 'IndexController@image', 'as' => 'site.image.cache']);
