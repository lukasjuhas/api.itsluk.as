<?php

/**
 * General
 */
$app->get('/', [
    'uses' => 'Api\V1\GeneralController@index'
]);

/**
 * Dispatches
 */
$app->group(['prefix' => 'dispatches'], function($app)
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
$app->group(['prefix' => 'tags'], function($app)
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
$app->group(['prefix' => 'records'], function($app)
{
    $app->get('/', [
        'uses' => 'Api\V1\RecordsController@index'
    ]);

    $app->get('page', function () {
        return redirect('/records');
    });

    $app->get('page/{page}', 'Api\V1\RecordsController@page');
});
