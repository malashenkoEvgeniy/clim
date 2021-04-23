<?php

use Illuminate\Support\Facades\Route;

// Frontend routes
Route::post('consultations/send', ['as' => 'consultation-send', 'uses' => 'ConsultationController@send']);