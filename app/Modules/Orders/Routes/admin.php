<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:orders'])->group(function () {
    // Orders statuses
    Route::put('orders/statuses/sortable', [
        'uses' => 'OrdersStatusesController@sortable',
        'as' => 'admin.orders-statuses.sortable',
    ]);
    Route::get('orders/statuses/{status}/destroy', [
        'uses' => 'OrdersStatusesController@destroy',
        'as' => 'admin.orders-statuses.destroy',
    ]);
    Route::resource('orders/statuses', 'OrdersStatusesController')
        ->except('destroy', 'show')
        ->names('admin.orders-statuses');
    
    // Orders
    Route::get('orders/{order}/destroy', [
        'uses' => 'OrdersController@destroy',
        'as' => 'admin.orders.destroy',
    ]);
    Route::get('orders/{order}/add-item', [
        'uses' => 'OrdersController@addItem',
        'as' => 'admin.orders.add-item',
    ]);
    Route::post('orders/{order}/add-item', [
        'uses' => 'OrdersController@storeItem',
    ]);
    Route::put('orders/{item}/update-item', [
        'uses' => 'OrdersController@updateItem',
        'as' => 'admin.orders.update-item',
    ]);
    Route::get('orders/{item}/remove', [
        'uses' => 'OrdersController@removeItem',
        'as' => 'admin.orders.remove-item',
    ]);
    Route::get('orders/{order}/print', [
        'uses' => 'OrdersController@print',
        'as' => 'admin.orders.print',
    ]);
    Route::post('orders/{order}/change-status', [
        'uses' => 'OrdersController@status',
        'as' => 'admin.orders.status',
    ]);
    Route::post('orders/{order}/generate-ttn', [
        'uses' => 'OrdersController@createEN',
        'as' => 'admin.orders.generate-ttn',
    ]);
    Route::get('orders/{order}/print-ttn', [
        'uses' => 'OrdersController@generateLinkForEn',
        'as' => 'admin.orders.print-ttn',
    ]);
    Route::get('orders/{order}/get-status-ttn', [
        'uses' => 'OrdersController@documentsTracking',
        'as' => 'admin.orders.get-status-ttn',
    ]);
    Route::get('orders/{order}/delete-ttn', [
        'uses' => 'OrdersController@deleteTTN',
        'as' => 'admin.orders.delete-ttn',
    ]);
    Route::post('warehouses-for-city', [
        'as' => 'admin.warehouses.city',
        'uses' => 'AjaxController@getWarehousesForCity',
    ]);

    Route::get('orders/deleted', ['uses' => 'OrdersController@deleted', 'as' => 'admin.orders.deleted']);
    Route::get('orders/{order}/restore', ['uses' => 'OrdersController@restore', 'as' => 'admin.orders.restore']);
    Route::put('orders/{order}/toggle-paid', ['uses' => 'AjaxController@togglePaid', 'as' => 'admin.ajax.toggle-paid']);
    Route::resource('orders', 'OrdersController')
        ->except('destroy')
        ->names('admin.orders');
});

// Routes for unauthenticated administrators


