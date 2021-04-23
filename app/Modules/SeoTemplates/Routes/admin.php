<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:seo_templates'])->group(function () {
    // Admins list in admin panel
    Route::resource('seo-templates', 'SeoTemplatesController')
        ->only('index', 'edit', 'update')
        ->names('admin.seo_templates');
});
