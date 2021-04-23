<?php

use Illuminate\Support\Facades\Route;

// Routes for only authenticated administrators
Route::middleware(['auth:admin', 'permission:mail_templates'])->group(function () {
    // Admins list in admin panel
    Route::put('mail-templates/{mailTemplate}/active', [
        'uses' => 'MailTemplatesController@active',
        'as' => 'admin.mail_templates.active',
    ]);
    Route::resource('mail-templates', 'MailTemplatesController')->names('admin.mail_templates');
});

// Routes for unauthenticated administrators
