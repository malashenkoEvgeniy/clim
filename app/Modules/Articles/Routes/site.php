<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::paginate('articles', ['as' => 'site.articles', 'uses' => 'ArticlesController@index']);
Route::get('articles/{slug}', ['as' => 'site.articles-inner', 'uses' => 'ArticlesController@show']);
