<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:products_availability'])->group(function () {
    // Admins list in admin panel
    Route::put('products-availability/{productsAvailability}/active', ['uses' => 'IndexController@active', 'as' => 'admin.products_availability.active']);
    Route::get('products-availability/{productsAvailability}/destroy', ['uses' => 'IndexController@destroy', 'as' => 'admin.products_availability.destroy']);
    Route::resource('products-availability', 'IndexController')
        ->except('show', 'destroy', 'store', 'create')
        ->names('admin.products_availability');
});
