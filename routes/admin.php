<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

define('PAGINATW_COUNT', 5);
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
            Route::get('/logout', 'LoginController@logout')->name('admin.logout');

            // ======= profile =========
            Route::group(['prefix' => 'profile',], function () {
                Route::get('edit', 'ProfileController@editProfile')->name('admin.profile.edit');
                Route::post('update/{id}', 'ProfileController@updateProfile')->name('admin.profile.update');
            });

            // ======= settings =========
            Route::group(['prefix' => 'settings',], function () {
                Route::get('shipping-method/{type}', 'SettingController@editShippings')->name('admin.settings.editShipping');
                Route::post('shipping-method/{id}', 'SettingController@updateShippings')->name('admin.settings.updateShipping');
            });


            // ======= Category =========
            Route::group(['prefix' => 'categories',], function () {
                Route::get('/', 'CategoryController@index')->name('admin.categories');
                Route::get('create', 'CategoryController@create')->name('admin.categories.create');
                Route::post('store', 'CategoryController@store')->name('admin.categories.store');
                Route::get('edit\{cat_id}', 'CategoryController@edit')->name('admin.categories.edit');
                Route::post('update\{cat_id}', 'CategoryController@update')->name('admin.categories.update');
                Route::get('delete\{cat_id}', 'CategoryController@delete')->name('admin.categories.delete');
                Route::get('changeStatus\{cat_id}', 'CategoryController@changeStatus')->name('admin.categories.status');
            });


            // ======= Brands =========
            Route::group(['prefix' => 'brands',], function () {
                Route::get('/', 'BrandController@index')->name('admin.brands');
                Route::get('create', 'BrandController@create')->name('admin.brands.create');
                Route::post('store', 'BrandController@store')->name('admin.brands.store');
                Route::get('edit\{brand_id}', 'BrandController@edit')->name('admin.brands.edit');
                Route::post('update\{brand_id}', 'BrandController@update')->name('admin.brands.update');
                Route::get('delete\{brand_id}', 'BrandController@delete')->name('admin.brands.delete');
                Route::get('changeStatus\{brand_id}', 'BrandController@changeStatus')->name('admin.brands.status');
            });


            // ======= Tags =========
            Route::group(['prefix' => 'tags',], function () {
                Route::get('/', 'TagController@index')->name('admin.tags');
                Route::get('create', 'TagController@create')->name('admin.tags.create');
                Route::post('store', 'TagController@store')->name('admin.tags.store');
                Route::get('edit\{tag_id}', 'TagController@edit')->name('admin.tags.edit');
                Route::post('update\{tag_id}', 'TagController@update')->name('admin.tags.update');
                Route::get('delete\{tag_id}', 'TagController@delete')->name('admin.tags.delete');
            });
        });
    }
);
