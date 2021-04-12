<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testController;
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
Route::group(['middleware'=>'auth:api'], function (){

});

//Login
Route::post('login','App\Http\Controllers\LoginController@login');

//get all users
Route::get('users','App\Http\Controllers\UserController@index');
//get one user base on id
Route::get('users/{id}','App\Http\Controllers\UserController@show');
//create user
Route::post('users','App\Http\Controllers\UserController@store');
//update user id
Route::post('users/{id}','App\Http\Controllers\UserController@update');


Route::get('data','App\Http\Controllers\UserController@getData');
//pagination for table users
Route::get('pagination/{num_page}','App\Http\Controllers\UserController@pagination');
//search
Route::get('search','App\Http\Controllers\UserController@search');
//delete user id
Route::delete('users/{id}','App\Http\Controllers\UserController@destroy');


