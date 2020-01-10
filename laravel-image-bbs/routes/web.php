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

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', 'IndexController@test');
Route::get('index', 'IndexController@index');
Route::post('index/confirm', 'IndexController@confirm');
Route::post('index/success', 'IndexController@success');
Route::get('thread/{threadId}', 'ThreadController@thread');
Route::post('/thread/{threadId}/confirm', 'ThreadController@confirm');
Route::post('/thread/{threadId}/success', 'ThreadController@success');