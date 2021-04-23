<?php

Route::get('/html/ui', function () {
    return view('site.ui.index');
})->name('ui');


Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return 'clear';
});