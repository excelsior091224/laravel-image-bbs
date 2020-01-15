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

Route::get('/', 'IndexController@index')->name('index');

Route::get('index', function () {
    // return view('welcome');
    return redirect('/');
});
Route::post('confirm', 'IndexController@confirm')->name('threadconfirm');
Route::post('success', 'IndexController@success')->name('threadsuccess');
Route::get('listofposts', 'IndexController@listofposts')->name('listofposts');
Route::get('thread/{threadId}', 'ThreadController@thread')->name('thread');
Route::post('/thread/{threadId}/confirm', 'ThreadController@confirm')->name('postconfirm');
Route::post('/thread/{threadId}/success', 'ThreadController@success')->name('postsuccess');