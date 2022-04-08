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

    $router->group(['prefix' => 'categories'],function () use ($router) {
        $router->get('/',['uses' => 'CategoryController@index', 'as' => 'getAllCategories']);
        $router->post('/create',['uses' => 'CategoryController@create', 'as' => 'createCategory']);
        $router->patch('/{id}',['uses' => 'CategoryController@update', 'as' => 'updateCategory']);
        $router->delete('/{id}',['uses' => 'CategoryController@destroy', 'as' => 'deleteCategory']);
    });

    $router->get('/users',['uses' => 'userController@index', 'as' => 'getAllUsers']);
    $router->group(['prefix' => 'user'],function () use ($router) {
        $router->post('/create',['uses' => 'userController@create', 'as' => 'createUser']);
        $router->patch('/{id}',['uses' => 'userController@update', 'as' => 'updateUser']);
        $router->delete('/{id}',['uses' => 'userController@destroy', 'as' => 'deleteUser']);

        $router->group(['prefix' => 'cart'],function () use ($router) {
            $router->get('/{user_id}', ['uses' => 'CartController@index', 'as' => 'getUserCart']);
            $router->post('/', ['uses' => 'CartController@addItemToCart', 'as' => 'addToCart']);
            $router->patch('/{user_id}', ['uses' => 'CartController@index', 'as' => 'updateUserCart']);
            $router->delete('/{user_id}/{product_id}', ['uses' => 'CartController@index', 'as' => 'deleteProductFromCart']);
            $router->delete('/{user_id}', ['uses' => 'CartController@index', 'as' => 'emptyUserCart']);
        });

        $router->group(['prefix' => 'wishlist'],function () use ($router) {
            $router->get('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'getUserWishlist']);
            $router->post('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'addToUserWishlist']);
            $router->patch('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'updateUserWishlist']);
            $router->delete('/{user_id}/{product_id}', ['uses' => 'WishlistController@index', 'as' => 'deleteProductFromWishlist']);
            $router->delete('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'emptyUserWishlist']);
        });

        $router->group(['prefix' => 'orders'],function () use ($router) {
            $router->get('/{user_id}', ['uses' => 'OrdersController@index', 'as' => 'getUserOrders']);
            $router->post('/{user_id}', ['uses' => 'OrdersController@index', 'as' => 'addToUserOrders']);
            $router->patch('/{user_id}', ['uses' => 'OrdersController@index', 'as' => 'updateUserOrders']);
            $router->delete('/{user_id}/{product_id}', ['uses' => 'OrdersController@index', 'as' => 'deleteProductFromOrders']);
            $router->delete('/{user_id}', ['uses' => 'OrdersController@index', 'as' => 'emptyUserOrders']);
        });

    });


});
