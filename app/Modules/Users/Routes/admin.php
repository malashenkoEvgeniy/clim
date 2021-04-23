<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:users'])->group(function () {
    // Users list in admin panel
    Route::put('users/{user}/active', ['uses' => 'UsersController@active', 'as' => 'admin.users.active']);
    Route::get('users/deleted', ['uses' => 'UsersController@deleted', 'as' => 'admin.users.deleted']);
    Route::get('users/{user}/restore', ['uses' => 'UsersController@restore', 'as' => 'admin.users.restore']);
    Route::get('users/{user}/destroy', ['uses' => 'UsersController@destroy', 'as' => 'admin.users.destroy']);
    Route::post('users/live-search', ['uses' => 'AjaxController@index', 'as' => 'admin.users.live-search']);
    Route::resource('users', 'UsersController')->except('destroy', 'show')->names('admin.users');
});
