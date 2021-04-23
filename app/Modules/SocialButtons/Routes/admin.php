<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:social_buttons'])->group(function () {
    // Admins list in admin panel

});

// Routes for unauthenticated administrators


