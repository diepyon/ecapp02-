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
    /*----
    カート
    ----*/    
    Route::get('/mycart', 'ShopController@myCart');
    Route::post('/mycart', 'ShopController@addMycart');//カートに商品を追加する
    Route::post('/cartdelete', 'ShopController@deleteCart');//カートから商品を削除する    
    Route::post('/checkout', 'ShopController@checkout');//支払いのアクション
    Route::get('/checkout', 'HomeController@index')->name('home');//checkoutになんとなくアクセスしてしまった場合にはindexを表示

    /*----
    お気に入り
    ----*/
    Route::get('/favorite', 'ShopController@myFavorite');//お気に入り表示
    Route::post('/favorite', 'ShopController@addMyfavorite');//お気に入り追加
    Route::post('/favoritedelete', 'ShopController@deleteFavorite');//お気に入り削除する

    /*----
    購入履歴
    ----*/    
    Route::get('/orderhistory', 'ShopController@orderHistory');//購入履歴表示
    Route::get('/searchorderhistory', 'ShopController@searchOrderHistory');//購入履歴検索

    /*----
    ダウンロード
    ----*/    
    Route::post('/download', 'StockController@download');//商品強制ダウンロード

    /*----
    ユーザー情報
    ----*/    
    Route::get('/account', 'UserController@myPage')->name('account');//マイページ表示
    Route::get('/account/edit', 'UserController@myPageEdit')->name('account.edit');//マイページ編集画面表示
    Route::get('/account/update', 'UserController@myPageUpdate');
    Route::post('/account/update', 'UserController@myPageUpdate');//ユーザー情報編集アクション

    Route::post('/account/passwordupdate', 'UserController@passwordUpdate');//パスワード変更アクション（実装途中）

    Route::post('/withdrawal', 'UserController@withdrawal');//退会

    
    /*----
    作品投稿
    ----*/
    Route::post('/stock/delete', 'StockController@delete')->name('delete');//投稿を削除する
    //Route::get('/stock/delete', 'StockController@archive');
    Route::get('/stock', 'StockController@archive'); //投稿一覧ページ    
    Route::get('/stock/search', 'StockController@searchPosts');//投稿ページ検索
    Route::get('/stock/create', 'StockController@showCreateForm')->name('create');;//投稿フォームページ
    Route::post('/stock', 'StockController@create');
    Route::get('/stock/{stock_id}', 'StockController@detail')->name('stocks.detail');//投稿確認ページ
    Route::get('/stock/{stock_id}/edit', 'StockController@edit')->name('stocks.edit');//投稿編集ページ
    Route::post('/stock/{stock_id}/update', 'StockController@update')->name('stocks.update');//投稿編集からのポストアクション

    /*----
    管理者権限（管理者じゃなくても触れそうなので要修正）
    ----*/
    Route::post('/stock/approval', 'ConversionController@approval');//審査待ちの作品を承認（公開）
    Route::post('/stock/reject', 'ConversionController@reject');//審査待ちの作品を承認（公開）

    Route::post('/account/edit', 'UserController@userEdit');//ユーザー情報を編集(ノーマルユーザーのget　/account/editと名前ぶってる)

    Route::post('/account/{user_id}/delete', 'UserController@userDelete');//管理者がユーザー消すやつ

});
Auth::routes();



Route::get('/henkan', 'ConversionController@henkan');//動画変換、後で消す
Route::get('/henkan2', 'ConversionController@henkan2');//動画変換、後で消す

Route::get('/ongen', 'StockController@ongen');//音源変換、後で消す

Route::get('/gousei', 'ConversionController@gousei');//音源合成、後で消す

Route::get('/cmd', 'ConversionController@cmd');//コマンド実行テスト、後で消す


Route::get('/home', 'HomeController@index')->name('home');//LoginControllerとブレードを書き換えて「dashboard」にする？
