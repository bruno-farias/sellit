<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::middleware(['jwt.auth', 'cors'])->group(function () {
    Route::resource('categories', 'CategoriesController')->except('create', 'edit');
    Route::resource('products', 'ProductsController')->except('create', 'edit');
    Route::resource('orders', 'OrdersController')->except('create', 'edit');
    Route::resource('order-products', 'OrderProductsController')->only('store', 'update', 'destroy');
    Route::get('users/role', 'UsersController@getUsersByRoles');
    Route::get('users', 'UsersController@index');
});
