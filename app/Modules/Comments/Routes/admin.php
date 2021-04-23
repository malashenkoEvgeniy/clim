<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:comments'])->group(
    function () {
        // Admins list in admin panel
        Route::get('comments/{type}/{comment}/edit', ['uses' => 'CommentsController@edit', 'as' => 'admin.comments.edit']);
        Route::post('comments/{type}', ['uses' => 'CommentsController@store', 'as' => 'admin.comments.store']);
        Route::get('comments/{type}', ['uses' => 'CommentsController@index', 'as' => 'admin.comments.index']);
        Route::get('comments/{type}/create', ['uses' => 'CommentsController@create', 'as' => 'admin.comments.create']);
        Route::put('comments/{comment}/active', ['uses' => 'CommentsController@active', 'as' => 'admin.comments.active']);
        Route::get('comments/{type}/{comment}/destroy', ['uses' => 'CommentsController@destroy', 'as' => 'admin.comments.destroy']);
        Route::put('comments/{type}/{comment}', ['uses' => 'CommentsController@update', 'as' => 'admin.comments.update']);
    }
);

// Routes for unauthenticated administrators
