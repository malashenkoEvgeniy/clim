<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:articles'])->group(
    function () {
        // Admins list in admin panel
        Route::put('articles/{article}/active', ['uses' => 'ArticlesController@active', 'as' => 'admin.articles.active']);
        Route::get(
            'articles/{article}/destroy',
            ['uses' => 'ArticlesController@destroy', 'as' => 'admin.articles.destroy']
        );
        Route::resource('articles', 'ArticlesController')->except('show', 'destroy')->names('admin.articles');
    }
);
