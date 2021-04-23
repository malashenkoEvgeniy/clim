<?php

use Illuminate\Support\Facades\Route;

// Only authenticated
Route::middleware(['auth:admin', 'permission:site_menu'])->group(
    function () {
        // Admins list in admin panel
        Route::get(
            'site-menu/{place}/{siteMenu}/edit',
            ['uses' => 'SiteMenuController@edit', 'as' => 'admin.site_menu.edit']
        );
        Route::post(
            'site-menu/{place}',
            ['uses' => 'SiteMenuController@store', 'as' => 'admin.site_menu.store']
        );
        Route::get(
            'site-menu/{place}',
            ['uses' => 'SiteMenuController@index', 'as' => 'admin.site_menu.index']
        );
        Route::get(
            'site-menu/{place}/create',
            ['uses' => 'SiteMenuController@create', 'as' => 'admin.site_menu.create']
        );
        Route::put(
            'site-menu/{siteMenu}/active',
            ['uses' => 'SiteMenuController@active', 'as' => 'admin.site_menu.active']
        );
        Route::get(
            'site-menu/{place}/{siteMenu}/destroy',
            ['uses' => 'SiteMenuController@destroy', 'as' => 'admin.site_menu.destroy']
        );
        Route::put(
            'site-menu/{place}/sortable',
            ['uses' => 'SiteMenuController@sortable', 'as' => 'admin.site_menu.sortable']
        );
        Route::put(
            'site-menu/{place}/{siteMenu}',
            ['uses' => 'SiteMenuController@update', 'as' => 'admin.site_menu.update']
        );
    }
);
