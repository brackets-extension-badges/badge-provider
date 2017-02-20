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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/update/{secret}',['as' => 'update', 'uses' => 'DataController@update']);

$app->get('/{extensionId}/total.svg',['as' => 'badge', 'uses' => 'BadgeController@getBadge', 'method' => 'total']);
