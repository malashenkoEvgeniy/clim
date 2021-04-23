<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:translates'])->group(function () {
    // Admins list in admin panel
    Route::get('translates/{place}', ['uses' => 'IndexController@index','as' => 'admin.translates.index'])
        ->where('place', 'site|admin|general');
    Route::get('translates/{place}/{module}', ['uses' => 'IndexController@index','as' => 'admin.translates.module'])
        ->where('place', 'site|admin|general');
    Route::post('translates/{place}/update', ['uses' => 'IndexController@update','as' => 'admin.translates.update'])
        ->where('place', 'site|admin|general');
    Route::get('translates/list', ['uses' => 'IndexController@list','as' => 'admin.translates.list']);
});

// Routes for unauthenticated administrators


