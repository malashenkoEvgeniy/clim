<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:consultations'])->group(
    function () {
        // Admins list in admin panel
        Route::put('consultation/{consultation}/active', ['uses' => 'ConsultationController@active', 'as' => 'admin.consultations.active']);
        Route::get('consultation/{consultation}/destroy', ['uses' => 'ConsultationController@destroy', 'as' => 'admin.consultations.destroy']);
        Route::resource('consultation', 'ConsultationController')
            ->except('show', 'destroy', 'create', 'store')
            ->names('admin.consultations');
    }
);
