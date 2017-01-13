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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('/', [
        'uses'=> 'App\Http\Controllers\Api\V1\GeneralController@index'
    ]);

    $api->get('/vinyls', 'App\Http\Controllers\VinylsController@index');

    $api->get('/vinyls/page', function () {
        return redirect('/vinyls');
    });

    $api->get('/vinyls/page/{page}', 'App\Http\Controllers\VinylsController@page');
});
