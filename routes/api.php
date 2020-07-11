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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('employee', 'API\UserController@employee');
    Route::get('employee/{id}', 'API\UserController@employee');
    Route::post('create', 'API\UserController@createEmployee');
    Route::put('update/{id}', 'API\UserController@updateEmployee');
    Route::delete('delete/{id}', 'API\UserController@deleteEmployee');
    Route::post('details', 'API\UserController@details');
});