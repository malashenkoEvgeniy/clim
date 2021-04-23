<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:callback'])->group(
    function () {
        // Admins list in admin panel
        Route::put('callback/{callback}/active', ['uses' => 'CallbackController@active', 'as' => 'admin.callback.active']);
        Route::get('callback/{callback}/destroy', ['uses' => 'CallbackController@destroy', 'as' => 'admin.callback.destroy']);
        Route::resource('callback', 'CallbackController')
            ->except('show', 'destroy', 'create', 'store')
            ->names('admin.callback');
    }
);
