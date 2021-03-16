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

Route::get('/images', 'ShopController@images');//製品ジャンル画像を一覧するアクション

Route::get('/product/{stocks_id}', 'ShopController@singleProduct');//stockテーブルのidごとの個別ページ
//stock_idという変数をとりあえず作る

Route::get('/search', 'ShopController@searchItems');//検索アクション
//ジャンル/key=検索キーワード

Route::group(['middleware' => ['auth']], function () {//ログインしている人にしか使わせないアクション
    Route::get('/mycart', 'ShopController@myCart');
    Route::post('/mycart', 'ShopController@addMycart');//カートに商品を追加する
    Route::post('/cartdelete', 'ShopController@deleteCart');//カートから商品を削除する
    Route::post('/checkout', 'ShopController@checkout');//支払いのアクション
    Route::get('/favorite', 'ShopController@myFavorite');//お気に入り表示
    Route::post('/favorite', 'ShopController@addMyfavorite');//お気に入り追加
    Route::post('/favoritedelete', 'ShopController@deleteFavorite');//お気に入り削除する

    Route::get('/orderhistory', 'ShopController@orderHistory');//購入履歴表示
    Route::get('/searchorderhistory', 'ShopController@searchOrderHistory');//購入履歴検索
    
    Route::get('/mypage', 'UserController@myPage');//マイページ表示
    Route::post('/mypage', 'UserController@myPageUpdate');//ユーザー情報編集

    Route::get('user/index', 'UserController@index');
    Route::get('user/edit', 'UserController@edit');
    Route::post('user/edit', 'UserController@update');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');//これを消すとログイン後に移管するページがなくてバグる
