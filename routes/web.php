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
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->group(['prefix' => 'products'],function () use ($router) {
        $router->get('/',['uses' => 'ProductController@index', 'as' => 'getAllProducts']);
        $router->post('/create',['uses' => 'ProductController@create', 'as' => 'createProduct']);
        $router->patch('/{id}',['uses' => 'ProductController@update', 'as' => 'updateProduct']);
        $router->delete('/{id}',['uses' => 'ProductController@destroy', 'as' => 'deleteProduct']);
    });

    $router->group(['prefix' => 'users'],function () use ($router) {
        $router->get('/',['uses' => 'userController@index', 'as' => 'getAllUsers']);
        $router->post('/create',['uses' => 'userController@create', 'as' => 'createUser']);
        $router->patch('/{id}',['uses' => 'userController@update', 'as' => 'updateUser']);
        $router->delete('/{id}',['uses' => 'userController@destroy', 'as' => 'deleteUser']);
    });

    $router->group(['prefix' => 'categories'],function () use ($router) {
        $router->get('/',['uses' => 'CategoryController@index', 'as' => 'getAllCategories']);
        $router->post('/create',['uses' => 'CategoryController@create', 'as' => 'createCategory']);
        $router->patch('/{id}',['uses' => 'CategoryController@update', 'as' => 'updateCategory']);
        $router->delete('/{id}',['uses' => 'CategoryController@destroy', 'as' => 'deleteCategory']);
    });

});
