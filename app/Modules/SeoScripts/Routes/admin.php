<?php
use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:seo_scripts'])->group(function () {
    // Admins list in admin panel
    Route::put('seo-scripts/{seoScript}/active', [
        'uses' => 'SeoScriptsController@active',
        'as' => 'admin.seo_scripts.active',
    ]);
    Route::get('seo-scripts/{seoScript}/destroy', [
        'uses' => 'SeoScriptsController@destroy',
        'as' => 'admin.seo_scripts.destroy',
    ]);
    Route::resource('seo-scripts', 'SeoScriptsController')
        ->except('show', 'destroy')
        ->names('admin.seo_scripts');
});
