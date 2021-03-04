<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login','App\Http\Controllers\AuthController@login');

Route::post('register','App\Http\Controllers\AuthController@register');

Route::post('forgotpassword','App\Http\Controllers\forgotController@forgotPassword');
Route::post('resetpassword','App\Http\Controllers\forgotController@resetPassword');

Route::get('user','App\Http\Controllers\userController@user')->middleware('auth:api');

Route::get('brand','App\Http\Controllers\BrandController@index');
Route::get('brand_find_by_id/{id}','App\Http\Controllers\BrandController@show');
Route::post('brand_store','App\Http\Controllers\BrandController@store');
Route::post('brand_update/{id}','App\Http\Controllers\BrandController@update');
Route::get('brand_destroy/{id}','App\Http\Controllers\BrandController@destroy');




