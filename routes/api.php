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

$app->group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () use ($app) {
    $app->put('/auth', 'AuthController@refresh');
    $app->patch('/auth', 'AuthController@refresh');

    $app->delete('/auth', 'AuthController@logout');
    $app->get('/user', 'AuthController@currentUser');

    $app->put('/user/personal', 'UserController@updatePersonal');
    $app->put('/user/email', 'UserController@updateEmail');
    $app->put('/user/password', 'UserController@updatePassword');
    $app->put('/user/marketing', 'UserController@updateMarketing');
});
