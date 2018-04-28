<?php

Route::get('/', [
    'uses' => 'Api\GeneralController@index',
    'as' => 'general.index'
]);
