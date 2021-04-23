<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:pages'])->group(
    function () {
        // Admins list in admin panel
        Route::put('pages/{page}/active', ['uses' => 'PagesController@active', 'as' => 'admin.pages.active']);
        Route::put('pages/sortable', ['uses' => 'PagesController@sortable', 'as' => 'admin.pages.sortable']);
        Route::get('pages/{page}/destroy', ['uses' => 'PagesController@destroy', 'as' => 'admin.pages.destroy']);
        Route::resource('pages', 'PagesController')->except('show', 'destroy')->names('admin.pages');
    }
);
