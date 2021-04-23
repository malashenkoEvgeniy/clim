<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin'])->group(function () {
    Route::middleware(['permission:langs'])->group(function () {
        Route::get('languages/{language}/default', [
            'uses' => 'IndexController@defaultLanguage',
            'as' => 'admin.languages.default',
        ]);
        Route::get('languages', [
            'uses' => 'IndexController@index',
            'as' => 'admin.languages.index',
        ]);
    });
    Route::put('translit', [
        'uses' => 'AjaxController@translit',
        'as' => 'admin.translit',
    ]);
});
