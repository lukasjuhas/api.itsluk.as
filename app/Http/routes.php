<?php
/**
 * General
 */
$app->get('/', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\GeneralController@index'
]);

/**
 * Key Generator
 */
$app->get('/key', function() {
    return str_random(32);
});

/**
 * Trips
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'trips'], function ($app) {
    $app->get('/', [
        'uses' => 'Api\V1\TripsController@index'
    ]);

    $app->post('/', [
        'middleware' => 'auth',
        'uses' => 'Api\V1\TripsController@store'
    ]);

    $app->get('{slug}', [
        'uses' => 'Api\V1\TripsController@show'
    ]);

    $app->patch('{slug}', [
        'uses' => 'Api\V1\TripsController@update'
    ]);
});

/**
 * Dispatches
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'photos'], function ($app) {
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
});

/**
 * Tags
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'tags'], function ($app) {
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
 * Photos
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'photos'], function ($app) {
    $app->get('/', [
        'uses' => 'Api\V1\PhotosController@index'
    ]);

    $app->post('/', [
        'middleware' => 'auth',
        'uses' => 'Api\V1\PhotosController@store'
    ]);

    $app->get('{id}', [
        'uses' => 'Api\V1\PhotosController@show'
    ]);
});

/**
 * Records
 */
$app->group(['middleware' => 'throttle:60', 'prefix' => 'records'], function ($app) {
    $app->get('/', [
        'uses' => 'Api\V1\RecordsController@index'
    ]);

    $app->get('page', function () {
        return redirect('/records');
    });

    $app->get('page/{page}', 'Api\V1\RecordsController@page');
});
