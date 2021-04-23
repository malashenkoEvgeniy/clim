<?php

use Illuminate\Support\Facades\Route;

Route::get('yandex_market.xml', ['as' => 'site.yandex_market.xml', 'uses' => 'YandexMarketController@indexXml']);
