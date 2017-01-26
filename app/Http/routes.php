<?php

/**
 * General
 */
$app->get('/', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\GeneralController@index'
]);

/**
 * Dispatches
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'dispatches'], function($app)
{
    $app->get('/', [
        'uses' => 'Api\V1\DispatchesController@index'
    ]);

    $app->post('/', [
        'middleware' => 'auth',
        'uses' => 'Api\V1\DispatchesController@store'
    ]);

    $app->get('{id}', [
        'uses' => 'Api\V1\DispatchesController@show'
    ]);

    $app->get('{dispatchId}/tags', [
        'uses' => 'Api\V1\TagsController@index'
    ]);
});

/**
 * Tags
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'tags'], function($app)
{
    $app->get('/', [
        'uses' => 'Api\V1\TagsController@index'
    ]);

    $app->post('/', [
        'middleware' => 'auth',
        'uses' => 'Api\V1\TagsController@store'
    ]);

    $app->get('{id}', [
        'uses' => 'Api\V1\TagsController@show'
    ]);
});

/**
 * Records
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'records'], function($app)
{
    $app->get('/', [
        'uses' => 'Api\V1\RecordsController@index'
    ]);

    $app->get('page', function () {
        return redirect('/records');
    });

    $app->get('page/{page}', 'Api\V1\RecordsController@page');
});