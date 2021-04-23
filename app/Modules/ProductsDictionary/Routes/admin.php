<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:products_dictionary'])->group(function () {
    Route::post('products_dictionary/update-product-relation', [
        'uses' => 'AjaxController@updateRelations',
        'as' => 'admin.dictionary.update-relations',
    ]);
    Route::post('settings/products_dictionary/get', [
        'uses' => 'DictionaryController@index',
        'as' => 'admin.dictionary.index',
    ]);
    Route::put('settings/products_dictionary/sortable', [
        'uses' => 'DictionaryController@sortable',
        'as' => 'admin.dictionary.sortable',
    ]);
    Route::put('settings/products_dictionary/values/{value}/edit', [
        'uses' => 'DictionaryController@edit',
        'as' => 'admin.dictionary.active',
    ]);
    Route::put('settings/products_dictionary/{value}/active', [
        'uses' => 'DictionaryController@active',
        'as' => 'admin.dictionary.active',
    ]);
    Route::get('settings/products_dictionary/{value}/destroy', [
        'uses' => 'DictionaryController@destroy',
        'as' => 'admin.dictionary.destroy',
    ]);
    Route::resource('settings/products_dictionary/values', 'DictionaryController')
        ->except('show', 'destroy', 'index')
        ->names('admin.dictionary');
});

// Routes for unauthenticated administrators


