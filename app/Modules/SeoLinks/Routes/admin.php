<?php
use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:seo_links'])->group(function () {
    // Admins list in admin panel
    Route::put('seo-links/{seoLink}/active', ['uses' => 'SeoLinksController@active', 'as' => 'admin.seo_links.active']);
    Route::get('seo-links/{seoLink}/destroy',
        ['uses' => 'SeoLinksController@destroy', 'as' => 'admin.seo_links.destroy']);
    Route::resource('seo-links', 'SeoLinksController')
        ->except('show', 'destroy')
        ->names('admin.seo_links');
});
