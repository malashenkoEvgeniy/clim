<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:import'])->group(function () {
    Route::get('catalog/import/check-status', [
        'uses' => 'IndexController@status',
        'as' => 'admin.import.check-status',
    ]);
    
    Route::get('catalog/import', [
        'uses' => 'IndexController@index',
        'as' => 'admin.import.index',
    ]);
    
    Route::post('catalog/import', [
        'uses' => 'IndexController@store',
        'as' => 'admin.import.store',
    ]);
});

