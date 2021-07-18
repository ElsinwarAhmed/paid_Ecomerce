<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;





Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::group([], function () {
            Route::get('/', 'SiteController@index')->name('home');
            Route::get('category/{slug}', 'CategoryController@productBySlug')->name('category');
            Route::get('product/{slug}', 'ProductController@productBySlug')->name('product.details');
        });

        Route::group(['middleware' => 'auth:web'], function () {
            Route::get('/verify', 'VerificationCodeController@getVerifyPage')->name('verify-page');
            Route::post('/verify-user', 'VerificationCodeController@verify')->name('verify-user');

            // ============ wishlist ===========
            Route::group(['prefix' => 'wishlist'], function () {
                Route::post('/', 'WishlistController@store')->name('wishlist.store');
                Route::delete('/delete', 'WishlistController@delete')->name('wishlist.delete');
                Route::get('/products', 'WishlistController@index')->name('wishlist.products.index');
            });


            // ============ cart ===========
            Route::group(['prefix' => 'cart'], function () {
                Route::get('/', 'CartController@index')->name('cart.index');
                Route::post('/add/{slug?}', 'CartController@postAdd')->name('cart.add');
                Route::post('/update/{slug}', 'CartController@postUpdate')->name('cart.update');
                Route::post('/update-all', 'CartController@postUpdateAll')->name('cart.update-all');
            });
        });


        Route::group(['middleware' => ['auth:web', 'VerifyUser']], function () {
            Route::get('/profile', function () {
                return 'you are verified';
            });
        });
    }
);
