<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Auth
Route::post('login','App\Http\Controllers\AuthController@login');
Route::post('register','App\Http\Controllers\AuthController@register');
Route::post('forgotpassword','App\Http\Controllers\forgotController@forgotPassword');
Route::post('resetpassword','App\Http\Controllers\forgotController@resetPassword');
Route::get('user','App\Http\Controllers\userController@user')->middleware('auth:api');
//Brand
Route::get('brand','App\Http\Controllers\BrandController@index');
Route::get('brand_find_by_id/{id}','App\Http\Controllers\BrandController@show');
Route::post('brand_store','App\Http\Controllers\BrandController@store');
Route::post('brand_update/{id}','App\Http\Controllers\BrandController@update');
Route::get('brand_destroy/{id}','App\Http\Controllers\BrandController@destroy');
//Category
Route::get('category','App\Http\Controllers\CategorysController@index');
Route::get('category_find_by_id/{id}','App\Http\Controllers\CategorysController@show');
Route::post('category_store','App\Http\Controllers\CategorysController@store');
Route::post('category_update/{id}','App\Http\Controllers\CategorysController@update');
Route::get('category_destroy/{id}','App\Http\Controllers\CategorysController@destroy');
//subCategory
Route::get('subcategory','App\Http\Controllers\SubcategorysController@index');
Route::get('subcategory_find_by_id/{id}','App\Http\Controllers\SubcategorysController@show');
Route::post('subcategory_store','App\Http\Controllers\SubcategorysController@store');
Route::post('subcategory_update/{id}','App\Http\Controllers\SubcategorysController@update');
Route::get('subcategory_destroy/{id}','App\Http\Controllers\SubcategorysController@destroy');




