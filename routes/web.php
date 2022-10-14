<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'ticket'], function () use ($router) {

    $router->get('/', 'TicketController@get');

    $router->get('/{id}', 'TicketController@get');

    $router->post('/create', 'TicketController@create');

    $router->put('/update/{id}', 'TicketController@update');

    $router->delete('/delete/{id}', 'TicketController@delete');
});

$router->get('/issue/{id}', 'IssueController@get');

$router->get('/bill', 'BillController@get');

$router->get('/bill/{id}', 'BillController@get');

$router->get('/customer/{id}', 'CustomerController@get');

$router->group(['prefix' => 'worker'], function () use ($router) {

    $router->get('/', 'WorkerController@get');

    $router->get('/{id}', 'WorkerController@get');

    $router->post('/create', 'WorkerController@create');
});

$router->group(['prefix' => 'accounting'], function () use ($router) {
});

$router->get('/service_center', 'ServiceCenterController@get');

$router->get('/service_center/{id}', 'ServiceCenterController@get');
