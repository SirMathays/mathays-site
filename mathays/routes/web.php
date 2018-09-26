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

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    if(!request()->ajax()) Route::get('/{vue?}', 'HomeController@index')->where('vue', '[\/\w\.-]*');
});

Route::group(['prefix' => 'v1/api'], function() {
    Route::get('get-home-material', 'PublicController@home');

    // Public blog routes
    Route::get('get-blog', 'PublicController@blog');
    Route::post('get-post', 'PublicController@post');

    // Public video routes
    Route::get('get-videos', 'PublicController@videos');
    Route::post('get-video', 'PublicController@video');

    Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
        Route::get('get-dashboard-material', 'HomeController@dashboard');

        // Admin blog routes
        Route::get('post-index', 'BlogPostController@index');
        Route::post('get-post', 'BlogPostController@edit');
        Route::post('save-post', 'BlogPostController@save');
        Route::post('delete-post', 'BlogPostController@delete');

        // Admin blog routes
        Route::get('video-index', 'VideoController@index');        
        Route::post('get-video', 'VideoController@edit');
        Route::post('save-video', 'VideoController@save');
        Route::post('delete-video', 'VideoController@delete');
    });
});

Route::group([], function () {
    if(!request()->ajax()) Route::get('/{vue?}', 'PublicController@index')->where('vue', '[\/\w\.-]*');
});
