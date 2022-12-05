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

// Route::post('register', 'Api\UserController@store');
Route::post('user/login', 'Api\UserController@login');

Route::get('user', 'Api\UserController@index');
Route::get('user/{id}', 'Api\UserController@show');
Route::post('user', 'Api\UserController@store');
Route::put('user/{id}', 'Api\UserController@update');


Route::get('note', 'Api\NoteController@index');
Route::get('note/{id}', 'Api\NoteController@show');
Route::post('note', 'Api\NoteController@store');
Route::put('note/{id}', 'Api\NoteController@update');
Route::delete('note/{id}', 'Api\NoteController@destroy');
// Route::group(['middleware' => 'auth:api'], function(){
//     Route::get('user', 'Api\UserController@index');
//     Route::get('user/{id}', 'Api\UserController@show');
//     Route::post('user', 'Api\UserController@store');
//     Route::put('user/{id}', 'Api\UserController@update');
// });

Route::get('buku', 'Api\BukuController@index');
Route::get('buku/{id}', 'Api\BukuController@show');
Route::post('buku', 'Api\BukuController@store');
Route::put('buku/{id}', 'Api\BukuController@update');
Route::delete('buku/{id}', 'Api\BukuController@destroy');

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    Route::post('logout', 'Api\AuthController@logout');
});
