<?php

use Illuminate\Support\Facades\Route;

// Only guests
Route::middleware('guest:admin')->group(function () {
    // Authorization block
    Route::get('login', ['uses' => 'AuthController@index', 'as' => 'admin.login']);
    Route::post('login', 'AuthController@login');
});

// Only authenticated
Route::middleware('auth:admin')->group(function () {
    Route::middleware('permission:superadmin')->group(function () {
        // Admins list in admin panel
        Route::put('admins/{admin}/active', ['uses' => 'AdminsController@active', 'as' => 'admin.admins.active']);
        Route::get('admins/{admin}/destroy', ['uses' => 'AdminsController@destroy', 'as' => 'admin.admins.destroy']);
        Route::resource('admins', 'AdminsController')->except('show', 'destroy')->names('admin.admins');
        // Admin roles
        Route::put('roles/{role}/active', ['uses' => 'RolesController@active', 'as' => 'admin.roles.active']);
        Route::get('roles/{role}/destroy', ['uses' => 'RolesController@destroy', 'as' => 'admin.roles.destroy']);
        Route::resource('roles', 'RolesController')->except('show', 'destroy')->names('admin.roles');
    });
    // Admin account
    Route::get('account', ['uses' => 'AccountController@profile', 'as' => 'admin.account.view']);
    Route::put('account', ['uses' => 'AccountController@update', 'as' => 'admin.account.update']);
    Route::get('account/password', ['uses' => 'AccountController@password', 'as' => 'admin.account.password']);
    Route::put('account/password', ['uses' => 'AccountController@updatePassword', 'as' => 'admin.account.update-password']);
    Route::get('account/avatar', ['uses' => 'AccountController@avatar', 'as' => 'admin.account.avatar']);
    Route::put('account/avatar', ['uses' => 'AccountController@updateAvatar', 'as' => 'admin.account.update-avatar']);
    Route::get('account/avatar/delete', ['uses' => 'AccountController@deleteAvatar', 'as' => 'admin.account.delete-avatar']);
    // Logout
    Route::get('logout', ['uses' => 'AuthController@logout', 'as' => 'admin.logout']);
});
