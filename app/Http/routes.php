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
    return redirect(env('HOME_PAGE'));
});

$app->get('/update/{secret}', ['as' => 'update', 'uses' => 'DataController@update']);

$app->get('/{extensionId}/{method}.svg', ['as' => 'badge', 'uses' => 'BadgeController@getBadge']);
$app->get('/{extensionId}/stats.json', ['as' => 'stats', 'uses' => 'BadgeController@getStats']);

$app->get('/list.json', function () {
    if (!\Illuminate\Support\Facades\Storage::exists('list.json')) {
        return '{}';
    }
    return \Illuminate\Support\Facades\Storage::get('list.json');
});
