<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:slideshow_simple'])->group(function () {
    // Admins list in admin panel
    Route::put(
        'slideshow-simple/sortable',
        ['uses' => 'SlideshowSimpleController@sortable', 'as' => 'admin.slideshow_simple.sortable']
    );
    Route::put('slideshow-simple/{slideshowSimple}/active', ['uses' => 'SlideshowSimpleController@active', 'as' => 'admin.slideshow_simple.active']);
    Route::get('slideshow-simple/{slideshowSimple}/avatar/delete', ['uses' => 'SlideshowSimpleController@deleteImage', 'as' => 'admin.slideshow_simple.delete-avatar']);
    Route::get('slideshow-simple/{slideshowSimple}/destroy', ['uses' => 'SlideshowSimpleController@destroy', 'as' => 'admin.slideshow_simple.destroy']);
    Route::resource('slideshow-simple', 'SlideshowSimpleController')->except('show', 'destroy')->names('admin.slideshow_simple');
});
