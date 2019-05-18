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
Route::middleware(['jwt.auth'])->group(function () {
    Route::resource('categories', 'CategoriesController')->except('create', 'edit');
    Route::resource('products', 'ProductsController')->except('create', 'edit');
    Route::resource('orders', 'OrdersController')->except('create', 'edit');
    Route::resource('order-products', 'OrderProductsController')->except('create', 'edit');
});
