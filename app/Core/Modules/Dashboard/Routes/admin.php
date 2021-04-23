<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware('auth:admin')->group(function () {
    // Dashboard in admin panel
    Route::get('/', ['uses' => 'IndexController@index', 'as' => 'admin.dashboard']);
});
