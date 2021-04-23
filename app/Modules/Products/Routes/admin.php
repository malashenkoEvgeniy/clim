<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:products'])->group(function () {
    // Groups
    Route::post('catalog/groups/live-search', [
        'uses' => 'AjaxController@groups',
        'as' => 'admin.groups.live-search',
    ]);
    Route::put('catalog/groups/{group}/active', [
        'uses' => 'GroupsController@active',
        'as' => 'admin.groups.active',
    ]);
    Route::get('catalog/groups/{group}/destroy', [
        'uses' => 'GroupsController@destroy',
        'as' => 'admin.groups.destroy',
    ]);
    Route::get('catalog/groups/{group}/clone', [
        'uses' => 'GroupsController@cloneGroup',
        'as' => 'admin.groups.clone',
    ]);
    Route::post('catalog/groups/{group}/edit', [
        'uses' => 'AjaxController@linkFeatureValueToGroup',
        'as' => 'admin.groups.link-feature-value',
    ]);
    Route::get('catalog/groups/{group}/change-feature', [
        'uses' => 'GroupsController@changeFeature',
        'as' => 'admin.groups.change-feature',
    ]);
    Route::put('catalog/groups/{group}/change-feature', [
        'uses' => 'GroupsController@changeFeatureConfirmation',
    ]);
    Route::resource('catalog/groups', 'GroupsController')
        ->except('show', 'destroy')
        ->names('admin.groups');
    
    // Products
    Route::get('catalog/products/{product}/destroy', [
        'uses' => 'ProductsController@destroy',
        'as' => 'admin.products.destroy',
    ]);
    Route::get('catalog/products/{product}/set-as-main', [
        'uses' => 'ProductsController@setAsMain',
        'as' => 'admin.products.main',
    ]);
    Route::post('catalog/products/{product}/clone', [
        'uses' => 'ProductsController@cloneProduct',
        'as' => 'admin.products.clone',
    ]);
    Route::get('catalog/products/images/{image}/delete', [
        'uses' => 'ProductsController@deleteImage',
        'as' => 'admin.products.delete-image',
    ]);
    Route::resource('catalog/products', 'ProductsController')
        ->only('edit', 'create', 'index')
        ->names('admin.products');
    
    // Groups Related
    Route::post('catalog/groups/{group}/add-related', [
        'as' => 'admin.groups.add-related',
        'uses' => 'GroupRelatedController@store',
    ]);
    Route::get('catalog/groups/{group}/remove-related/{item}', [
        'uses' => 'GroupRelatedController@destroy',
        'as' => 'admin.groups.remove-related',
    ]);
});

// Routes for unauthenticated administrators
