<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('demo-access/admin', ['uses' => 'DemoController@index', 'as' => 'admin.demo']);
