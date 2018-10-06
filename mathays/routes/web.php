<?php

// ADMIN ROUTER FUNCTIONALITY
Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'admin'], function() {
        if(!request()->ajax()) Route::get('/{vue?}', 'AdminController@index')->where('vue', '[\/\w\.-]*');
    });

    Route::group(['prefix' => 'personal'], function() {
        if(!request()->ajax()) Route::get('/{vue?}', 'PersonalController@index')->where('vue', '[\/\w\.-]*');
    });
});

// PUBLIC ROUTER FUNCTIONALITY
Route::group([], function() {
    if(!request()->ajax()) Route::get('/{vue?}', 'PublicController@index')->where('vue', '[\/\w\.-]*');
});
