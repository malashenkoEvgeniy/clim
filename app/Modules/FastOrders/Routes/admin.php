<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:fast_orders'])->group(function () {
    // Admins list in admin panel
    Route::put('fast-orders/{fastOrder}/active', ['uses' => 'FastOrdersController@active', 'as' => 'admin.fast_orders.active']);
    Route::get('fast-orders/{fastOrder}/destroy', ['uses' => 'FastOrdersController@destroy', 'as' => 'admin.fast_orders.destroy']);
    Route::resource('fast-orders', 'FastOrdersController')
        ->except('show', 'destroy', 'store', 'create')
        ->names('admin.fast_orders');
});
