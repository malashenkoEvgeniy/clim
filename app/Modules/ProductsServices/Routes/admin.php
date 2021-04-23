<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:products_services'])->group(function () {
    // Groups
    Route::put('products-services/{service}/active', [
        'uses' => 'IndexController@active',
        'as' => 'admin.products-services.active',
    ]);
    Route::put('products-services/sortable', [
        'uses' => 'IndexController@sortable',
        'as' => 'admin.products-services.sortable',
    ]);
    Route::get('products-services/{service}/destroy', [
        'uses' => 'IndexController@destroy',
        'as' => 'admin.products-services.destroy',
    ]);
    Route::resource('products-services', 'IndexController')
        ->except('show', 'destroy')
        ->names('admin.products-services');
});

// Routes for unauthenticated administrators
