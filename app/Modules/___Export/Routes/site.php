<?php


Route::get('google_feed.xml', ['as' => 'site.gm_feed.xml', 'uses' => 'GMFeedController@indexXml']);
