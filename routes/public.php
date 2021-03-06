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

$app->group(['prefix' => 'public'], function () use ($app) {
    $app->get('/', function () use ($app) {
        return [
            "app" => config('app.name'),
            "version" => config('app.version'),
            "config-app" => config('app'),
            "config-email" => config('mail'),
            "config-services" => config('services'),
            "config-database" => config('database')
        ];
    });

    $app->post('/auth', 'AuthController@login');
    $app->post('/auth/register', 'AuthController@register');

    $app->post('/contact', 'ContactController@send');
});
