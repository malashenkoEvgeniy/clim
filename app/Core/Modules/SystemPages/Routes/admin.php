<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:system_pages'])->group(function () {
    // Admins list in admin panel
    Route::resource('system_pages', 'SystemPagesController')
        ->only('index', 'edit', 'update')
        ->names('admin.system_pages');
});
