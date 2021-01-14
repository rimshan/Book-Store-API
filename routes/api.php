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

Route::group(['prefix'=>'auth',  ['middleware' => 'cors']], function(){
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout')->middleware(['auth:api']);
});

Route::group(['prefix'=>'admin/auth'], function(){
    Route::post('login', 'Admin\AuthController@login');
    Route::get('logout', 'Admin\Auth\AdminAuthController@logout')->middleware(['multiauth:admin']);
});

Route::get('user', 'UserController@get')->middleware([ 'multiauth:admin,api']);
Route::get('users', 'UserController@getUsers')->middleware([ 'multiauth:admin']);
Route::put('user/{id}', 'UserController@updateUserById')->middleware([ 'multiauth:admin,api']);

Route::post('book', 'BookController@create')->middleware(['auth:api']);
Route::get('books', 'BookController@getUserBooks')->middleware(['auth:api']);
Route::get('books-all', 'BookController@getAllBooks');
Route::put('book/{id}', 'BookController@updateBook')->middleware(['auth:api']);