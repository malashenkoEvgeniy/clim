<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:currencies'])->group(function () {
    Route::get('catalog/currencies/{currency}/default-on-site', [
        'uses' => 'CurrenciesController@defaultOnSite',
        'as' => 'admin.currencies.default-on-site',
    ]);
    Route::get(
        'catalog/currencies/{currency}/default-in-admin-panel', [
            'uses' => 'CurrenciesController@defaultInAdminPanel',
            'as' => 'admin.currencies.default-in-admin-panel',
        ]
    );
    Route::resource('catalog/currencies', 'CurrenciesController')
        ->except('show', 'destroy', 'create', 'store')
        ->names('admin.currencies');
});

// Routes for unauthenticated administrators
