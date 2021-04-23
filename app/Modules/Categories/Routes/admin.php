<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:categories'])->group(function () {
    Route::put('catalog/categories/{category}/active', [
        'uses' => 'CategoryController@active',
        'as' => 'admin.categories.active',
    ]);
    Route::put('catalog/categories/sortable', [
        'uses' => 'CategoryController@sortable',
        'as' => 'admin.categories.sortable',
    ]);
    Route::get('catalog/categories/{category}/destroy', [
        'uses' => 'CategoryController@destroy',
        'as' => 'admin.categories.destroy',
    ]);
    Route::resource('catalog/categories', 'CategoryController')
        ->except('show', 'destroy')
        ->names('admin.categories');
});

// Routes for unauthenticated administrators
