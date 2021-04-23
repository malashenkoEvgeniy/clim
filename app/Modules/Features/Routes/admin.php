<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin'])->group(function () {
    Route::middleware(['permission:features'])->group(function () {
        // Features
        Route::put('catalog/features/sortable', [
            'uses' => 'IndexController@sortable',
            'as' => 'admin.features.sortable',
        ]);
        Route::put('catalog/features/{feature}/active', [
            'uses' => 'IndexController@active',
            'as' => 'admin.features.active',
        ]);
        Route::get('catalog/features/{feature}/destroy', [
            'uses' => 'IndexController@destroy',
            'as' => 'admin.features.destroy',
        ]);
        Route::delete('catalog/features/{feature}/destroy', [
            'uses' => 'IndexController@destroyConfirmation',
        ]);
        Route::resource('catalog/features', 'IndexController')
            ->except('show', 'destroy')
            ->names('admin.features');

        Route::get('catalog/features/modal', [
            'uses' => 'AjaxController@showFeaturesModal',
            'as' => 'admin.features.show-modal'
        ]);
        Route::get('catalog/features/values-modal/{feature?}', [
            'uses' => 'AjaxController@showValuesModal',
            'as' => 'admin.features.show-values-modal'
        ]);
        Route::post('catalog/features/ajaxcreate', [
            'uses' => 'AjaxController@ajaxCreateFeature',
            'as' => 'admin.features.ajax-create',
        ]);
    });
    
    // Feature values
    Route::post('catalog/values/get', [
        'uses' => 'FeaturesValuesController@index',
        'as' => 'admin.feature-values.index',
    ]);
    Route::put('catalog/values/sortable', [
        'uses' => 'FeaturesValuesController@sortable',
        'as' => 'admin.feature-values.sortable',
    ]);
    Route::put('catalog/values/{value}/active', [
        'uses' => 'FeaturesValuesController@active',
        'as' => 'admin.feature-values.active',
    ]);
    Route::get('catalog/values/{value}/destroy', [
        'uses' => 'FeaturesValuesController@destroy',
        'as' => 'admin.feature-values.destroy',
    ]);
    Route::resource('catalog/features/{feature}/values', 'FeaturesValuesController')
        ->except('show', 'destroy', 'index')
        ->names('admin.feature-values');
});

// Routes for unauthenticated administrators
