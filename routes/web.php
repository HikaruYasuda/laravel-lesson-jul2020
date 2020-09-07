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

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::get('/', 'HomeController@index')->name('index');

Route::middleware('auth')->group(function() {
    Route::post('/create', 'HomeController@store')->name('store');
    Route::get('/{thing}', 'HomeController@edit')->name('edit');
    Route::put('/{thing}', 'HomeController@update')->name('update');
    Route::delete('/{thing}', 'HomeController@destroy')->name('destroy');
});

Route::middleware('guest')->group(function() {
    Route::post('/{thing}/likes', 'LikeController@store')->name('like.store');
    Route::delete('/{thing}/likes', 'LikeController@destroy')->name('like.destroy');
});
