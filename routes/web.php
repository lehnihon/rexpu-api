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

use \App\Config;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('auth/login', 'AuthController@authenticate');


$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->post('auth/refresh', 'AuthController@refresh');
        $router->group(['prefix' => 'user'], function() use ($router) {
            $router->get('/','UserController@index');
            $router->post('/','UserController@store');
        });
        $router->group(['prefix' => 'subject'], function() use ($router) {
            $router->get('/','SubjectController@index');
            $router->post('/','SubjectController@store');
        });
        $router->group(['prefix' => 'suggestion'], function() use ($router) {
            $router->get('/','SuggestionController@index');
            $router->post('/','SuggestionController@store');
        });
        $router->group(['prefix' => 'ticket'], function() use ($router) {
            $router->get('/','TicketController@index');
            $router->post('/','TicketController@store');
            $router->get('/user/{id}','TicketController@showByUser');
        });
        $router->group(['prefix' => 'config'], function() use ($router) {
            $router->get('/','ConfigController@index');
            $router->put('/','ConfigController@update');
        });
    }
);
