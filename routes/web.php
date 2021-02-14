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

Route::get('/', 'ShopController@index');

Route::get('/images', 'ShopController@images');

Route::get('/mycart', 'ShopController@myCart')->middleware('auth');//カートの中身はログインしているユーザーにしか見せない
Route::post('/mycart', 'ShopController@addMycart');//カートに商品を追加する

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//これを消すとログイン後に移管するページがなくてバグる
