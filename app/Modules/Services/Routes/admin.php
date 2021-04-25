<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:services'])->group(
    function (){
        // Admins list in admin panel

        Route::put('services/{page}/active', ['uses' => 'ServicesController@active', 'as' => 'admin.services.active']);
        Route::put('services/sortable', ['uses' => 'ServicesController@sortable', 'as' => 'admin.services.sortable']);
        Route::get('services/{page}/destroy', ['uses' => 'ServicesController@destroy', 'as' => 'admin.services.destroy']);
        Route::resource('services', 'ServicesController')->except('show', 'destroy')->names('admin.services');

        Route::put('services_rubrics/{page}/active', ['uses' => 'ServicesRubricsController@active', 'as' => 'admin.services_rubrics.active']);
        Route::put('services_rubrics/sortable', ['uses' => 'ServicesRubricsController@sortable', 'as' => 'admin.services_rubrics.sortable']);
        Route::get('rubrics/{page}/destroy', ['uses' => 'ServicesRubricsController@destroy', 'as' => 'admin.services_rubrics.destroy']);

        Route::resource('rubrics', 'ServicesRubricsController')->except('show', 'destroy')->names('admin.services_rubrics');
    }
);

// Routes for unauthenticated administrators


