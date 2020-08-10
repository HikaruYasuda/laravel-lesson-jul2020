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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'HomeController@index')->name('index');
Route::post('/create', 'HomeController@store')->name('store');
Route::get('/{thing}', 'HomeController@edit')->name('edit');
Route::put('/{thing}', 'HomeController@update')->name('update');
Route::delete('/{thing}', 'HomeController@destroy')->name('destroy');
