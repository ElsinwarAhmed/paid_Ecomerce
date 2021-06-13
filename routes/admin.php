<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    Route::get('/login', 'LoginController@login')->name('admin.login');
    Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');
});


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
});
