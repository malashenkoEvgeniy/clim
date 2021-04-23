<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:superadmin'])->group(function () {
    // Admins list in admin panel
    Route::get('notifications', [
        'as' => 'admin.notifications.index',
        'uses' => 'NotificationsController@index',
    ]);
});

// Routes for unauthenticated administrators