<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:reviews'])->group(
    function () {
        // Admins list in admin panel
        Route::put('reviews/{review}/active', ['uses' => 'ReviewsController@active', 'as' => 'admin.reviews.active']);
        Route::get('reviews/{review}/destroy', ['uses' => 'ReviewsController@destroy', 'as' => 'admin.reviews.destroy']);
        Route::resource('reviews', 'ReviewsController')->except('show', 'destroy')->names('admin.reviews');
    }
);
