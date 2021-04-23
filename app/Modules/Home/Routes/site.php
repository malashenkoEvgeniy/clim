<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@home')->name('site.home');