<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:brands'])->group(function () {
    Route::put('catalog/brands/{brand}/active', ['uses' => 'IndexController@active', 'as' => 'admin.brands.active']);
    Route::get(
        'catalog/brands/{brand}/destroy',
        ['uses' => 'IndexController@destroy', 'as' => 'admin.brands.destroy']
    );
    Route::resource('catalog/brands', 'IndexController')
        ->except('show', 'destroy')
        ->names('admin.brands');
});

// Routes for unauthenticated administrators


