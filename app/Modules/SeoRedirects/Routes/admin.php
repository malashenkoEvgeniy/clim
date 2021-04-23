<?php
use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:SeoRedirects'])->group(function () {
    // Admins list in admin panel
    Route::put('seo-redirects/{seoRedirect}/active', ['uses' => 'SeoRedirectsController@active', 'as' => 'admin.seo_redirects.active']);
    Route::get('seo-redirects/{seoRedirect}/destroy',
        ['uses' => 'SeoRedirectsController@destroy', 'as' => 'admin.seo_redirects.destroy']);
    Route::resource('seo-redirects', 'SeoRedirectsController')
        ->except('show', 'destroy')
        ->names('admin.seo_redirects');
});

// Routes for unauthenticated administrators
