<?php

// PUBLIC HOME ROUTES
Route::get('get-home-material', 'PublicController@home');

// PUBLIC BLOG ROUTES
Route::get('get-blog', 'PublicController@blog');
Route::post('get-post', 'PublicController@post');

// PUBLIC VIDEO ROUTES
Route::get('get-videos', 'PublicController@videos');
Route::post('get-video', 'PublicController@video');

// ADMIN ROUTES
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    // ADMIN ROOT DATA ROUTE
    Route::get('get-user', 'AdminController@getUser');
    
    // ADMIN DASHBOARD ROUTES
    Route::get('get-dashboard-material', 'AdminController@dashboard');

    // ADMIN BLOG ROUTES
    Route::get('post-index', 'Admin\BlogPostController@index');
    Route::post('get-post', 'Admin\BlogPostController@edit');
    Route::post('save-post', 'Admin\BlogPostController@save');
    Route::post('delete-post', 'Admin\BlogPostController@delete');

    // ADMIN BLOG ROUTES
    Route::get('video-index', 'Admin\VideoController@index');
    Route::post('get-video', 'Admin\VideoController@edit');
    Route::post('save-video', 'Admin\VideoController@save');
    Route::post('delete-video', 'Admin\VideoController@delete');

    // ADMIN SETTING ROUTES
    Route::get('setting-index', 'Admin\SettingController@index');
    Route::post('store-settings', 'Admin\SettingController@store');

    // ADMIN PERSONAL ROUTES
    Route::group(['prefix' => 'personal'], function() {
        Route::get('get-modes', 'Admin\PersonalModeController@getModes');
        Route::post('get-mode-content', 'Admin\PersonalModeController@getModeContent');
    });
});

// PERSONAL ROUTES
Route::group(['middleware' => 'auth', 'prefix' => 'personal'], function() {
    // PERSONAL ROOT DATA ROUTE
    Route::post('get-base-data', 'PersonalController@getBaseData');
    Route::post('get-modes', 'PersonalController@getModes');
    Route::post('get-feeds', 'PersonalController@getFeeds');
}); 