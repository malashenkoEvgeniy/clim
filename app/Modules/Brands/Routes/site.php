<?php

use Illuminate\Support\Facades\Route;

Route::paginate('brands/{slug}', [
    'as' => 'site.brands.show',
    'uses' => 'IndexController@show',
]);
