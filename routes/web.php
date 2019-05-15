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
        $router->group(['prefix' => 'cpm'], function() use ($router) {
            $router->get('/','CPMController@index');
            $router->post('/','CPMController@store');
            $router->get('/dashboard','CPMController@getLastCPM');
        });
        $router->group(['prefix' => 'user'], function() use ($router) {
            $router->get('/','UserController@index');
            $router->post('/','UserController@store');
            $router->post('/accepted/{id}','UserController@accepted');
            $router->post('/naccepted/{id}','UserController@notAccepted');
            $router->get('/accepted','UserController@toAccepted');
            $router->put('/','UserController@update');
            $router->get('/{id}','UserController@show');
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
            $router->get('/user/{id}','TicketController@getByUser');
        });
        $router->group(['prefix' => 'ticket-obs'], function() use ($router) {
            $router->post('/','TicketObsController@store');
            $router->get('/ticket/{id}','TicketObsController@getByTicket');
        });
        $router->group(['prefix' => 'asked-questions'], function() use ($router) {
            $router->get('/','AskedQuestionsController@index');
            $router->post('/','AskedQuestionsController@store');
        });
        $router->group(['prefix' => 'financial'], function() use ($router) {
            $router->get('/','FinancialController@index');
            $router->post('/','FinancialController@store');
            $router->post('/{id}','FinancialController@update');
            $router->get('/user/{id}','FinancialController@getByUser');
        });
        $router->group(['prefix' => 'general-config'], function() use ($router) {
            $router->get('/','GeneralConfigController@index');
            $router->put('/','GeneralConfigController@update');
        });
    }
);
