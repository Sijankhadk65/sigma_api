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

$router->group(['prefix' => 'customer'], function () use ($router) {

    $router->get('/id/{id}', 'CustomerController@get');

    $router->get('/number/{num}', 'CustomerController@getFromContact');

    $router->post('/create', 'CustomerController@create');
});



$router->group(['prefix' => 'worker'], function () use ($router) {

    $router->get('/', 'WorkerController@get');

    $router->get('/{id}', 'WorkerController@get');

    $router->get('/center/{center_id}', 'WorkerController@getCenterWorkers');

    $router->post('/create', 'WorkerController@create');
});

$router->group(['prefix' => 'accounting'], function () use ($router) {

    $router->group(['prefix' => '/transaction'], function () use ($router) {

        $router->get('/', 'AccountController@getTransactions');

        $router->get('/{id}', 'AccountController@getTransactions');

        $router->post('/create', 'AccountController@createTransaction');

        $router->delete('/delete/{id}', 'AccountController@deleteTransaction');
    });

    $router->group(['prefix' => '/balance'], function () use ($router) {

        $router->get('/{id}', 'BalanceController@get');

        $router->post('/create', 'BalanceController@create');
    });
});

$router->group(['prefix' => 'user'], function () use ($router) {

    $router->post('/create', 'UserController@create');

    $router->post('/authenticate', 'UserController@authenticate');
});

$router->group(['prefix' => 'expense'], function () use ($router) {

    $router->post('/create', 'ExpenseController@create');

    $router->get('/', 'ExpenseController@get');

    $router->get('/{id}', 'ExpenseController@get');

    $router->delete('/delete/{id}', 'ExpenseController@delete');
});

$router->group(['prefix' => 'inventory'], function () use ($router) {

    $router->post('/sales/create', 'SalesController@create');

    $router->get('/sales/{id}', 'SalesController@get');

    $router->get('/salesItems/{id}', 'SalesController@getItems');

    $router->post('/stock/createItem', 'StockController@createStockItem');

    $router->post('/stock/createItemPhoto', 'StockController@uploadPhoto');

    $router->get('/stock/getItems/{id}', 'StockController@getStockItems');

    $router->delete('/stock/deleteItem/{id}', 'StockController@deleteStockItem');

    $router->put('/stock/updateItem/{id}', 'StockController@updateStockItem');
});

$router->get('/service_center', 'ServiceCenterController@get');

$router->get('/service_center/{id}', 'ServiceCenterController@get');
