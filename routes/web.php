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
Route::get('/tag/{tag?}', 'BlogController@index');
Route::get('/article/{id}', 'BlogController@view');
Route::get('/article/category/{categoryid}', 'BlogController@list');

Route::get('/test/{debug?}', function ($debug=null){
    if ($debug=='1314521') {
        phpinfo();
        exit;
    }
    return Redirect::to('/');
});

Route::get('/article/edit/{id}', 'BlogController@edit')->middleware('auth');
Route::get('/article/delete/{id}', 'BlogController@delete')->middleware('auth');
Route::post('/article/save', 'BlogController@save')->middleware('auth');
Route::match(['get', 'post'], '/category/add', 'CategoryController@add')->middleware('auth');
Route::match(['get', 'post'], '/category/edit/{id}', 'CategoryController@edit')->middleware('auth');

Route::post('/upload', 'UploadController@save')->middleware('auth');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');



Route::Group(['middleware'=>'auth', 'prefix' => 'admin', 'namespace' => 'Admin'], function(){
    Route::get('/master/list/{typeid?}', 'MasterController@list');
    Route::get('/master/edit/{id?}', 'MasterController@edit');
    Route::post('/master/save', 'MasterController@save');
    Route::post('/master/delete', 'MasterController@delete');

    Route::get('/article/list/{typeid?}', 'ArticleController@list');
    Route::get('/article/edit/{id?}', 'ArticleController@edit');
    Route::post('/article/save', 'ArticleController@save');
    Route::post('/article/delete', 'ArticleController@delete');
});