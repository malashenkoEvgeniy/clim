<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin'])->group(function () {
    Route::post('images', ['as' => 'admin.images.index', 'uses' => 'IndexController@index']);
    Route::post('images/create', ['as' => 'admin.images.store', 'uses' => 'IndexController@store']);
    Route::post('images/delete', ['as' => 'admin.images.delete', 'uses' => 'IndexController@deleteByPost']);
    Route::post('images/sortable', ['as' => 'admin.images.sortable', 'uses' => 'IndexController@sortable']);

    Route::middleware(['permission:images'])->group(function () {
        Route::get('images/{image}', ['as' => 'admin.images.edit', 'uses' => 'IndexController@edit']);
        Route::put('images/{image}', ['as' => 'admin.images.update', 'uses' => 'IndexController@update']);
    });
    
    Route::get('images/{image}/destroy', ['as' => 'admin.images.destroy', 'uses' => 'IndexController@destroy']);
    
    Route::middleware(['permission:crop'])->group(function () {
        Route::get('crop/{crop}', ['as' => 'admin.crop.index', 'uses' => 'CropController@index']);
        Route::put('crop/{crop}', ['as' => 'admin.crop.update', 'uses' => 'CropController@update']);
    });
});
