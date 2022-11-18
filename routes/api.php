<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
//Route::post('login', 'Api\AuthController@login');

Route::get('user', 'Api\UserController@index');
Route::get('user/{id}', 'Api\UserController@show');
Route::post('user', 'Api\UserController@store');
Route::put('user/{id}', 'Api\UserController@update');

// Route::group(['middleware' => 'auth:api'], function(){
//     Route::get('user', 'Api\UserController@index');
//     Route::get('user/{id}', 'Api\UserController@show');
//     Route::post('user', 'Api\UserController@store');
//     Route::put('user/{id}', 'Api\UserController@update');
// });

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    Route::post('logout', 'Api\AuthController@logout');
});
