<?php

use Illuminate\Support\Facades\Route;

Route::get('sitemap', ['as' => 'site.sitemap', 'uses' => 'SitemapController@index']);
Route::get('sitemap.xml', ['as' => 'site.sitemap.xml', 'uses' => 'SitemapController@indexXml']);
Route::get('images_sitemap.xml', ['as' => 'site.images.sitemap.xml', 'uses' => 'SitemapController@imagesXml']);
