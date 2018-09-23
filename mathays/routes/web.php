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

Route::group(['prefix' => 'v1/api'], function() {
    Route::get('get-home-material', 'PublicController@home');
    Route::get('get-blog', 'PublicController@blog');
    Route::get('get-videos', 'PublicController@videos');
    Route::post('get-video', 'PublicController@video');
    Route::post('get-post', 'PublicController@post');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/admin', 'HomeController@index')->name('home');
});

Route::group([], function () {
    if(!request()->ajax()) {
        Route::get('/{vue?}', 'PublicController@index')->where('vue', '[\/\w\.-]*');
    }
});
