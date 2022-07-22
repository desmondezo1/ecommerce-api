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

        $router->post('/login',['uses' => 'AuthController@login', 'as' => 'login']);
        $router->get('/token-refresh',['uses' => 'AuthController@refresh', 'as' => 'refreshToken']);
        $router->post('/register',['uses' => 'AuthController@register', 'as' => 'register']);
        $router->get('/products',['uses' => 'ProductController@index', 'as' => 'getAllProducts']);
        $router->get('/product/{product_id}',['uses' => 'ProductController@getSingleProduct', 'as' => 'getSingleProducts']);
        $router->post('/product/downloadpdf',['uses' => 'ProductController@downloadPdf', 'as' => 'downloadProduct']);
        $router->get('/brands',['uses' => 'PartnerController@index', 'as' => 'getAllBrands']);
        $router->get('/categories',['uses' => 'CategoryController@index', 'as' => 'getAllCategories']);
        $router->get('/logout',['uses' => 'AuthController@logout', 'as' => 'logout']);

        $router->group(['prefix' => 'wishlist'],function () use ($router) {
            $router->get('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'getUserWishlist']);
            $router->post('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'addToUserWishlist']);
            $router->patch('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'updateUserWishlist']);
            $router->delete('/{user_id}/{product_id}', ['uses' => 'WishlistController@index', 'as' => 'deleteProductFromWishlist']);
            $router->delete('/{user_id}', ['uses' => 'WishlistController@index', 'as' => 'emptyUserWishlist']);
        });

        $router->group(['prefix' => 'orders'],function () use ($router) {
            $router->get('/{order_id}', ['uses' => 'OrderController@getOrder', 'as' => 'getSingleOrder']);
            $router->post('/', ['uses' => 'OrderController@create', 'as' => 'createOrder']);
            $router->delete('/{order_id}', ['uses' => 'OrderController@destroy', 'as' => 'deleteOder']);
        });

        $router->get('/payment/success/{trans_id}/{order_id}', ['uses' => 'PaymentsController@success', 'as' => 'paymentSuccess']);


        //Auth Middleware
        $router->group(['middleware' => 'auth'], function () use ($router){
            $router->patch('/order/{order_id}', ['uses' => 'OrderController@updateOrder', 'as' => 'updateOrders']);

            $router->post('/checkout', ['uses' => 'PaymentsController@checkout', 'as' => 'checkout']);

            $router->group(['prefix' => 'user'],function () use ($router) {
                $router->get('/{user_id}',['uses' => 'userController@getUser', 'as' => 'getUser']);
                $router->patch('/{id}',['uses' => 'userController@update', 'as' => 'updateUser']);
                $router->post('/{user_id}/billing-address',['uses' => 'userController@createBillingAddress', 'as' => 'createUserBilling']);
                $router->patch('/{user_id}/billing-address',['uses' => 'userController@updateBillingAddress', 'as' => 'updateUserBilling']);
                $router->get('/{user_id}/orders',['uses' => 'OrderController@getUserOrders', 'as' => 'getUserOrders']);
                $router->get('/{user_id}/orders/calculateShipping',['uses' => 'OrderController@calculateShippingFromWeight', 'as' => 'calculateShipping']);
                $router->get('/{user_id}/wishlist',['uses' => 'WishlistController@index', 'as' => 'getUserWishlist']);
                $router->post('/{user_id}/wishlist',['uses' => 'WishlistController@create', 'as' => 'addItemWishlist']);
                $router->delete('/{user_id}/wishlist',['uses' => 'WishlistController@destroy', 'as' => 'removeItemFromWishlist']);


                $router->group(['prefix' => 'cart'],function () use ($router) {
                    $router->get('/{user_id}', ['uses' => 'CartController@index', 'as' => 'getUserCart']);
                    $router->post('/', ['uses' => 'CartController@addItemToCart', 'as' => 'addToCart']);
                    $router->post('/bulk', ['uses' => 'CartController@addItemsToCart', 'as' => 'addManyToCart']);
                    $router->patch('/{user_id}/product/{product_id}', ['uses' => 'CartController@update', 'as' => 'updateProductQuantityInCart']);
                    $router->delete('/{user_id}/product/{product_id}', ['uses' => 'CartController@deleteItemFromCart', 'as' => 'deleteProductFromCart']);
                    $router->delete('/{user_id}', ['uses' => 'CartController@destroy', 'as' => 'emptyUserCart']);
                });
            });

            //ADMIN ROUTES
            $router->group(['prefix' => 'admin', 'middleware' => 'is_admin'], function () use ($router){

                //USERS
                $router->get('/users',['uses' => 'userController@index', 'as' => 'getAllUsers']);
                $router->get('/user/{user_id}',['uses' => 'userController@getUserAsAdmin', 'as' => 'getUserAsAdmin']);
                $router->get('/admins',['uses' => 'userController@getAdmins', 'as' => 'getAllAdminUsers']);
                $router->post('user/create',['uses' => 'userController@create', 'as' => 'createUser']);
                $router->delete('user/{id}',['uses' => 'userController@destroy', 'as' => 'deleteUser']);
                $router->patch('user/{user_id}',['uses' => 'userController@updateUserRole', 'as' => 'updateUserRole']);
                $router->patch('user/{user_id}/status',['uses' => 'userController@updateUserStatus', 'as' => 'updateUserStatus']);

                //ORDERS
                $router->get('/orders', ['uses' => 'OrderController@index', 'as' => 'getAllOrders']);
                $router->patch('/order/{order_id}', ['uses' => 'OrderController@updateOrder', 'as' => 'updateOrders']);

                //PRODUCTS
                $router->group(['prefix' => 'products'],function () use ($router) {
                    $router->post('/update/{id}',['uses' => 'ProductController@update', 'as' => 'updateProduct']);
                    $router->patch('/update/{id}/status',['uses' => 'ProductController@updateStatus', 'as' => 'updateStatus']);
                    $router->post('/create',['uses' => 'ProductController@create', 'as' => 'createProduct']);
                    $router->delete('/{id}',['uses' => 'ProductController@destroy', 'as' => 'deleteProduct']);
                    $router->delete('/image/{imageId}',['uses' => 'ProductController@deleteImage', 'as' => 'deleteProductImage']);
                });

                //BRANDS
                $router->group(['prefix' => 'brands'],function () use ($router) {
                    $router->patch('/{id}',['uses' => 'PartnerController@update', 'as' => 'updateBrand']);
                    $router->get('/',['uses' => 'PartnerController@adminIndex', 'as' => 'getAllBrandAdmin']);
                    $router->post('/create',['uses' => 'PartnerController@create', 'as' => 'createBrand']);
                    $router->delete('/{id}',['uses' => 'PartnerController@destroy', 'as' => 'deleteBrand']);
                });

                //CATEGORIES
                $router->group(['prefix' => 'categories'],function () use ($router) {
                    $router->post('/create',['uses' => 'CategoryController@create', 'as' => 'createCategory']);
                    $router->patch('/{id}',['uses' => 'CategoryController@update', 'as' => 'updateCategory']);
                    $router->delete('/{id}',['uses' => 'CategoryController@destroy', 'as' => 'deleteCategory']);
                });

            });

        });


    });
