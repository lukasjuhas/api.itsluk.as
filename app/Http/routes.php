<?php
/**
 * General
 */
$router->get('/', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\GeneralController@index'
]);

$router->get('/instagram', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\GeneralController@getRecentInstagramPosts'
]);

$router->get('/spotify', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\RecordsController@spotify'
]);

$router->get('/spotify/callback', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\RecordsController@spotifyCallback'
]);

$router->get('/auth', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\UserController@authenticate',
]);

$router->post('/login', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\AuthController@login'
]);

$router->post('/logout', [
    'middleware' => 'throttle:60',
    'uses' => 'Api\V1\AuthController@logout'
]);

$router->post('/reset-password', [
    'uses' => 'Api\V1\AuthController@resetPassword',
]);

$router->post('/validate-password-token', [
    'uses' => 'Api\V1\AuthController@validateResetPassword',
]);

$router->post('/new-password', [
    'uses' => 'Api\V1\AuthController@newPassword',
]);

/**
 * Key Generator
 */
$router->get('/key', function () {
    return str_random(32);
});

/**
 * Trips
 */
$router->group(['middleware' => 'throttle:60', 'prefix' => 'trips'], function ($router) {
    $router->get('/', [
        'uses' => 'Api\V1\TripsController@index'
    ]);

    $router->post('/', [
        'middleware' => 'jwt.auth',
        'uses' => 'Api\V1\TripsController@store'
    ]);

    $router->get('{slug}', [
        'uses' => 'Api\V1\TripsController@show'
    ]);

    $router->put('{slug}', [
        'uses' => 'Api\V1\TripsController@update'
    ]);

    $router->put('{slug}/order', [
        'uses' => 'Api\V1\PhotosController@updateOrder'
    ]);

    $router->put('{slug}/update-feature', [
        'uses' => 'Api\V1\TripsController@updateFeature'
    ]);
});

/**
 * Dispatches
 */
$router->group(['middleware' => 'throttle:60', 'prefix' => 'photos'], function ($router) {
    $router->get('/', [
        'uses' => 'Api\V1\DispatchesController@index'
    ]);

    $router->post('/', [
        'middleware' => 'jwt.auth',
        'uses' => 'Api\V1\DispatchesController@store'
    ]);

    $router->get('{id}', [
        'uses' => 'Api\V1\DispatchesController@show'
    ]);
});

/**
 * Tags
 */
$router->group(['middleware' => 'throttle:60', 'prefix' => 'tags'], function ($router) {
    $router->get('/', [
        'uses' => 'Api\V1\TagsController@index'
    ]);

    $router->post('/', [
        'middleware' => 'jwt.auth',
        'uses' => 'Api\V1\TagsController@store'
    ]);

    $router->get('{id}', [
        'uses' => 'Api\V1\TagsController@show'
    ]);
});

/**
 * Photos
 */
$router->group(['middleware' => 'throttle:60', 'prefix' => 'photos'], function ($router) {
    $router->get('/', [
        'uses' => 'Api\V1\PhotosController@index'
    ]);

    $router->post('/', [
        'middleware' => 'jwt.auth',
        'uses' => 'Api\V1\PhotosController@store'
    ]);

    $router->get('{id}', [
        'uses' => 'Api\V1\PhotosController@show'
    ]);

    $router->put('{id}', [
        'middleware' => 'jwt.auth',
        'uses' => 'Api\V1\PhotosController@update'
    ]);

    $router->delete('{id}', [
        'middleware' => 'jwt.auth',
        'uses' => 'Api\V1\PhotosController@delete'
    ]);

    $router->post('generatePreviews', [
        'middleware' => 'jwt.auth',
        'uses' => 'Api\V1\PhotosController@generatePreviews'
    ]);
});

/**
 * Records
 */
$router->group(['middleware' => 'throttle:60', 'prefix' => 'records'], function ($router) {
    $router->get('/', [
        'uses' => 'Api\V1\RecordsController@index'
    ]);

    $router->get('/{release}', [
        'uses' => 'Api\V1\RecordsController@getRelease'
    ]);

    $router->get('page/{page}', function () {
        return redirect('/records?=page={page}');
    });
});
