<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('services', ['as' => 'site.services', 'uses' => 'ServicesController@index']);
Route::get('services/{url}', ['as' => 'site.service', 'uses' => 'ServicesController@item']);