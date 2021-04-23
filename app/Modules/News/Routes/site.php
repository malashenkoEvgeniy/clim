<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::paginate('news', ['as' => 'site.news', 'uses' => 'NewsController@index']);
Route::get('news/{slug}', ['as' => 'site.news-inner', 'uses' => 'NewsController@show']);
