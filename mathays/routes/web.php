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
    Route::get('get-home-material', 'HomeController@home');
    Route::get('get-blog', 'HomeController@blog');
    Route::get('get-videos', 'HomeController@videos');
    Route::post('get-video', 'HomeController@video');
    Route::post('get-post', 'HomeController@post');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/admin', 'HomeController@index')->name('home');
});

Route::group([], function () {
    if(!request()->ajax()) {
        Route::get('/{vue?}', function() {
            return view('index');
        })->where('vue', '[\/\w\.-]*');
    }
});
