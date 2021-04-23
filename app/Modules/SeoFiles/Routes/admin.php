<?php
use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:seo_files'])->group(function () {
    // Admins list in admin panel
    Route::get('seo-files/{seoFile}/destroy', [
        'uses' => 'SeoFilesController@destroy',
        'as' => 'admin.seo_files.destroy',
    ]);
    Route::resource('seo-files', 'SeoFilesController')
        ->except('show', 'destroy')
        ->names('admin.seo_files');
});
