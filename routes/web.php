<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomepageController@index');

Route::resource('image', 'ImageController');

Route::get('product/category/with-inactive', 'ProductCategoryController@indexWtihInactive');
Route::resource('product/category', 'ProductCategoryController');
Route::get('product/upload', 'ProductController@upload');
Route::post('product/upload', "ProductController@processUpload");
Route::resource('product', 'ProductController');
Route::get('product', 'ProductCategoryController@index');

Route::get('/settings/homepage', 'HomepageController@editSettings');
Route::post('/settings/homepage', 'HomepageController@updateSettings');

Route::get('/webadmin', 'WebadminController@index');
