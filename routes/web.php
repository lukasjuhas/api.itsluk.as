<?php

Route::get('/', [
    'uses' => 'Api\GeneralController@index',
    'as' => 'general.index'
]);

Route::get('/recent-photos', [
    'uses' => 'Api\RecentPhotosController@index',
    'as' => 'recentphotos.index'
]);
