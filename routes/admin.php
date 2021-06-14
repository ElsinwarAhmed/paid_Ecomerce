<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
            Route::get('/login', 'LoginController@login')->name('admin.login');
            Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');
        });


        Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
            Route::get('/', 'DashboardController@index')->name('admin.dashboard');
            Route::group(['prefix' => 'settings',], function () {
                Route::get('shipping-method/{type}', 'SettingController@editShippings')->name('admin.settings.editShipping');
                Route::post('shipping-method/{id}', 'SettingController@updateShippings')->name('admin.settings.updateShipping');
            });
        });
    }
);
