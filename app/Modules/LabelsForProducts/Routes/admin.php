<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:labels'])->group(function () {
    Route::put('catalog/labels/{label}/active', [
        'uses' => 'IndexController@active',
        'as' => 'admin.product-labels.active',
    ]);
    Route::put('catalog/labels/sortable', [
        'uses' => 'IndexController@sortable',
        'as' => 'admin.product-labels.sortable',
    ]);
    Route::get('catalog/labels/{label}/destroy', [
        'uses' => 'IndexController@destroy',
        'as' => 'admin.product-labels.destroy',
    ]);
    Route::resource('catalog/labels', 'IndexController')
        ->except('show', 'destroy')
        ->names('admin.product-labels');
});

// Routes for unauthenticated administrators


