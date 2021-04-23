<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:news'])->group(function () {
    // Admins list in admin panel
    Route::put('news/{news}/active', ['uses' => 'NewsController@active', 'as' => 'admin.news.active']);
    Route::get(
        'news/{news}/avatar/delete',
        ['uses' => 'NewsController@deleteImage', 'as' => 'admin.news.delete-avatar']
    );
    Route::get('news/{news}/destroy', ['uses' => 'NewsController@destroy', 'as' => 'admin.news.destroy']);
    Route::resource('news', 'NewsController')->except('show', 'destroy')->names('admin.news');
});
