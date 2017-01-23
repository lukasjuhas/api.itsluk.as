<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $app->get('/', function () use ($app) {
//     return redirect('v1');
//     // return $app->version();
// });

// $api = app('Dingo\Api\Routing\Router');
//
// $api->version('v1', function ($api) {
//     $api->get('/', [
//         'uses'=> 'App\Http\Controllers\Api\V1\GeneralController@index'
//     ]);
//
//     $api->get('/vinyls', 'App\Http\Controllers\VinylsController@index');
//
//     $api->get('/vinyls/page', function () {
//         return redirect('/vinyls');
//     });
//
//     $api->get('/vinyls/page/{page}', 'App\Http\Controllers\VinylsController@page');
// });

$app->get('/', [
    'uses' => 'Api\V1\GeneralController@index'
]);

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
