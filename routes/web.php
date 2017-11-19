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

Route::get('/', 'BlogController@index');
Route::get('/article/{id}', 'BlogController@view');
Route::get('/article/edit/{id}', 'BlogController@edit')->middleware('auth');
Route::post('/article/save', 'BlogController@save')->middleware('auth');
Route::match(['get', 'post'], '/category/add', 'CategoryController@add')->middleware('auth');
Route::match(['get', 'post'], '/category/edit/{id}', 'CategoryController@edit')->middleware('auth');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
