<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::paginate('reviews', ['as' => 'site.reviews', 'uses' => 'ReviewsController@index']);
Route::post('review/send', ['as' => 'review-send', 'uses' => 'ReviewsController@send']);
